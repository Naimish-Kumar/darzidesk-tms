<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductionStage;
use Illuminate\Http\Request;

class PublicOrderTrackingController extends Controller
{
    public function track($token)
    {
        $order = Order::where('tracking_token', $token)
            ->with(['customers', 'clothTypes', 'productionStage', 'invoices'])
            ->firstOrFail();

        $allStages = ProductionStage::orderBy('order_index', 'asc')->get();

        return view('order.track', compact('order', 'allStages'));
    }

    public function qrReceipt($token)
    {
        $order = Order::where('tracking_token', $token)
            ->with(['customers', 'clothTypes', 'invoices'])
            ->firstOrFail();

        $trackingUrl = route('order.public.track', $token);

        return view('order.qr_receipt', compact('order', 'trackingUrl'));
    }
}
