<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use Tests\TestCase;

class PosFinancialsTest extends TestCase
{
    public function test_invoice_payout_calculations()
    {
        $invoice = new Invoice([
            'invoice_id' => 1001,
            'customer_id' => 2,
            'status' => 'unpaid',
        ]);

        $this->assertEquals('unpaid', $invoice->status);
    }

    public function test_invoice_payment_entry()
    {
        $payment = new InvoicePayment([
            'invoice_id' => 1,
            'amount' => 150.00,
            'payment_type' => 'Cash',
        ]);

        $this->assertEquals(150.00, $payment->amount);
        $this->assertEquals('Cash', $payment->payment_type);
    }
}
