<?php

namespace App\Helper;

use App\Models\Order;
use App\Models\Notification;

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
        $trialDate = !empty($order->trial_date) ? dateFormat($order->trial_date) : 'Soon';

        return "Hello {$customerName},\n\nYour tailoring order #{$orderId} is progressing well! ✂️\nThis is a friendly reminder for your Trial/Fitting date: *{$trialDate}*.\n\nTrack your order status & digital receipt:\n{$trackingUrl}\n\nThank you for choosing DarziDesk!";
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

        return "Hi {$customerName},\n\nGreat news! Your tailoring order #{$orderId} status has been updated to: *{$stageName}* 🎉\n\nView live status & order details:\n{$trackingUrl}\n\nDarziDesk Tailoring";
    }

    /**
     * Generate order confirmation & digital receipt message for WhatsApp.
     */
    public static function getOrderConfirmationMessage(Order $order)
    {
        $customerName = $order->customers->name ?? 'Valued Customer';
        $orderId = orderPrefix() . $order->order_id;
        $amount = priceFormat($order->total_amount ?? $order->amount);
        $trackingUrl = route('order.public.track', $order->tracking_token ?? $order->id);

        return "Dear {$customerName},\n\nThank you for your order with DarziDesk! 🧾✨\nOrder #: *{$orderId}*\nTotal Amount: *{$amount}*\n\nView your digital invoice & live tracking details here:\n{$trackingUrl}\n\nWe appreciate your business!";
    }

    /**
     * Generate ready for pickup message.
     */
    public static function getReadyForPickupMessage(Order $order)
    {
        $customerName = $order->customers->name ?? 'Valued Customer';
        $orderId = orderPrefix() . $order->order_id;
        $trackingUrl = route('order.public.track', $order->tracking_token ?? $order->id);

        return "Dear {$customerName},\n\nYour order #{$orderId} is finished & READY FOR PICKUP! 🛍️✨\n\nPlease visit our shop to try it on and collect your garments.\n\nDigital Receipt & Track Portal:\n{$trackingUrl}\n\nThank you!";
    }

    /**
     * Dispatch Twilio SMS notification independently if configured.
     */
    public static function dispatchTwilioNotification(Order $order, string $module = 'order_status_update')
    {
        try {
            $notification = Notification::where('parent_id', parentId())->where('module', $module)->first();
            if ($notification && $notification->enabled_sms == 1 && !empty($notification->sms_message)) {
                $twilioSid = getSettingsValByName('twilio_sid');
                $customerPhone = $order->customers->phone_number ?? '';
                if (!empty($twilioSid) && !empty($customerPhone)) {
                    $replaced = MessageReplace($notification, $order->id);
                    send_twilio_msg($customerPhone, $replaced['sms_message']);
                }
            }
        } catch (\Exception $e) {
            \Log::error("Twilio notification dispatch error: " . $e->getMessage());
        }
    }
}
