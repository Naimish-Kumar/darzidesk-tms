<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ParentIdTrait;

class Material extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable = [
        'name',
        'code',
        'category',
        'unit',
        'quantity',
        'reorder_level',
        'unit_cost',
        'description',
        'parent_id',
    ];

    public function usages()
    {
        return $this->hasMany(OrderMaterialUsage::class, 'material_id');
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->reorder_level;
    }
}
