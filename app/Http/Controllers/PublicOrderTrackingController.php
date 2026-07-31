<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductionStage;
use Illuminate\Http\Request;

class PublicOrderTrackingController extends Controller
{
    public function track($token = null)
    {
        $order = null;
        $searchError = null;

        if (!empty($token)) {
            // Clean token/id input (strip prefix like # or ORD-)
            $cleanQuery = trim(str_ireplace(['#', 'ORD-', 'ord-'], '', $token));

            $order = Order::where('tracking_token', $token)
                ->orWhere('order_id', $token)
                ->orWhere('order_id', $cleanQuery)
                ->orWhere('id', $cleanQuery)
                ->with(['customers', 'clothTypes', 'productionStage', 'invoices'])
                ->first();

            if (!$order) {
                $searchError = __('No tailoring order found matching code: ') . $token;
            }
        }

        $allStages = ProductionStage::orderBy('order_index', 'asc')->get();

        return view('order.track', compact('order', 'allStages', 'token', 'searchError'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'order_query' => 'required|string|max:100',
        ]);

        $query = trim(str_ireplace(['#', 'ORD-', 'ord-'], '', $request->order_query));

        $order = Order::where('tracking_token', $request->order_query)
            ->orWhere('order_id', $request->order_query)
            ->orWhere('order_id', $query)
            ->orWhere('id', $query)
            ->first();

        if ($order) {
            return redirect()->route('track.order', ['token' => $order->tracking_token ?? $order->order_id]);
        }

        return redirect()->route('track.order', ['token' => $request->order_query]);
    }

    public function qrReceipt($token)
    {
        $cleanQuery = trim(str_ireplace(['#', 'ORD-', 'ord-'], '', $token));

        $order = Order::where('tracking_token', $token)
            ->orWhere('order_id', $token)
            ->orWhere('order_id', $cleanQuery)
            ->orWhere('id', $cleanQuery)
            ->with(['customers', 'clothTypes', 'invoices'])
            ->firstOrFail();

        $trackingUrl = route('track.order', ['token' => $order->tracking_token ?? $order->order_id]);

        return view('order.qr_receipt', compact('order', 'trackingUrl'));
    }
}
