<?php

namespace App\Http\Controllers;

use App\Models\ClothType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $customers = User::where('parent_id', parentId())->where('type', 'customer')->get()->pluck('name', 'id');
        $clothTypes = ClothType::where('parent_id', parentId())->get();
        $taxes = Tax::where('parent_id', parentId())->get();
        $invoiceNumber = $this->invoiceNumber();

        return view('pos.index', compact('customers', 'clothTypes', 'taxes', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.cloth_type_id' => 'required|exists:cloth_types,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.amount' => 'required|numeric|min:0',
            'items.*.tax' => 'nullable',
            'advance_payment' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'payment_notes' => 'nullable|string',
        ]);

        \DB::transaction(function () use ($request) {
            $invoice = Invoice::create([
                'invoice_id' => $this->invoiceNumber(),
                'customer_id' => $request->customer_id,
                'invoice_date' => now()->format('Y-m-d'),
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'status' => 'unpaid',
            ]);

            $totalAmount = 0;
            foreach ($request->items as $item) {
                $subTotal = floatval($item['amount']) * floatval($item['quantity']);
                $taxAmount = 0;

                if (!empty($item['tax'])) {
                    $taxRate = getTaxRate($item['tax']);
                    $taxAmount = ($taxRate / 100) * $subTotal;
                }

                $totalAmount += ($subTotal + $taxAmount);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'cloth_type_id' => $item['cloth_type_id'],
                    'quantity' => $item['quantity'],
                    'amount' => $item['amount'],
                    'tax' => $item['tax'] ?? null,
                    'parent_id' => parentId(),
                ]);
            }

            // Record payment if advance is received
            $advance = floatval($request->advance_payment ?? 0);
            if ($advance > 0) {
                InvoicePayment::addPayment([
                    'invoice_id' => $invoice->id,
                    'amount' => $advance,
                    'payment_type' => $request->payment_method ?? 'Cash',
                    'transaction_id' => 'POS-' . time(),
                    'notes' => $request->payment_notes ?? 'POS Advance Payment',
                    'payment_status' => $advance >= $totalAmount ? 'Completed' : 'Partial',
                ]);

                $invoice->status = $advance >= $totalAmount ? 'paid' : 'partial_paid';
                $invoice->save();
            }
        });

        return response()->json([
            'success' => true,
            'message' => __('POS Invoiced created and completed successfully.'),
        ]);
    }

    private function invoiceNumber()
    {
        $latest = Invoice::where('parent_id', parentId())->latest()->first();
        return $latest ? ($latest->invoice_id + 1) : 1001;
    }
}
