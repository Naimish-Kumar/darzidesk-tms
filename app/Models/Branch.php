<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'manager_id',
        'parent_id',
        'is_active',
        'opening_time',
        'closing_time',
        'weekly_holiday',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
