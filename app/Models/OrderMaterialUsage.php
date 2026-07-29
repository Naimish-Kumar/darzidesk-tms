<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ParentIdTrait;

class OrderMaterialUsage extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable = [
        'order_id',
        'material_id',
        'quantity_used',
        'cost',
        'parent_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
