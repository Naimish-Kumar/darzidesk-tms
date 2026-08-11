<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClothType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * Get unified POS product catalog (garment services & fabrics/materials)
     */
    public function catalog(Request $request)
    {
        try {
            $parentId = parentId();
            $clothTypes = ClothType::where('parent_id', $parentId)->get();
            $materials = Material::where('parent_id', $parentId)->get();

            $catalog = [];

            foreach ($clothTypes as $c) {
                $catalog[] = [
                    'id' => 'ct_' . $c->id,
                    'real_id' => $c->id,
                    'type' => 'cloth_type',
                    'title' => $c->title,
                    'subtitle' => ($c->gender ? $c->gender . ' Stitching' : 'Custom Tailoring'),
                    'category' => $c->gender ? ucfirst($c->gender) : 'Suits',
                    'price' => (float) ($c->amount ?? 0),
                    'stock' => 'In Stock',
                    'qty' => 999,
                    'image' => null,
                ];
            }

            foreach ($materials as $m) {
                $catalog[] = [
                    'id' => 'mat_' . $m->id,
                    'real_id' => $m->id,
                    'type' => 'material',
                    'title' => $m->name,
                    'subtitle' => $m->code ? 'Code: ' . $m->code : 'Fabric & Trim',
                    'category' => $m->category ? strtoupper($m->category) : 'FABRIC',
                    'price' => (float) ($m->unit_cost ?? 0),
                    'stock' => $m->quantity > 0 ? 'In Stock' : 'Low Stock',
                    'qty' => (float) ($m->quantity ?? 0),
                    'image' => null,
                ];
            }

            // Fallback sample catalog if boutique hasn't configured custom items yet
            if (empty($catalog)) {
                $catalog = [
                    [
                        'id' => 'sample_1',
                        'real_id' => 1,
                        'type' => 'cloth_type',
                        'title' => 'Bespoke 2-Piece Suit',
                        'subtitle' => 'Custom Tailoring & Stitching',
                        'category' => 'Suits',
                        'price' => 4500.00,
                        'stock' => 'In Stock',
                        'qty' => 50,
                        'image' => null,
                    ],
                    [
                        'id' => 'sample_2',
                        'real_id' => 2,
                        'type' => 'cloth_type',
                        'title' => 'Designer Sherwani',
                        'subtitle' => 'Wedding & Traditional Wear',
                        'category' => 'Traditional',
                        'price' => 7500.00,
                        'stock' => 'In Stock',
                        'qty' => 30,
                        'image' => null,
                    ],
                    [
                        'id' => 'sample_3',
                        'real_id' => 3,
                        'type' => 'material',
                        'title' => 'Super 120s Italian Wool',
                        'subtitle' => 'Premium Suit Fabric (Black)',
                        'category' => 'FABRIC',
                        'price' => 1800.00,
                        'stock' => 'In Stock',
                        'qty' => 45,
                        'image' => null,
                    ],
                    [
                        'id' => 'sample_4',
                        'real_id' => 4,
                        'type' => 'material',
                        'title' => 'Brass Blazer Buttons',
                        'subtitle' => 'Vintage Series Accessories',
                        'category' => 'TRIM',
                        'price' => 250.00,
                        'stock' => 'In Stock',
                        'qty' => 120,
                        'image' => null,
                    ],
                ];
            }

            return response()->json([
                'success' => true,
                'catalog' => $catalog,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch catalog: ' . $e->getMessage(),
                'catalog' => [],
            ], 500);
        }
    }

    /**
     * Get active POS open queue / hold orders
     */
    public function queue(Request $request)
    {
        try {
            $parentId = parentId();
            $invoices = Invoice::with(['customers', 'items'])
                ->where('parent_id', $parentId)
                ->whereIn('status', ['unpaid', 'partial_paid'])
                ->orderBy('created_at', 'desc')
                ->take(30)
                ->get();

            $queue = $invoices->map(function ($inv) {
                return [
                    'id' => $inv->id,
                    'invoice_id' => $inv->invoice_id ?? ('POS-' . $inv->id),
                    'customer_name' => $inv->customers->name ?? 'Walk-in Client',
                    'customer_phone' => $inv->customers->phone_number ?? '',
                    'items_count' => $inv->items->count(),
                    'total_amount' => (float) $inv->items->sum('price'),
                    'status' => ucfirst($inv->status),
                    'date' => $inv->issue_date ?? $inv->created_at->format('Y-m-d'),
                    'time' => $inv->created_at->format('h:i A'),
                ];
            });

            return response()->json([
                'success' => true,
                'queue' => $queue,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch queue: ' . $e->getMessage(),
                'queue' => [],
            ], 500);
        }
    }

    /**
     * Get POS completed transaction history
     */
    public function history(Request $request)
    {
        try {
            $parentId = parentId();
            $invoices = Invoice::with(['customers', 'items', 'payments'])
                ->where('parent_id', $parentId)
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();

            $history = $invoices->map(function ($inv) {
                $total = (float) $inv->items->sum(function ($it) {
                    return $it->price * ($it->quantity ?? 1);
                });
                if ($total <= 0) {
                    $total = (float) ($inv->amount ?? 0);
                }

                $paidAmount = (float) $inv->payments->sum('amount');
                $lastPayment = $inv->payments->last();

                return [
                    'id' => $inv->id,
                    'invoice_id' => $inv->invoice_id ?? ('POS-' . $inv->id),
                    'customer_name' => $inv->customers->name ?? 'Walk-in Client',
                    'customer_phone' => $inv->customers->phone_number ?? '',
                    'total_amount' => $total,
                    'paid_amount' => $paidAmount,
                    'payment_method' => $lastPayment ? $lastPayment->payment_type : 'Cash',
                    'status' => ucfirst($inv->status),
                    'items_summary' => $inv->items->pluck('item')->join(', ') ?: 'General Bespoke Order',
                    'date' => $inv->issue_date ?? $inv->created_at->format('Y-m-d'),
                    'time' => $inv->created_at->format('h:i A'),
                ];
            });

            return response()->json([
                'success' => true,
                'history' => $history,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch transaction history: ' . $e->getMessage(),
                'history' => [],
            ], 500);
        }
    }

    /**
     * Complete POS sale transaction
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|integer',
            'items' => 'required|array|min:1',
            'advance_payment' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            foreach ($request->items as $item) {
                $price = (float) ($item['amount'] ?? $item['price'] ?? 0);
                $qty = (int) ($item['quantity'] ?? 1);
                $totalAmount += ($price * $qty);
            }

            $discount = (float) ($request->discount ?? 0);
            $finalTotal = max(0, $totalAmount - $discount);
            $paidAmount = (float) ($request->advance_payment ?? $finalTotal);

            $status = ($paidAmount >= $finalTotal) ? 'paid' : (($paidAmount > 0) ? 'partial_paid' : 'unpaid');

            $invoice = Invoice::create([
                'customer_id' => $request->customer_id ?? 1,
                'invoice_id' => 'POS-' . strtoupper(substr(uniqid(), -6)),
                'issue_date' => now()->format('Y-m-d'),
                'due_date' => now()->addDays(14)->format('Y-m-d'),
                'status' => $status,
                'parent_id' => parentId(),
            ]);

            foreach ($request->items as $item) {
                $itemName = $item['title'] ?? $item['name'] ?? ('POS Item #' . ($item['cloth_type_id'] ?? 1));
                $price = (float) ($item['amount'] ?? $item['price'] ?? 0);
                $qty = (int) ($item['quantity'] ?? 1);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item' => $itemName,
                    'quantity' => $qty,
                    'price' => $price,
                ]);
            }

            if ($paidAmount > 0) {
                InvoicePayment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $paidAmount,
                    'payment_type' => $request->payment_method ?? 'Cash',
                    'date' => now()->format('Y-m-d'),
                    'notes' => 'POS Terminal Sale Payment',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'POS Checkout completed successfully',
                'invoice_id' => $invoice->id,
                'transaction' => [
                    'id' => $invoice->id,
                    'invoice_id' => $invoice->invoice_id,
                    'total_amount' => $finalTotal,
                    'paid_amount' => $paidAmount,
                    'payment_method' => $request->payment_method ?? 'Cash',
                    'status' => ucfirst($status),
                    'date' => now()->format('Y-m-d'),
                    'time' => now()->format('h:i A'),
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'POS Checkout failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
