<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'title',
        'package_amount',
        'interval',
        'user_limit',
        'customer_limit',
        'cloth_type_limit',
        'enabled_logged_history',
    ];

    public static $intervals = [
        'Monthly' => 'Monthly',
        'Quarterly' => 'Quarterly',
        'Yearly' => 'Yearly',
        'Unlimited' => 'Unlimited',
    ];

    public function couponCheck()
    {
        $id = (string) $this->id;
        return Coupon::where(function ($query) use ($id) {
            $query->where('applicable_packages', $id)
                ->orWhere('applicable_packages', 'like', $id . ',%')
                ->orWhere('applicable_packages', 'like', '%,' . $id . ',%')
                ->orWhere('applicable_packages', 'like', '%,' . $id);
        })->count();
    }

}
