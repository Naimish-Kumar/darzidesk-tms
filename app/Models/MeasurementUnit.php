<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ParentIdTrait;

class MeasurementUnit extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable=[
        'unit',
        'parent_id',
    ];
}
