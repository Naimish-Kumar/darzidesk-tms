<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TailorService extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price_starts_at',
        'estimated_days',
        'category',
        'is_active',
    ];

    public function shopOwner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
