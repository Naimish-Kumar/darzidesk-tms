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
        $currency_symbol = settings()['CURRENCY_SYMBOL'] ?? '₹';

        if ($user->type == 'customer') {
            $query->where('customer_id', $user->id);
        } elseif ($user->type == 'employee') {
            $query->whereHas('orders', function ($q) use ($user) {
                $q->where('responsible', $user->id);
            });
        } else {
            $query->where('parent_id', parentId());
        }

        $invoices = $query->get()->map(function($i) use ($currency_symbol) {
            return [
                'id' => $i->id,
                'invoice_id' => "#INV" . $i->invoice_id,
                'customer_name' => $i->customers->name ?? 'Unknown',
                'date' => $i->invoice_date,
                'due_date' => $i->due_date,
                'status' => ucfirst($i->status),
                'total_amount' => $currency_symbol . number_format($i->getTotal(), 2),
                'paid_amount' => $currency_symbol . number_format($i->getPaidAmount(), 2),
                'due_amount' => $currency_symbol . number_format($i->getDue(), 2),
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

        $currency_symbol = settings()['CURRENCY_SYMBOL'] ?? '₹';

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $invoice->id,
                'invoice_id' => "#INV" . $invoice->invoice_id,
                'customer' => $invoice->customers->name ?? 'Unknown',
                'date' => $invoice->invoice_date,
                'due_date' => $invoice->due_date,
                'status' => ucfirst($invoice->status),
                'items' => $invoice->items->map(function($item) use ($currency_symbol) {
                    return [
                        'id' => $item->id,
                        'description' => $item->clothType->title ?? 'Tailoring Service',
                        'quantity' => $item->quantity,
                        'rate' => $currency_symbol . number_format($item->amount, 2),
                        'total' => $currency_symbol . number_format($item->amount * $item->quantity, 2),
                    ];
                }),
                'summary' => [
                    'sub_total' => $currency_symbol . number_format($invoice->getSubTotal(), 2),
                    'tax' => $currency_symbol . number_format($invoice->getTotalTax(), 2),
                    'total' => $currency_symbol . number_format($invoice->getTotal(), 2),
                ],
                'payments' => $invoice->payments->map(function($payment) use ($currency_symbol) {
                    return [
                        'id' => $payment->id,
                        'payment_date' => $payment->payment_date,
                        'amount' => $currency_symbol . number_format($payment->amount, 2),
                        'payment_type' => ucfirst($payment->payment_type),
                        'notes' => $payment->notes,
                    ];
                }),
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
    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required',
            'customer_id' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
        ]);

        $orders = \App\Models\Order::where('customer_id', $request->customer_id)->whereNotIn('status', ['delivered', 'on_hold', 'cancelled'])->get();

        if (!empty($orders) && count($orders) > 0) {
            $invoice = new Invoice();
            $invoice->parent_id = parentId();
            $invoice->invoice_id = $request->invoice_id;
            $invoice->customer_id = $request->customer_id;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->due_date = $request->due_date;
            $invoice->status = 'unpaid';
            $invoice->save();

            foreach ($orders as $order) {
                $clothType = \App\Models\ClothType::find($order->cloth_type);
                if (!empty($clothType)) {
                    $invoiceItem = new \App\Models\InvoiceItem();
                    $invoiceItem->invoice_id = $invoice->id;
                    $invoiceItem->cloth_type_id = $order->cloth_type;
                    $invoiceItem->quantity = $order->quantity;
                    $invoiceItem->amount = !empty($clothType) ? $clothType->amount : 0;
                    $invoiceItem->tax = !empty($clothType) ? $clothType->taxes : null;
                    $invoiceItem->note = !empty($order) ? $order->note : null;
                    $invoiceItem->parent_id = parentId();
                    $invoiceItem->save();

                    $order->status = 'delivered';
                    $order->invoice = $invoice->id;
                    $order->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully',
                'data' => $invoice
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Customer order not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::where('id', $id)->where('parent_id', parentId())->first();
        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found'], 404);
        }

        $request->validate([
            'invoice_id' => 'required',
            'customer_id' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
        ]);

        $invoice->invoice_id = $request->invoice_id;
        $invoice->customer_id = $request->customer_id;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->due_date = $request->due_date;
        $invoice->save();

        return response()->json([
            'success' => true,
            'message' => 'Invoice updated successfully',
            'data' => $invoice
        ]);
    }

    public function destroy($id)
    {
        $invoice = Invoice::where('id', $id)->where('parent_id', parentId())->first();
        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found'], 404);
        }

        \App\Models\InvoiceItem::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();

        return response()->json(['success' => true, 'message' => 'Invoice deleted successfully']);
    }

    public function invoiceItemStore(Request $request, $id)
    {
        $request->validate([
            'cloth_type_id' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
        ]);

        $invoiceItem = new \App\Models\InvoiceItem();
        $invoiceItem->invoice_id = $id;
        $invoiceItem->cloth_type_id = $request->cloth_type_id;
        $invoiceItem->quantity = $request->quantity;
        $invoiceItem->amount = $request->amount;
        $invoiceItem->tax = $request->tax;
        $invoiceItem->note = $request->note;
        $invoiceItem->parent_id = parentId();
        $invoiceItem->save();

        $invoice = Invoice::find($id);
        if ($invoice->getInvoiceDueAmount() <= 0) {
            $status = 'paid';
        } elseif ($invoice->getInvoiceDueAmount() == $invoice->getInvoiceSubTotalAmount()) {
            $status = 'unpaid';
        } else {
            $status = 'partial_paid';
        }
        Invoice::statusChange($invoice->id, $status);

        return response()->json(['success' => true, 'message' => 'Invoice item added successfully']);
    }

    public function invoiceItemDestroy($invoiceId, $id)
    {
        $item = \App\Models\InvoiceItem::where('id', $id)->where('invoice_id', $invoiceId)->first();
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Invoice item not found'], 404);
        }
        
        $item->delete();

        $invoice = Invoice::find($invoiceId);
        if ($invoice->getInvoiceDueAmount() <= 0) {
            $status = 'paid';
        } elseif ($invoice->getInvoiceDueAmount() == $invoice->getInvoiceSubTotalAmount()) {
            $status = 'unpaid';
        } else {
            $status = 'partial_paid';
        }
        Invoice::statusChange($invoice->id, $status);

        return response()->json(['success' => true, 'message' => 'Invoice item deleted successfully']);
    }

    public function invoicePaymentStore(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found'], 404);
        }

        $dueAmount = $invoice->getInvoiceDueAmount();
        $request->validate([
            'payment_date' => 'required',
            'amount' => 'required|numeric|min:1|max:' . $dueAmount,
            'payment_type' => 'required',
        ]);

        $payment = new \App\Models\InvoicePayment();
        $payment->invoice_id = $id;
        $payment->transaction_id = md5(time());
        $payment->payment_type = $request->payment_type;
        $payment->amount = $request->amount;
        $payment->payment_date = $request->payment_date;
        $payment->notes = $request->notes;
        $payment->payment_status = 'Success';
        $payment->save();

        if ($invoice->getInvoiceDueAmount() <= 0) {
            $status = 'paid';
        } else {
            $status = 'partial_paid';
        }
        Invoice::statusChange($invoice->id, $status);

        return response()->json(['success' => true, 'message' => 'Invoice payment added successfully']);
    }

    public function invoicePaymentDestroy($invoiceId, $id)
    {
        $payment = \App\Models\InvoicePayment::where('id', $id)->where('invoice_id', $invoiceId)->first();
        if (!$payment) {
            return response()->json(['success' => false, 'message' => 'Invoice payment not found'], 404);
        }

        $payment->delete();

        $invoice = Invoice::find($invoiceId);
        if ($invoice->getInvoiceDueAmount() <= 0) {
            $status = 'paid';
        } elseif ($invoice->getInvoiceDueAmount() == $invoice->getInvoiceSubTotalAmount()) {
            $status = 'unpaid';
        } else {
            $status = 'partial_paid';
        }
        Invoice::statusChange($invoice->id, $status);

        return response()->json(['success' => true, 'message' => 'Invoice payment deleted successfully']);
    }
}
