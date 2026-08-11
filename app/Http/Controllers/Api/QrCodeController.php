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
            $url = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($code);
            return redirect($url);
        }
    }

    public function scan(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $rawToken = trim($request->code);
        $cleanToken = preg_replace('/^#?(ORD-)?/i', '', $rawToken);

        $parentId = parentId();

        $order = Order::where('parent_id', $parentId)
            ->where(function ($q) use ($rawToken, $cleanToken) {
                $q->where('tracking_token', $rawToken)
                  ->orWhere('order_id', $rawToken)
                  ->orWhere('id', $rawToken)
                  ->orWhere('order_id', $cleanToken)
                  ->orWhere('id', $cleanToken);
            })
            ->with(['customers', 'clothTypes', 'productionStage'])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'No active order found for barcode: ' . $rawToken,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_id' => $order->order_id ?? ('ORD-' . $order->id),
                'customer_name' => $order->customers->name ?? 'Walk-in Client',
                'customer_phone' => $order->customers->phone_number ?? '',
                'cloth_type' => $order->clothTypes->title ?? 'Bespoke Garment',
                'status' => $order->status ?? 'in_progress',
                'production_stage_id' => $order->production_stage_id ?? 1,
                'stage_name' => $order->productionStage->name ?? 'Cutting & Trimming',
                'deadline' => $order->deadline_date ?? now()->addDays(7)->format('Y-m-d'),
                'tracking_token' => $order->tracking_token ?? 'TRK-' . $order->id,
                'total_amount' => (float) ($order->total_amount ?? 0),
            ],
        ]);
    }
}
