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
}
