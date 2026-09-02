<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Order::orderBy('id', 'desc');
        $currency_symbol = settings()['CURRENCY_SYMBOL'] ?? '₹';

        if ($user->type == 'customer') {
            $query->where('customer_id', $user->id);
        } elseif ($user->type == 'employee') {
            $query->where('responsible', $user->id);
        } else {
            $query->where('parent_id', parentId());
        }

        $orders = $query->get()->map(function($o) use ($currency_symbol) {
            return [
                'id' => $o->id,
                'order_id' => $o->order_id,
                'customer_id' => $o->customer_id,
                'customer_name' => $o->customers->name ?? 'Unknown',
                'cloth_type_id' => $o->cloth_type,
                'cloth_type' => $o->clothTypes->title ?? 'Unknown',
                'responsible_id' => $o->responsible,
                'order_date' => $o->order_date,
                'deadline' => $o->deadline_date,
                'status' => $o->status,
                'status_label' => Order::$status[$o->status] ?? ucfirst($o->status),
                'amount' => $currency_symbol . number_format($o->total_amount, 2),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function show($id)
    {
        $order = Order::where('id', $id)
            ->where('parent_id', parentId())
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $currency_symbol = settings()['CURRENCY_SYMBOL'] ?? '₹';

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $order->id,
                'order_id' => $order->order_id,
                'customer_id' => $order->customer_id,
                'customer' => $order->customers->name ?? 'Unknown',
                'phone' => $order->customers->phone_number ?? 'N/A',
                'cloth_type_id' => $order->cloth_type,
                'cloth_type' => $order->clothTypes->title ?? 'Unknown',
                'fabric' => $order->febric,
                'color' => $order->febric_color,
                'quantity' => $order->quantity,
                'order_date' => $order->order_date,
                'deadline' => $order->deadline_date,
                'status' => $order->status,
                'responsible_id' => $order->responsible,
                'measurements' => $order->measurement,
                'notes' => $order->notes,
                'total' => $currency_symbol . number_format($order->total_amount, 2),
            ]
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('parent_id', parentId())->first();
        
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->status = $request->status;
        $order->save();

        // Dispatch Email & WhatsApp/SMS Notification to Customer
        $statusLabel = Order::$status[$request->status] ?? ucfirst($request->status);
        if ($order->customers && !empty($order->customers->email)) {
            try {
                \Mail::to($order->customers->email)->send(
                    new \App\Mail\OrderNotificationMail(
                        $order,
                        "Status Updated to {$statusLabel}",
                        "Good news! Your bespoke order status has been updated to {$statusLabel} at our atelier."
                    )
                );
            } catch (\Throwable $e) {
                \Log::error('Order email dispatch failed: ' . $e->getMessage());
            }
        }

        try {
            \App\Http\Controllers\Api\WhatsAppWebhookController::dispatchStageNotification($order->id, $statusLabel);
        } catch (\Throwable $e) {
            \Log::error('WhatsApp notification dispatch failed: ' . $e->getMessage());
        }

        // Dispatch FCM Push Notification
        if ($order->customers && !empty($order->customers->fcm_token)) {
            try {
                \App\Services\FcmService::sendNotification(
                    $order->customers->fcm_token,
                    "✂️ DarziDesk Order Update: #{$order->order_id}",
                    "Good news! Your order status has been updated to {$statusLabel}.",
                    [
                        'order_id' => (string)$order->id,
                        'status' => $statusLabel,
                        'type' => 'order_status_update',
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    ]
                );
            } catch (\Throwable $e) {
                \Log::error('FCM push notification dispatch failed: ' . $e->getMessage());
            }
        }

        // Real-time WebSocket Event Dispatch (Pusher / Echo)
        try {
            event(new \App\Events\OrderStatusUpdatedEvent($order, $statusLabel));
            event(new \App\Events\LiveNotificationEvent(
                $order->parent_id,
                "Order Status Updated",
                "Order #{$order->order_id} has been moved to {$statusLabel}",
                "order_update",
                ['order_id' => $order->id, 'status' => $order->status]
            ));
        } catch (\Throwable $e) {
            \Log::error('WebSocket broadcast failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Order status updated to ' . (Order::$status[$request->status] ?? $request->status),
            'new_status' => $order->status
        ]);
    }

    public function getStatuses()
    {
        return response()->json([
            'success' => true,
            'data' => Order::$status
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'customer_id' => 'required',
            'order_date' => 'required',
            'deadline_date' => 'required',
            'quantity' => 'required',
            'febric' => 'required',
            'febric_color' => 'required',
            'cloth_type' => 'required',
            'measurements' => 'required|array',
        ]);

        $order = new Order();
        $order->parent_id = parentId();
        $order->order_id = $request->order_id;
        $order->customer_id = $request->customer_id;
        $order->order_date = $request->order_date;
        $order->deadline_date = $request->deadline_date;
        $order->quantity = $request->quantity;
        $order->febric = $request->febric;
        $order->febric_color = $request->febric_color;
        $order->gender = $request->gender;
        $order->cloth_type = $request->cloth_type;
        $order->status = $request->status ?? 'pending';
        $order->notes = $request->notes;
        $order->responsible = $request->responsible ?? 0;
        $order->measurement = $request->measurements; // Laravel cast to JSON automatically if configured, else we should json_encode. Order model has 'measurement' => 'array' or 'json'? Wait, let's json_encode just to be safe if not casted, or let Laravel handle it. Actually the web controller does `$order->measurement = $measurementDetail;` so it's casted.

        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('parent_id', parentId())->first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $request->validate([
            'order_id' => 'required',
            'customer_id' => 'required',
            'order_date' => 'required',
            'deadline_date' => 'required',
            'quantity' => 'required',
            'febric' => 'required',
            'cloth_type' => 'required',
            'measurements' => 'required|array',
        ]);

        $order->order_id = $request->order_id;
        $order->customer_id = $request->customer_id;
        $order->order_date = $request->order_date;
        $order->deadline_date = $request->deadline_date;
        $order->quantity = $request->quantity;
        $order->febric = $request->febric;
        $order->febric_color = $request->febric_color;
        $order->gender = $request->gender;
        $order->cloth_type = $request->cloth_type;
        $order->status = $request->status ?? $order->status;
        $order->notes = $request->notes;
        $order->responsible = $request->responsible ?? $order->responsible;
        $order->measurement = $request->measurements;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $order
        ]);
    }

    public function destroy($id)
    {
        $order = Order::where('id', $id)->where('parent_id', parentId())->first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->delete();
        return response()->json(['success' => true, 'message' => 'Order deleted successfully']);
    }

    public function downloadGarmentTagPdf($id)
    {
        $order = Order::with(['customers', 'clothTypes'])->where('id', $id)->first();
        if (!$order) {
            abort(404, 'Order not found');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.garment_tag', compact('order'));
        $pdf->setPaper([0, 0, 226.77, 425.20], 'portrait'); // 80mm x 150mm thermal tag dimensions
        return $pdf->download('GarmentTag-' . $order->order_id . '.pdf');
    }
}
