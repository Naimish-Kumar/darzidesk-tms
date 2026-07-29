<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterReconciliation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reconciliation_date',
        'branch_id',
        'expected_cash',
        'actual_cash',
        'net_sales',
        'discrepancy',
        'payment_method_split',
        'adjustments',
        'closing_notes',
        'status',
        'finalized_by',
    ];

    protected $casts = [
        'reconciliation_date' => 'date',
        'expected_cash' => 'decimal:2',
        'actual_cash' => 'decimal:2',
        'net_sales' => 'decimal:2',
        'discrepancy' => 'decimal:2',
        'payment_method_split' => 'array',
        'adjustments' => 'array',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function finalizedBy()
    {
        return $this->belongsTo(User::class, 'finalized_by');
    }
}
