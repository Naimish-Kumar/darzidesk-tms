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
                'customer_name' => $o->customers->name ?? 'Unknown',
                'cloth_type' => $o->clothTypes->title ?? 'Unknown',
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
                'customer' => $order->customers->name ?? 'Unknown',
                'phone' => $order->customers->phone_number ?? 'N/A',
                'cloth_type' => $order->clothTypes->title ?? 'Unknown',
                'fabric' => $order->febric,
                'color' => $order->febric_color,
                'quantity' => $order->quantity,
                'order_date' => $order->order_date,
                'deadline' => $order->deadline_date,
                'status' => $order->status,
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

        return response()->json([
            'success' => true,
            'message' => 'Order status updated to ' . Order::$status[$request->status],
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
}
