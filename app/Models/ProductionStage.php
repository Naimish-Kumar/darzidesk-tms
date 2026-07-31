<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ParentIdTrait;

class ProductionStage extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable = [
        'name',
        'slug',
        'order_index',
        'color_code',
        'is_default',
        'parent_id',
    ];

    public static function getDefaultStages()
    {
        return [
            ['name' => 'New Order', 'slug' => 'new-order', 'order_index' => 1, 'color_code' => '#64748B'],
            ['name' => 'Cutting', 'slug' => 'cutting', 'order_index' => 2, 'color_code' => '#3B82F6'],
            ['name' => 'Stitching / Embroidery', 'slug' => 'stitching-embroidery', 'order_index' => 3, 'color_code' => '#8B5CF6'],
            ['name' => 'Trial Fitting', 'slug' => 'trial-fitting', 'order_index' => 4, 'color_code' => '#F59E0B'],
            ['name' => 'Ready for Delivery', 'slug' => 'ready-for-delivery', 'order_index' => 5, 'color_code' => '#00796B'],
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'production_stage_id');
    }
}
