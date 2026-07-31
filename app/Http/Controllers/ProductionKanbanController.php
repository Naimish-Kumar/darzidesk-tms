<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductionStage;
use App\Models\ProductionAssignment;
use App\Models\User;
use Illuminate\Http\Request;

class ProductionKanbanController extends Controller
{
    public function index()
    {
        $stages = ProductionStage::orderBy('order_index', 'asc')->get();

        if ($stages->isEmpty()) {
            $defaults = ProductionStage::getDefaultStages();
            foreach ($defaults as $default) {
                ProductionStage::create([
                    'name' => $default['name'],
                    'slug' => $default['slug'],
                    'order_index' => $default['order_index'],
                    'color_code' => $default['color_code'],
                    'is_default' => true,
                ]);
            }
            $stages = ProductionStage::orderBy('order_index', 'asc')->get();
        }

        $firstStage = $stages->first();

        // Ensure orders without stage get assigned to default stage
        if ($firstStage) {
            Order::whereNull('production_stage_id')->update(['production_stage_id' => $firstStage->id]);
        }

        $orders = Order::with(['customers', 'clothTypes', 'users', 'productionStage', 'assignments.worker'])
            ->orderBy('id', 'desc')
            ->get();

        $kanbanData = [];
        foreach ($stages as $stage) {
            $kanbanData[$stage->id] = [
                'stage' => $stage,
                'orders' => $orders->where('production_stage_id', $stage->id),
            ];
        }

        // Tailors and Staff for assignments
        $parentId = parentId();
        $tailors = User::where(function($q) use ($parentId) {
            $q->where('parent_id', $parentId)->orWhere('id', $parentId);
        })->whereIn('type', ['employee', 'owner', 'manager'])->get();

        return view('production.kanban', compact('stages', 'kanbanData', 'tailors'));
    }

    public function updateStage(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'stage_id' => 'required|exists:production_stages,id',
        ]);

        $order = Order::findOrFail($request->order_id);
        $stage = ProductionStage::findOrFail($request->stage_id);

        $order->production_stage_id = $stage->id;

        // Sync status depending on stage slug
        if ($stage->slug === 'delivered' || $stage->slug === 'ready-for-delivery') {
            $order->status = 'delivered';
        } elseif ($stage->slug === 'trial-fitting') {
            $order->status = 'completed';
        } elseif ($stage->slug === 'cutting' || $stage->slug === 'stitching-embroidery') {
            $order->status = 'in_progress';
        } elseif ($stage->slug === 'new-order') {
            $order->status = 'pending';
        }

        $order->save();

        // Dispatch FCM Push Notification to Customer
        try {
            $orderCode = orderPrefix() . $order->order_id;
            \App\Services\FcmService::sendToUser(
                $order->customer,
                "Order Status Updated: {$orderCode}",
                "Your tailoring order #{$orderCode} is now in stage: {$stage->name}",
                [
                    'type' => 'order_status_update',
                    'order_id' => (string)$order->id,
                    'stage' => $stage->name,
                ]
            );
        } catch (\Exception $e) {
            \Log::error('FCM trigger error on stage update: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('Order stage updated successfully.'),
                'order' => $order,
            ]);
        }

        return redirect()->back()->with('success', __('Order stage updated successfully.'));
    }

    public function assignWorker(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'worker_id' => 'required|exists:users,id',
            'piece_rate_pay' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($request->order_id);

        ProductionAssignment::updateOrCreate(
            [
                'order_id' => $order->id,
                'worker_id' => $request->worker_id,
            ],
            [
                'stage_id' => $order->production_stage_id,
                'piece_rate_pay' => $request->piece_rate_pay ?? 0,
                'notes' => $request->notes,
                'assigned_at' => now(),
                'status' => 'assigned',
                'parent_id' => parentId(),
            ]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('Tailor assigned successfully.'),
            ]);
        }

        return redirect()->back()->with('success', __('Tailor assigned successfully.'));
    }
}
