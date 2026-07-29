<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ParentIdTrait;

class Supplier extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable = [
        'name',
        'category',
        'specialization',
        'contact_person',
        'phone',
        'email',
        'location',
        'status',
        'parent_id',
    ];
}
