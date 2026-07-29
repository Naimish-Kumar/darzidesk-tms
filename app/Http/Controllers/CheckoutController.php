<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display checkout and payment screen.
     */
    public function index(Request $request)
    {
        $orderId = $request->get('order_id');
        $order = Order::with('customers')->find($orderId);

        if (!$order) {
            // Mock sample order for demonstration if no order_id passed
            $order = (object)[
                'id' => 88294,
                'order_id' => 'TXN-88294',
                'customer_name' => 'Alexander Hamilton',
                'customer_phone' => '+1 (555) 012-3456',
                'customer_tier' => 'Premium Member',
                'items' => [
                    (object)[
                        'name' => 'Bespoke Two-Piece Suit',
                        'desc' => 'Italian Wool • Slim Fit • Peak Lapel (Chest: 40", Waist: 32")',
                        'qty' => 1,
                        'price' => 1250.00,
                        'img' => 'assets/images/hero_tailor_atelier.jpg',
                    ],
                    (object)[
                        'name' => 'Classic Oxford Shirt',
                        'desc' => 'Sea Island Cotton • White • Monogrammed',
                        'qty' => 2,
                        'price' => 180.00,
                        'img' => 'assets/images/onboarding_tailor.jpg',
                    ],
                ],
                'subtotal' => 1610.00,
                'tax' => 128.80,
                'shipping' => 0.00,
                'total' => 1738.80,
            ];
        }

        return view('checkout.index', compact('order'));
    }

    /**
     * Process checkout transaction payment.
     */
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required',
            'payment_method' => 'required|string',
            'amount_received' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'coupon_code' => 'nullable|string',
        ]);

        $change = max(0, $validated['amount_received'] - $validated['total_amount']);

        // Record payment transaction
        $payment = InvoicePayment::create([
            'invoice' => 1,
            'amount' => $validated['total_amount'],
            'payment_type' => $validated['payment_method'],
            'date' => now()->format('Y-m-d'),
            'notes' => 'Checkout Payment. Change given: $' . number_format($change, 2),
        ]);

        return redirect()->route('pos.index')->with('success', 'Transaction completed successfully! Change to return: $' . number_format($change, 2));
    }
}
