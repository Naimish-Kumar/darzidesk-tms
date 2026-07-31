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
        'color_name',
        'color_code',
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

    public function getColorSwatchHtml()
    {
        $hex = $this->color_code ?: '#00796B';
        $label = $this->color_name ?: 'Standard';
        return '<span class="d-inline-flex align-items-center gap-1 badge" style="background:#F1F5F9; color:#1E293B; border:1px solid #CBD5E1; font-weight:600;"><span style="width:12px; height:12px; border-radius:50%; background:' . $hex . '; display:inline-block; border:1px solid rgba(0,0,0,0.15);"></span> ' . e($label) . '</span>';
    }
}
