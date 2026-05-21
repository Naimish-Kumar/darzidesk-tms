<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\PackageTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->type != 'owner') {
            return response()->json([
                'success' => false,
                'message' => 'Only owners can access subscription management.'
            ], 403);
        }

        $currency_symbol = settings()['CURRENCY_SYMBOL'] ?? '₹';

        // Load user's current subscription
        $currentSub = Subscription::find($user->subscription);
        
        $current_subscription_data = null;
        if ($currentSub) {
            $current_subscription_data = [
                'id' => $currentSub->id,
                'title' => $currentSub->title,
                'package_amount' => $currency_symbol . number_format($currentSub->package_amount, 2),
                'package_amount_raw' => $currentSub->package_amount,
                'interval' => $currentSub->interval,
                'user_limit' => $currentSub->user_limit,
                'customer_limit' => $currentSub->customer_limit,
                'employee_limit' => $currentSub->employee_limit,
                'cloth_type_limit' => $currentSub->cloth_type_limit,
                'expire_date' => $user->subscription_expire_date ? Carbon::parse($user->subscription_expire_date)->format('Y-m-d') : 'Lifetime',
                'is_expired' => $user->subscription_expire_date ? Carbon::now()->gt(Carbon::parse($user->subscription_expire_date)) : false,
            ];
        }

        // Fetch usages
        $usages = [
            'staff_count' => $user->totalUser(),
            'customer_count' => $user->totalCustomer(),
            'employee_count' => $user->totalEmployee(),
            'cloth_type_count' => $user->totalClothType(),
        ];

        // Fetch all subscriptions
        $subscriptions = Subscription::orderBy('package_amount', 'asc')->get()->map(function($sub) use ($currency_symbol) {
            return [
                'id' => $sub->id,
                'title' => $sub->title,
                'package_amount' => $currency_symbol . number_format($sub->package_amount, 2),
                'package_amount_raw' => $sub->package_amount,
                'interval' => $sub->interval,
                'user_limit' => $sub->user_limit,
                'customer_limit' => $sub->customer_limit,
                'employee_limit' => $sub->employee_limit,
                'cloth_type_limit' => $sub->cloth_type_limit,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'current_subscription' => $current_subscription_data,
                'usages' => $usages,
                'subscriptions' => $subscriptions,
            ]
        ]);
    }

    public function transactions()
    {
        $user = Auth::user();
        if ($user->type != 'owner') {
            return response()->json([
                'success' => false,
                'message' => 'Only owners can access transactions.'
            ], 403);
        }

        $currency_symbol = settings()['CURRENCY_SYMBOL'] ?? '₹';

        $transactions = PackageTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($txn) use ($currency_symbol) {
                return [
                    'id' => $txn->id,
                    'subscription_name' => $txn->subscriptions->title ?? 'Unknown Plan',
                    'amount' => $currency_symbol . number_format($txn->amount, 2),
                    'payment_type' => $txn->payment_type ?? 'Mock Payment',
                    'payment_status' => $txn->payment_status ?? 'Success',
                    'transaction_id' => $txn->transaction_id ?? 'N/A',
                    'date' => $txn->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }

    public function activateMock(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->type != 'owner') {
            return response()->json([
                'success' => false,
                'message' => 'Only owners can change subscription.'
            ], 403);
        }

        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription plan not found.'
            ], 404);
        }

        // Create transaction data
        $txnData = [
            'user_id' => $user->id,
            'holder_name' => $user->name,
            'subscription_id' => $subscription->id,
            'amount' => $subscription->package_amount,
            'subscription_transactions_id' => uniqid('', true),
            'transaction_id' => 'mock_txn_' . uniqid(),
            'status' => 'Success',
            'payment_type' => 'Mock Upgrade',
        ];

        PackageTransaction::transactionData($txnData);

        // Assign plan and update limits
        $assignPlan = assignSubscription($subscription->id);

        if ($assignPlan['is_success']) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription plan activated successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $assignPlan['error'] ?? 'Failed to activate plan.'
            ], 400);
        }
    }
}
