<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class CustomerPaymentMethodController extends Controller
{
    /**
     * List all payment methods for the authenticated customer.
     */
    public function index(Request $request)
    {
        $methods = PaymentMethod::where('user_id', $request->user()->id)
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $methods,
        ]);
    }

    /**
     * Store a new payment method.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:card,upi,wallet',
            'label' => 'nullable|string|max:255',
            'is_default' => 'nullable|boolean',

            // Card fields
            'card_type' => 'required_if:type,card|nullable|string|max:20',
            'card_number_masked' => 'required_if:type,card|nullable|string|max:30',
            'card_expiry' => 'required_if:type,card|nullable|string|max:10',
            'card_holder' => 'required_if:type,card|nullable|string|max:255',

            // UPI fields
            'vpa_id' => 'required_if:type,upi|nullable|string|max:255',

            // Wallet fields
            'wallet_provider' => 'required_if:type,wallet|nullable|string|max:100',
            'wallet_status' => 'nullable|string|in:linked,not_linked',
        ]);

        $userId = $request->user()->id;

        // If setting as default, unset others of the same type
        if ($request->is_default) {
            PaymentMethod::where('user_id', $userId)
                ->where('type', $request->type)
                ->update(['is_default' => false]);
        }

        $method = PaymentMethod::create([
            'user_id' => $userId,
            'type' => $request->type,
            'label' => $request->label,
            'is_default' => $request->is_default ?? false,
            'card_type' => $request->card_type,
            'card_number_masked' => $request->card_number_masked,
            'card_expiry' => $request->card_expiry,
            'card_holder' => $request->card_holder,
            'vpa_id' => $request->vpa_id,
            'wallet_provider' => $request->wallet_provider,
            'wallet_status' => $request->wallet_status ?? ($request->type === 'wallet' ? 'linked' : null),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment method added successfully.',
            'data' => $method,
        ], 201);
    }

    /**
     * Update an existing payment method.
     */
    public function update(Request $request, $id)
    {
        $userId = $request->user()->id;
        $method = PaymentMethod::where('id', $id)->where('user_id', $userId)->firstOrFail();

        $request->validate([
            'label' => 'nullable|string|max:255',
            'is_default' => 'nullable|boolean',
            'card_type' => 'nullable|string|max:20',
            'card_number_masked' => 'nullable|string|max:30',
            'card_expiry' => 'nullable|string|max:10',
            'card_holder' => 'nullable|string|max:255',
            'vpa_id' => 'nullable|string|max:255',
            'wallet_provider' => 'nullable|string|max:100',
            'wallet_status' => 'nullable|string|in:linked,not_linked',
        ]);

        // If setting as default, unset others of the same type
        if ($request->has('is_default') && $request->is_default) {
            PaymentMethod::where('user_id', $userId)
                ->where('type', $method->type)
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        $method->update($request->only([
            'label', 'is_default',
            'card_type', 'card_number_masked', 'card_expiry', 'card_holder',
            'vpa_id',
            'wallet_provider', 'wallet_status',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Payment method updated successfully.',
            'data' => $method->fresh(),
        ]);
    }

    /**
     * Delete a payment method.
     */
    public function destroy(Request $request, $id)
    {
        $userId = $request->user()->id;
        $method = PaymentMethod::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $method->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment method removed.',
        ]);
    }
}
