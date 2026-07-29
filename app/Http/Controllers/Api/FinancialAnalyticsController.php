<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Order;
use App\Models\ProductionAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialAnalyticsController extends Controller
{
    public function index()
    {
        $parentId = parentId();
        $currency = settings()['CURRENCY_SYMBOL'] ?? '₹';

        // Revenue
        $totalRevenue = Invoice::where('parent_id', $parentId)->get()->sum(function ($inv) {
            return $inv->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });
        });

        // Payments received
        $totalCollected = InvoicePayment::whereHas('invoice', function ($q) use ($parentId) {
            $q->where('parent_id', $parentId);
        })->sum('amount');

        // Outstanding receivables
        $totalReceivables = $totalRevenue - $totalCollected;

        // Tailor payouts
        $tailorPayouts = ProductionAssignment::where('parent_id', $parentId)
            ->where('status', 'completed')
            ->sum('piece_rate_pay');

        // Expenses
        $totalExpenses = DB::table('expenses')
            ->where('parent_id', $parentId)
            ->sum('amount');

        // Profit margin
        $profit = $totalCollected - $totalExpenses - $tailorPayouts;

        // Monthly revenue breakdown (last 6 months)
        $driver = DB::connection()->getDriverName();
        $dateFormat = $driver === 'sqlite' ? "strftime('%Y-%m', date)" : "DATE_FORMAT(date, '%Y-%m')";

        $monthlyRevenue = InvoicePayment::whereHas('invoice', function ($q) use ($parentId) {
            $q->where('parent_id', $parentId);
        })
            ->where('date', '>=', now()->subMonths(6)->format('Y-m-d'))
            ->selectRaw("{$dateFormat} as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'success' => true,
            'currency' => $currency,
            'total_revenue' => round($totalRevenue, 2),
            'total_collected' => round($totalCollected, 2),
            'total_receivables' => round($totalReceivables, 2),
            'tailor_payouts' => round($tailorPayouts, 2),
            'total_expenses' => round($totalExpenses, 2),
            'net_profit' => round($profit, 2),
            'monthly_revenue' => $monthlyRevenue,
        ]);
    }
}
