<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Measurement;
use Illuminate\Http\Request;

class CustomerProfileController extends Controller
{
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        $orders = Order::where('customer_id', $customer->id)->latest()->get();
        $measurements = Measurement::where('customer_id', $customer->id)->get();

        return view('customer.show', compact('customer', 'orders', 'measurements'));
    }
}
