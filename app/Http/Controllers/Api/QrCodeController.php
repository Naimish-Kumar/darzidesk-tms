<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCodeController extends Controller
{
    public function generateSvg($code)
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $svg = $writer->writeString($code);

            return response($svg)->header('Content-Type', 'image/svg+xml');
        } catch (\Exception $e) {
            // Fallback Google Chart QR API
            $url = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($code);
            return redirect($url);
        }
    }

    public function scan(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $token = $request->code;
        // Search by tracking_token or order_id
        $order = Order::where('parent_id', parentId())
            ->where(function ($q) use ($token) {
                $q->where('tracking_token', $token)
                  ->orWhere('order_id', $token)
                  ->orWhere('id', $token);
            })
            ->with(['customers', 'clothTypes', 'productionStage'])
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found for code: ' . $token], 404);
        }

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_id' => $order->order_id,
                'customer_name' => $order->customers->name ?? 'Unknown',
                'customer_phone' => $order->customers->phone_number ?? '',
                'cloth_type' => $order->clothTypes->title ?? '-',
                'status' => $order->status,
                'production_stage_id' => $order->production_stage_id,
                'stage_name' => $order->productionStage->name ?? 'Pending',
                'deadline' => $order->deadline_date,
                'tracking_token' => $order->tracking_token,
                'total_amount' => $order->total_amount,
            ],
        ]);
    }
}
