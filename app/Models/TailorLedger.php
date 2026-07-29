<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TailorLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'tailor_id',
        'type', // earning, advance, settlement
        'amount',
        'notes',
        'reference_id',
        'parent_id',
    ];

    public function tailor()
    {
        return $this->belongsTo(User::class, 'tailor_id');
    }
}
