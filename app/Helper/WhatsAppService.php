<?php

namespace App\Helper;

use App\Models\Order;

class WhatsAppService
{
    /**
     * Generate a WhatsApp click-to-chat URL with prefilled message.
     */
    public static function generateClickToChatUrl($phoneNumber, $message)
    {
        // Clean phone number to digits only
        $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (empty($cleanPhone)) {
            return '#';
        }

        return 'https://wa.me/' . $cleanPhone . '?text=' . urlencode($message);
    }

    /**
     * Generate trial reminder message for WhatsApp.
     */
    public static function getTrialReminderMessage(Order $order)
    {
        $customerName = $order->customers->name ?? 'Valued Customer';
        $orderId = orderPrefix() . $order->order_id;
        $trackingUrl = route('order.public.track', $order->tracking_token ?? $order->id);

        return "Hello {$customerName},\n\nYour tailoring order #{$orderId} is progressing well! ✂️\nWe'd like to remind you of your fitting/trial appointment.\n\nTrack your order & receipt here:\n{$trackingUrl}\n\nThank you for choosing DarziDesk!";
    }

    /**
     * Generate order status update message for WhatsApp.
     */
    public static function getStatusUpdateMessage(Order $order)
    {
        $customerName = $order->customers->name ?? 'Valued Customer';
        $orderId = orderPrefix() . $order->order_id;
        $stageName = $order->productionStage->name ?? ucfirst($order->status);
        $trackingUrl = route('order.public.track', $order->tracking_token ?? $order->id);

        return "Hi {$customerName},\n\nGreat news! Your order #{$orderId} status has been updated to: *{$stageName}* 🎉\n\nView live status & details:\n{$trackingUrl}\n\nDarziDesk Tailoring";
    }
}
