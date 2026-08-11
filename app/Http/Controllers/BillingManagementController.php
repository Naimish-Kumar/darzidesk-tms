<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\PackageTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingManagementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subscription = Subscription::find($user->subscription ?? 1);
        $plans = Subscription::all();
        $transactions = PackageTransaction::where('user_id', $user->id)->latest()->get();

        return view('billing.index', compact('user', 'subscription', 'plans', 'transactions'));
    }
}
