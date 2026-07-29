<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ParentIdTrait;

class MeasurementHistory extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable = [
        'measurement_id',
        'customer_id',
        'cloth_type_id',
        'snapshot_data',
        'change_notes',
        'updated_by',
        'parent_id',
    ];

    protected $casts = [
        'snapshot_data' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function clothType()
    {
        return $this->belongsTo(ClothType::class, 'cloth_type_id');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
