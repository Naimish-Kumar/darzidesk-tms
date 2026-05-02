<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Invoice::orderBy('id', 'desc');

        if ($user->type == 'customer') {
            $query->where('customer_id', $user->id);
        } elseif ($user->type == 'employee') {
            $query->whereHas('orders', function ($q) use ($user) {
                $q->where('responsible', $user->id);
            });
        } else {
            $query->where('parent_id', parentId());
        }

        $invoices = $query->get()->map(function($i) {
            return [
                'id' => $i->id,
                'invoice_id' => "#INV" . $i->invoice_id,
                'customer_name' => $i->customers->name ?? 'Unknown',
                'date' => $i->invoice_date,
                'due_date' => $i->due_date,
                'status' => ucfirst($i->status),
                'total_amount' => '$' . number_format($i->getTotal(), 2),
                'paid_amount' => '$' . number_format($i->getPaidAmount(), 2),
                'due_amount' => '$' . number_format($i->getDue(), 2),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $invoices
        ]);
    }

    public function show($id)
    {
        $invoice = Invoice::where('id', $id)
            ->where('parent_id', parentId())
            ->first();

        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $invoice->id,
                'invoice_id' => "#INV" . $invoice->invoice_id,
                'customer' => $invoice->customers->name ?? 'Unknown',
                'date' => $invoice->invoice_date,
                'due_date' => $invoice->due_date,
                'status' => ucfirst($invoice->status),
                'items' => $invoice->items->map(function($item) {
                    return [
                        'description' => $item->clothType->title ?? 'Tailoring Service',
                        'quantity' => $item->quantity,
                        'rate' => '$' . number_format($item->amount, 2),
                        'total' => '$' . number_format($item->amount * $item->quantity, 2),
                    ];
                }),
                'summary' => [
                    'sub_total' => '$' . number_format($invoice->getSubTotal(), 2),
                    'tax' => '$' . number_format($invoice->getTotalTax(), 2),
                    'total' => '$' . number_format($invoice->getTotal(), 2),
                ]
            ]
        ]);
    }

    public function receipt($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        if (!$invoice) abort(404);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('api.receipt', compact('invoice'));
        return $pdf->download('Receipt-' . $invoice->invoice_id . '.pdf');
    }
}
