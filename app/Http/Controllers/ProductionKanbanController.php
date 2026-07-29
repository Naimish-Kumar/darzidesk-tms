<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductionStage;
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
            ->get();

        $kanbanData = [];
        foreach ($stages as $stage) {
            $kanbanData[$stage->id] = [
                'stage' => $stage,
                'orders' => $orders->where('production_stage_id', $stage->id),
            ];
        }

        return view('production.kanban', compact('stages', 'kanbanData'));
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

        // If moved to Ready for Pickup / Delivered, sync status if relevant
        if ($stage->slug === 'delivered') {
            $order->status = 'delivered';
        } elseif ($stage->slug === 'ready-for-pickup' || $stage->slug === 'finishing-qc') {
            $order->status = 'completed';
        } elseif ($stage->slug === 'cutting' || $stage->slug === 'stitching') {
            $order->status = 'in_progress';
        }

        $order->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('Order stage updated successfully.'),
                'order' => $order,
            ]);
        }

        return redirect()->back()->with('success', __('Order stage updated successfully.'));
    }
}
