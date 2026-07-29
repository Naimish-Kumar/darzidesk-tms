<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ParentIdTrait;

class Order extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable = [
        'order_id',
        'tracking_token',
        'customer_id',
        'order_date',
        'deadline_date',
        'quantity',
        'febric',
        'febric_color',
        'gender',
        'responsible',
        'cloth_type',
        'status',
        'notes',
        'measurement',
        'production_stage_id',
        'parent_id',
    ];
    
    protected $casts = [
        'measurement' => 'array',
    ];


    public static $status = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Complete',
        'delivered' => 'Delivered',
        'on_hold' => 'On Hold',
        'cancelled' => 'Cancelled',
    ];

    public function customers()
    {
        return $this->hasOne('App\Models\User', 'id', 'customer_id');
    }

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'responsible');
    }
    public function clothTypes()
    {
        return $this->hasOne('App\Models\ClothType', 'id', 'cloth_type');
    }

    public function invoices()
    {
        return $this->hasOne(Invoice::class, 'id', 'invoice');
    }

    public function productionStage()
    {
        return $this->belongsTo(ProductionStage::class, 'production_stage_id');
    }

    public function assignments()
    {
        return $this->hasMany(ProductionAssignment::class, 'order_id');
    }

    public function materialUsages()
    {
        return $this->hasMany(OrderMaterialUsage::class, 'order_id');
    }

}
