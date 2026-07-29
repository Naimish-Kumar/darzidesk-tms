<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ParentIdTrait;

class ProductionAssignment extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable = [
        'order_id',
        'worker_id',
        'stage_id',
        'piece_rate_pay',
        'status',
        'notes',
        'assigned_at',
        'completed_at',
        'parent_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function tailor()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function stage()
    {
        return $this->belongsTo(ProductionStage::class, 'stage_id');
    }
}
