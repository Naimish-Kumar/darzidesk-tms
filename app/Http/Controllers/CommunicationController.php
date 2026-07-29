<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    /**
     * Display communication dashboard.
     */
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        return view('communication.index', compact('notifications'));
    }

    /**
     * Display fitting alerts configuration page.
     */
    public function alerts()
    {
        return view('communication.alerts');
    }

    /**
     * Display message templates library.
     */
    public function templates()
    {
        $templates = collect([
            (object)[
                'id' => 1,
                'name' => 'Fitting Appointment Reminder',
                'category' => 'Fitting Alert',
                'channel' => 'WhatsApp',
                'body' => "Dear {customer_name}, your trial fitting for Order #{order_id} is scheduled for tomorrow at {fitting_time}. Please reply YES to confirm.",
                'status' => 'Active',
            ],
            (object)[
                'id' => 2,
                'name' => 'Order Ready for Pickup',
                'category' => 'Order Status',
                'channel' => 'SMS',
                'body' => "Hello {customer_name}! Great news — your bespoke suit #{order_id} is crafted and ready for collection at our atelier.",
                'status' => 'Active',
            ],
            (object)[
                'id' => 3,
                'name' => 'Payment Deposit Received',
                'category' => 'Billing',
                'channel' => 'Email & WhatsApp',
                'body' => "Thank you {customer_name}! We received your deposit of {amount} for Order #{order_id}. Master tailor has commenced cutting.",
                'status' => 'Active',
            ],
        ]);

        return view('communication.templates', compact('templates'));
    }

    /**
     * Send test WhatsApp / SMS alert message.
     */
    public function sendAlert(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required',
            'channel' => 'required|string',
            'message' => 'required|string',
        ]);

        // Log notification record in DB
        Notification::create([
            'user_id' => auth()->id() ?? 1,
            'title' => 'Customer Alert Dispatched (' . ucfirst($validated['channel']) . ')',
            'message' => $validated['message'],
            'is_read' => 0,
        ]);

        return redirect()->back()->with('success', 'Customer alert notification dispatched successfully via ' . strtoupper($validated['channel']));
    }
}
