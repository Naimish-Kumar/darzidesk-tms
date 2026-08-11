<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponHistory;
use Illuminate\Http\Request;

class PromotionsController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        $totalCoupons = $coupons->count();
        $activeCoupons = $coupons->where('status', '1')->where('valid_for', '>=', date('Y-m-d'))->count();
        $expiredCoupons = $coupons->filter(function ($c) {
            return $c->valid_for < date('Y-m-d') || $c->status == '0';
        })->count();

        $totalRedemptions = CouponHistory::count();

        return view('promotions.index', compact(
            'coupons',
            'totalCoupons',
            'activeCoupons',
            'expiredCoupons',
            'totalRedemptions'
        ));
    }
}

