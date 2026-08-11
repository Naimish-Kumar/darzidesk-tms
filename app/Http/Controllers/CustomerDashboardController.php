<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Measurement;
use App\Models\Order;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Storage;

class CustomerDashboardController extends Controller
{
    /**
     * Display list of orders for logged-in customer.
     */
    public function orders(Request $request)
    {
        $userId = Auth::user()->id;
        $query = Order::where('customer_id', $userId)
            ->with(['clothTypes', 'users', 'productionStage', 'invoices'])
            ->orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('febric', 'like', "%{$search}%")
                  ->orWhere('febric_color', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10);
        $statuses = Order::$status;
        $selectedStatus = $request->status ?? '';

        return view('customer_portal.my-orders', compact('orders', 'statuses', 'selectedStatus'));
    }

    /**
     * Show detailed view of a single order.
     */
    public function orderDetail($id)
    {
        $userId = Auth::user()->id;
        $order = Order::where('customer_id', $userId)
            ->with(['clothTypes', 'users', 'productionStage', 'invoices.items', 'invoices.payments', 'materialUsages.material'])
            ->findOrFail($id);

        return view('customer_portal.order-detail', compact('order'));
    }

    /**
     * Display measurements taken for logged-in customer.
     */
    public function measurements(Request $request)
    {
        $userId = Auth::user()->id;
        $measurements = Measurement::where('customer', $userId)
            ->with(['clothTypes', 'users', 'histories'])
            ->orderBy('id', 'desc')
            ->get();

        return view('customer_portal.my-measurements', compact('measurements'));
    }

    /**
     * Display list of invoices for logged-in customer.
     */
    public function invoices(Request $request)
    {
        $userId = Auth::user()->id;
        $query = Invoice::where('customer_id', $userId)
            ->with(['items', 'payments', 'shop'])
            ->orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->paginate(10);
        $statuses = Invoice::$status;
        $selectedStatus = $request->status ?? '';

        return view('customer_portal.my-invoices', compact('invoices', 'statuses', 'selectedStatus'));
    }

    /**
     * Show detailed view of an invoice.
     */
    public function invoiceDetail($id)
    {
        $userId = Auth::user()->id;
        $invoice = Invoice::where('customer_id', $userId)
            ->with(['items', 'payments', 'shop', 'customers'])
            ->findOrFail($id);

        return view('customer_portal.invoice-detail', compact('invoice'));
    }

    /**
     * Show customer profile view.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('customer_portal.my-profile', compact('user'));
    }

    /**
     * Update customer profile data.
     */
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;

        if ($request->hasFile('profile')) {
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $dir = storage_path('upload/profile/');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $request->file('profile')->storeAs('upload/profile/', $fileNameToStore, 'public');

            $user->profile = $fileNameToStore;
        }

        $user->save();

        return redirect()->back()->with('success', __('Profile updated successfully.'));
    }
}
