<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Measurement;
use App\Models\MeasurementHistory;
use App\Models\Invoice;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerPortalController extends Controller
{
    /**
     * Self-registration for end customers
     */
    public function registerCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string',
            'city' => 'nullable|string',
            'shop_id' => 'nullable|integer',
            'device_name' => 'required|string',
        ]);

        $parentId = $request->shop_id ?? 1;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'type' => 'customer',
            'parent_id' => $parentId,
            'lang' => 'en',
            'is_active' => 1,
        ]);

        return response()->json([
            'success' => true,
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'city' => $user->city,
                'type' => $user->type,
                'parent_id' => $user->parent_id,
            ]
        ]);
    }

    /**
     * Customer Dashboard summary
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $activeOrders = Order::where('customer_id', $user->id)
            ->whereNotIn('status', ['Delivered', 'Cancelled'])
            ->with(['productionStage', 'clothTypes'])
            ->get();

        $upcomingAppointments = Appointment::where('customer_id', $user->id)
            ->where('appointment_date', '>=', date('Y-m-d'))
            ->orderBy('appointment_date', 'asc')
            ->get();

        $unpaidInvoices = Invoice::where('customer_id', $user->id)
            ->where('payment_status', '!=', 'Paid')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'active_orders_count' => $activeOrders->count(),
                'active_orders' => $activeOrders,
                'upcoming_appointments' => $upcomingAppointments,
                'unpaid_invoices_count' => $unpaidInvoices->count(),
            ]
        ]);
    }

    /**
     * Get customer's orders with progress stage timeline
     */
    public function myOrders(Request $request)
    {
        $user = $request->user();

        $orders = Order::where('customer_id', $user->id)
            ->with(['productionStage', 'clothTypes'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_id' => $order->order_id,
                    'cloth_type' => $order->clothTypes->title ?? 'Custom Garment',
                    'status' => $order->status,
                    'stage_name' => $order->productionStage->name ?? 'Pending',
                    'deadline_date' => $order->deadline_date,
                    'tracking_token' => $order->tracking_token,
                    'total_amount' => $order->total_amount ?? 0,
                    'created_at' => $order->created_at ? $order->created_at->format('Y-m-d H:i') : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Get customer's saved body measurements & version history
     */
    public function myMeasurements(Request $request)
    {
        $user = $request->user();

        $measurements = Measurement::where('customer', $user->id)
            ->with(['clothTypes', 'users'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'measurement_id' => $m->measurement_id,
                    'cloth_type' => $m->clothTypes->title ?? 'Bespoke Garment',
                    'cloth_type_id' => $m->cloth_type,
                    'responsible_name' => $m->users->name ?? 'Master Tailor',
                    'date' => $m->date ?? ($m->created_at ? $m->created_at->format('Y-m-d') : date('Y-m-d')),
                    'measurement_detail' => $m->measurement_detail,
                    'details' => $m->measurement_detail,
                    'posture_adjustments' => $m->posture_adjustments,
                    'created_at' => $m->created_at ? $m->created_at->format('Y-m-d H:i') : null,
                ];
            });

        $history = MeasurementHistory::where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($h) {
                return [
                    'id' => $h->id,
                    'field_name' => $h->field_name,
                    'old_value' => $h->old_value,
                    'new_value' => $h->new_value,
                    'changed_at' => $h->created_at ? $h->created_at->format('d M Y • H:i') : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'measurements' => $measurements,
                'history' => $history,
            ]
        ]);
    }

    /**
     * Get customer's invoices and payment receipts
     */
    public function myInvoices(Request $request)
    {
        $user = $request->user();

        $invoices = Invoice::where('customer_id', $user->id)
            ->with(['items', 'payments', 'shop:id,name,shop_name,phone_number,address,city'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $invoices
        ]);
    }

    /**
     * Get customer's appointments
     */
    public function myAppointments(Request $request)
    {
        $user = $request->user();

        $appointments = Appointment::where('customer_id', $user->id)
            ->with('tailor:id,name,shop_name,phone_number')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $appointments
        ]);
    }

    /**
     * Book fitting/consultation appointment with a tailor shop
     */
    public function bookAppointment(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'shop_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'time_slot' => 'required|string',
            'service_type' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            'customer_id' => $user->id,
            'tailor_id' => $request->shop_id,
            'parent_id' => $request->shop_id,
            'appointment_date' => $request->appointment_date,
            'time_slot' => $request->time_slot,
            'service_type' => $request->service_type ?? 'Trial Session',
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Send notification to Tailor Shop Owner
        NotificationController::createNotification(
            $request->shop_id,
            'appointment',
            'New Fitting Appointment Request',
            "Customer {$user->name} requested a fitting appointment for " . ($request->appointment_date ?? 'upcoming date') . " ({$request->time_slot}).",
            $request->shop_id
        );

        return response()->json([
            'success' => true,
            'message' => 'Appointment booked successfully! Tailor shop will confirm your slot.',
            'data' => $appointment
        ]);
    }

    /**
     * Request custom stitching order / inquiry with a tailor shop
     */
    public function requestCustomOrder(Request $request)
    {
        $user = $request->user() ?? auth()->user();
        $userId = $user?->id ?? 1;

        $request->validate([
            'shop_id' => 'required|integer',
            'cloth_type_id' => 'nullable|integer',
            'cloth_title' => 'required|string|max:255',
            'fabric_details' => 'nullable|string',
            'deadline_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $orderId = 'ORD-' . strtoupper(\Str::random(6));
        $trackingToken = \Str::uuid()->toString();

        $order = Order::create([
            'order_id' => $orderId,
            'tracking_token' => $trackingToken,
            'customer_id' => $userId,
            'cloth_type' => $request->cloth_type_id ?? 1,
            'order_date' => date('Y-m-d'),
            'deadline_date' => $request->deadline_date,
            'quantity' => 1,
            'febric' => $request->fabric_details ?? 'Customer Provided Fabric',
            'status' => 'Pending Approval',
            'notes' => 'Custom Request (' . $request->cloth_title . '): ' . ($request->notes ?? ''),
            'parent_id' => $request->shop_id,
        ]);

        // Send notification to Tailor Shop Owner
        NotificationController::createNotification(
            $request->shop_id,
            'order',
            'New Custom Stitching Order Inquiry',
            "Customer {$user->name} submitted a custom order inquiry for {$request->cloth_title} (Target: {$request->deadline_date}).",
            $request->shop_id
        );

        return response()->json([
            'success' => true,
            'message' => 'Custom stitching order request submitted to tailor shop!',
            'data' => [
                'order' => $order,
                'tracking_token' => $trackingToken,
            ]
        ]);
    }
}
