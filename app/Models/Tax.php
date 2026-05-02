<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ParentIdTrait;

class Tax extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable=[
        'tax',
        'rate',
        'parent_id',
    ];
}
