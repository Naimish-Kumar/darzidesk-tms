<?php

namespace App\Http\Controllers;

use App\Models\ProductionStage;
use App\Models\Order;
use Illuminate\Http\Request;

class ProductionPipelineController extends Controller
{
    public function index()
    {
        $stages = ProductionStage::orderBy('order_index')->get();

        if ($stages->isEmpty()) {
            foreach (ProductionStage::getDefaultStages() as $def) {
                ProductionStage::create(array_merge($def, ['parent_id' => parentId()]));
            }
            $stages = ProductionStage::orderBy('order_index')->get();
        }

        $orders = Order::with(['customer', 'clothType'])->latest()->get();
        $totalInProduction = $orders->count();
        $dueToday = $orders->where('delivery_date', date('Y-m-d'))->count();

        return view('production.index', compact('stages', 'orders', 'totalInProduction', 'dueToday'));
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
        if (!empty($stage->slug)) {
            $order->status = $stage->slug;
        }
        $order->save();

        // Dispatch FCM Push Notification & In-App Notification
        try {
            $title = "Order #{$order->order_id} Updated";
            $body = "Your order status has been updated to stage: {$stage->name}";
            if ($order->customer_id) {
                \App\Http\Controllers\Api\NotificationController::createNotification(
                    $order->customer_id,
                    'order_stage_update',
                    $title,
                    $body,
                    $order->parent_id ?? 0
                );
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('FCM stage update error: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => __('Order moved to ') . $stage->name,
        ]);
    }
}
