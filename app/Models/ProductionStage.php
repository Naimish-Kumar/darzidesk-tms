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
            ['name' => 'Pending', 'slug' => 'pending', 'order_index' => 1, 'color_code' => '#6B7280'],
            ['name' => 'Cutting', 'slug' => 'cutting', 'order_index' => 2, 'color_code' => '#3B82F6'],
            ['name' => 'Stitching', 'slug' => 'stitching', 'order_index' => 3, 'color_code' => '#8B5CF6'],
            ['name' => 'Finishing & QC', 'slug' => 'finishing-qc', 'order_index' => 4, 'color_code' => '#F59E0B'],
            ['name' => 'Ready for Pickup', 'slug' => 'ready-for-pickup', 'order_index' => 5, 'color_code' => '#10B981'],
            ['name' => 'Delivered', 'slug' => 'delivered', 'order_index' => 6, 'color_code' => '#059669'],
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'production_stage_id');
    }
}
