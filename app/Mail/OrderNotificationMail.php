<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $title;
    public $customMessage;

    public function __construct(Order $order, string $title = 'Order Confirmation', string $customMessage = '')
    {
        $this->order = $order;
        $this->title = $title;
        $this->customMessage = $customMessage;
    }

    public function build()
    {
        return $this->subject("✂️ DarziDesk — {$this->title} (#{$this->order->order_id})")
            ->view('email.order_notification');
    }
}
