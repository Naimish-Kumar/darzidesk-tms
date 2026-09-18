<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'business_name',
        'city',
        'mobile',
        'business_type',
        'workers_count',
        'status',
        'notes',
    ];
}
