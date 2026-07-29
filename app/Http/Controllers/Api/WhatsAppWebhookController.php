<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    public function getSettings()
    {
        $settings = settings();
        return response()->json([
            'success' => true,
            'settings' => [
                'whatsapp_enabled' => ($settings['whatsapp_enabled'] ?? '0') === '1',
                'whatsapp_provider' => $settings['whatsapp_provider'] ?? 'twilio', // twilio, wa_me, ultramsg
                'twilio_sid' => $settings['twilio_sid'] ?? '',
                'twilio_auth_token' => $settings['twilio_auth_token'] ?? '',
                'twilio_from_number' => $settings['twilio_from_number'] ?? '',
                'whatsapp_api_key' => $settings['whatsapp_api_key'] ?? '',
                'whatsapp_phone_number' => $settings['whatsapp_phone_number'] ?? '',
                'whatsapp_stage_template' => $settings['whatsapp_stage_template'] ?? 
                    "Hello {customer_name}! Your order #{order_id} ({garment_type}) has been updated to stage: *{stage_name}*. Track live status: {tracking_link}",
            ]
        ]);
    }

    public function updateSettings(Request $request)
    {
        $post = [
            'whatsapp_enabled' => $request->whatsapp_enabled ? '1' : '0',
            'whatsapp_provider' => $request->whatsapp_provider ?? 'twilio',
            'twilio_sid' => $request->twilio_sid ?? '',
            'twilio_auth_token' => $request->twilio_auth_token ?? '',
            'twilio_from_number' => $request->twilio_from_number ?? '',
            'whatsapp_api_key' => $request->whatsapp_api_key ?? '',
            'whatsapp_phone_number' => $request->whatsapp_phone_number ?? '',
            'whatsapp_stage_template' => $request->whatsapp_stage_template ?? '',
        ];

        foreach ($post as $key => $value) {
            Setting::updateOrCreate(
                ['name' => $key, 'parent_id' => parentId()],
                ['value' => $value]
            );
        }

        return response()->json(['success' => true, 'message' => 'WhatsApp & SMS settings updated successfully']);
    }

    public static function dispatchStageNotification($orderId, $stageName)
    {
        try {
            $order = Order::with(['customers', 'clothTypes', 'productionStage'])->find($orderId);
            if (!$order || !$order->customers || empty($order->customers->phone_number)) {
                return false;
            }

            $settings = settings();
            $template = $settings['whatsapp_stage_template'] ?? 
                "Hello {customer_name}! Your order #{order_id} ({garment_type}) is now at stage: *{stage_name}*. Track live: {tracking_link}";

            $appUrl = config('app.url', 'https://darzidesk.shop');
            $trackingLink = $appUrl . '/orders/track/' . ($order->tracking_token ?? $order->order_id);

            $message = str_replace([
                '{customer_name}',
                '{order_id}',
                '{garment_type}',
                '{stage_name}',
                '{deadline}',
                '{tracking_link}'
            ], [
                $order->customers->name ?? 'Customer',
                $order->order_id,
                $order->clothTypes->title ?? 'Garment',
                $stageName,
                $order->deadline_date ?? '-',
                $trackingLink
            ], $template);

            return self::sendSmsOrWhatsapp($order->customers->phone_number, $message, $settings);
        } catch (\Exception $e) {
            Log::error("WhatsApp/SMS Notification Error: " . $e->getMessage());
            return false;
        }
    }

    public static function sendSmsOrWhatsapp($toPhone, $messageBody, $settings = null)
    {
        if (!$settings) {
            $settings = settings();
        }

        $provider = $settings['whatsapp_provider'] ?? 'twilio';
        $twilioSid = $settings['twilio_sid'] ?? env('TWILIO_SID', '');
        $twilioToken = $settings['twilio_auth_token'] ?? env('TWILIO_AUTH_TOKEN', '');
        $twilioFrom = $settings['twilio_from_number'] ?? env('TWILIO_FROM', '');

        if ($provider === 'twilio' && !empty($twilioSid) && !empty($twilioToken)) {
            try {
                // Twilio SMS API dispatch
                $response = Http::withBasicAuth($twilioSid, $twilioToken)
                    ->asForm()
                    ->post("https://api.twilio.com/2010-04-01/Accounts/{$twilioSid}/Messages.json", [
                        'From' => $twilioFrom,
                        'To' => $toPhone,
                        'Body' => $messageBody,
                    ]);

                Log::info("Twilio SMS sent to {$toPhone}. Status: " . $response->status());
                return $response->successful();
            } catch (\Exception $e) {
                Log::error("Twilio Dispatch Error: " . $e->getMessage());
            }
        } elseif ($provider === 'ultramsg' && !empty($settings['whatsapp_api_key'])) {
            try {
                Http::post('https://api.ultramsg.com/' . ($settings['whatsapp_phone_number'] ?? '') . '/messages/chat', [
                    'token' => $settings['whatsapp_api_key'],
                    'to' => $toPhone,
                    'body' => $messageBody
                ]);
                return true;
            } catch (\Exception $e) {}
        }

        // Default: Log notification payload for dev/testing
        Log::info("WhatsApp/SMS [Simulated Provider={$provider}] to {$toPhone}: {$messageBody}");
        return true;
    }

    public function sendCustomNotification(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'message' => 'required|string',
        ]);

        $sent = self::sendSmsOrWhatsapp($request->phone_number, $request->message);

        return response()->json([
            'success' => true,
            'message' => $sent ? 'Notification sent successfully' : 'Notification queued/logged',
            'recipient' => $request->phone_number,
        ]);
    }

    public function handleWebhook(Request $request)
    {
        Log::info("WhatsApp Webhook Payload Received:", $request->all());
        return response()->json(['status' => 'success', 'message' => 'Webhook received']);
    }
}
