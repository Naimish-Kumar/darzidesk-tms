<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $newStatus;
    public $tenantId;

    public function __construct(Order $order, string $newStatus)
    {
        $this->order = $order;
        $this->newStatus = $newStatus;
        $this->tenantId = $order->parent_id;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('tenant.' . $this->tenantId),
            new Channel('orders.' . $this->order->id),
        ];
    }

    public function broadcastAs()
    {
        return 'order.status.updated';
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_id,
            'customer_name' => $this->order->customers->name ?? 'Customer',
            'cloth_type' => $this->order->clothTypes->title ?? 'Bespoke Garment',
            'status' => $this->newStatus,
            'updated_at' => now()->toIso8601String(),
        ];
    }
}
