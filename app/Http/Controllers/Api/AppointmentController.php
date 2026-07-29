<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::where('parent_id', parentId())
            ->with(['customer', 'order']);

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'asc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'customer_id' => $a->customer_id,
                    'customer_name' => $a->customer->name ?? 'Guest',
                    'customer_phone' => $a->customer->phone_number ?? '',
                    'order_id' => $a->order->order_id ?? '-',
                    'appointment_date' => $a->appointment_date,
                    'appointment_time' => $a->appointment_time ?? '10:00 AM',
                    'type' => $a->type,
                    'status' => $a->status,
                    'notes' => $a->notes,
                ];
            });

        return response()->json(['success' => true, 'appointments' => $appointments]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'type' => 'required|in:in_store_fitting,home_pickup,trial,consultation',
        ]);

        $appointment = Appointment::create([
            'customer_id' => $request->customer_id,
            'order_id' => $request->order_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time ?? '11:00 AM',
            'type' => $request->type,
            'status' => 'scheduled',
            'notes' => $request->notes,
            'parent_id' => parentId(),
        ]);

        return response()->json(['success' => true, 'message' => 'Appointment scheduled successfully', 'appointment' => $appointment]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:scheduled,completed,cancelled']);

        $appointment = Appointment::where('parent_id', parentId())->findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        return response()->json(['success' => true, 'message' => 'Appointment status updated', 'appointment' => $appointment]);
    }
}
