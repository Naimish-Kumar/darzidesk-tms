<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ParentIdTrait;

class Invoice extends Model
{
    use HasFactory;
    use ParentIdTrait;

    protected $fillable = [
        'invoice_id',
        'customer_id',
        'invoice_date',
        'due_date',
        'status',
        'parent_id',
        'order_id'
    ];
    public static $status = [
        'paid' => 'Paid',
        'unpaid' => 'Unpaid',
        'partial_paid' => 'Partial Paid',
    ];
    public static $paymentMethod = [
        'bank' => 'Bank',
        'cash' => 'Cash',
        'upi' => 'UPI',
        'cheque' => 'Cheque',
    ];

    public function customers()
    {
        return $this->hasOne('App\Models\User', 'id', 'customer_id');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\User', 'parent_id', 'id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\InvoiceItem', 'invoice_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\InvoicePayment', 'invoice_id', 'id');
    }

    public function getInvoiceSubTotalAmount()
    {
        $subTotalAmount = 0;
        foreach ($this->items as $item) {
            $subTotalAmount += ($item->amount * $item->quantity);
        }
        return $subTotalAmount;
    }

    public function getInvoiceTotalTax()
    {
        $totalTaxAmount = 0;
        foreach ($this->items as $item) {
            if (!empty($item->tax)) {
                $taxRate = getTaxRate($item->tax);
                $totalTaxAmount += ($taxRate / 100) * ($item->amount * $item->quantity);
            }
        }
        return $totalTaxAmount;
    }

    public function getInvoiceTotalAmount()
    {
        return ($this->getInvoiceSubTotalAmount() + $this->getInvoiceTotalTax());
    }

    public function getTotal()
    {
        return $this->getInvoiceTotalAmount();
    }

    public function getPaidAmount()
    {
        $totalPaid = 0;
        foreach ($this->payments as $itemPayment) {
            $totalPaid += $itemPayment->amount;
        }
        return $totalPaid;
    }

    public function getInvoiceDueAmount()
    {
        return ($this->getInvoiceTotalAmount() - $this->getPaidAmount());
    }

    public function getDue()
    {
        return $this->getInvoiceDueAmount();
    }

    public static function statusChange($invoice_id, $status)
    {
        $invoice = Invoice::find($invoice_id);
        $invoice->status = $status;
        $invoice->save();
        return $invoice;
    }

    public static $paymentMethodnew = [
        'bank' => 'Bank',
        'cash' => 'Cash',
        'upi' => 'UPI',
        'cheque' => 'Cheque',
        'Bank Transfer' => 'Bank Transfer',
        'Stripe' => 'Stripe',
        'Paypal' => 'Paypal',
        'Flutterwave' => 'Flutterwave',
        'Paystack' => 'Paystack'
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'invoice', 'id');
    }
}
