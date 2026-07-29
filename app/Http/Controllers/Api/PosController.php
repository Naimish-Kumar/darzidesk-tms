<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer',
            'items' => 'required|array|min:1',
            'items.*.cloth_type_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.amount' => 'required|numeric|min:0',
            'advance_payment' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = collect($request->items)->sum('amount');

            $invoice = Invoice::create([
                'customer_id' => $request->customer_id,
                'invoice_id' => 'POS-' . strtoupper(uniqid()),
                'issue_date' => now()->format('Y-m-d'),
                'due_date' => now()->addDays(30)->format('Y-m-d'),
                'status' => ($request->advance_payment >= $totalAmount) ? 'paid' : (($request->advance_payment > 0) ? 'partial_paid' : 'unpaid'),
                'parent_id' => parentId(),
            ]);

            foreach ($request->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item' => 'Garment (Cloth Type #' . $item['cloth_type_id'] . ')',
                    'quantity' => $item['quantity'],
                    'price' => $item['amount'],
                ]);
            }

            if ($request->advance_payment > 0) {
                InvoicePayment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $request->advance_payment,
                    'payment_type' => $request->payment_method ?? 'Cash',
                    'date' => now()->format('Y-m-d'),
                    'notes' => 'POS advance payment',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'POS checkout completed',
                'invoice_id' => $invoice->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Checkout failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
