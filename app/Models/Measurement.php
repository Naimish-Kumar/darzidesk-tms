<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ParentIdTrait;

class Measurement extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable=[
        'measurement_id',
        'customer',
        'date',
        'cloth_type',
        'responsible',
        'measurement_detail',
        'posture_adjustments',
        'parent_id',
    ];

    protected $casts = [
        'measurement_detail' => 'array',
        'posture_adjustments' => 'array',
    ];


    public function customers()
    {
        return $this->hasOne('App\Models\User', 'id', 'customer');
    }

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'responsible');
    }
    public function clothTypes()
    {
        return $this->hasOne('App\Models\ClothType', 'id', 'cloth_type');
    }

    public function histories()
    {
        return $this->hasMany(MeasurementHistory::class, 'measurement_id')->orderBy('created_at', 'desc');
    }
}
