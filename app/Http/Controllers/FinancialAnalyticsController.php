<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Material;
use App\Models\ProductionAssignment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinancialAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all_time');

        $paymentQuery = InvoicePayment::where('parent_id', parentId());
        $expenseQuery = Expense::where('parent_id', parentId());
        $payoutQuery = ProductionAssignment::where('parent_id', parentId())->where('status', 'completed');

        if ($filter == 'this_month') {
            $paymentQuery->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
            $expenseQuery->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
            $payoutQuery->whereMonth('updated_at', Carbon::now()->month)->whereYear('updated_at', Carbon::now()->year);
        } elseif ($filter == 'last_month') {
            $lastMonth = Carbon::now()->subMonth();
            $paymentQuery->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year);
            $expenseQuery->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year);
            $payoutQuery->whereMonth('updated_at', $lastMonth->month)->whereYear('updated_at', $lastMonth->year);
        } elseif ($filter == 'this_year') {
            $paymentQuery->whereYear('created_at', Carbon::now()->year);
            $expenseQuery->whereYear('created_at', Carbon::now()->year);
            $payoutQuery->whereYear('updated_at', Carbon::now()->year);
        }

        // 1. Total Revenue from Payments
        $totalRevenue = (float) $paymentQuery->sum('amount');

        // 2. Outstanding Collections (Unpaid parts of invoices)
        $invoices = Invoice::where('parent_id', parentId())->with(['items', 'payments'])->get();
        $outstandingAmount = (float) $invoices->sum(fn($inv) => $inv->getInvoiceDueAmount());

        // 3. Piece-rate Payouts (Expenses to tailors)
        $tailorPayouts = (float) $payoutQuery->sum('piece_rate_pay');

        // 4. Material Stock Valuation
        $stockValuation = (float) Material::where('parent_id', parentId())->sum(\DB::raw('quantity * unit_cost'));

        // 5. Total Operating Expenses (excluding tailor payouts)
        $operatingExpenses = (float) $expenseQuery->sum('amount');

        // 6. Net Profit & Margin
        $totalExpenses = $operatingExpenses + $tailorPayouts;
        $netProfit = $totalRevenue - $totalExpenses;
        $profitMargin = $totalRevenue > 0 ? ($netProfit / $totalRevenue) * 100 : 0;

        // 7. Grouped Expenses Category-wise for progress bars
        $expenseCategories = Expense::where('parent_id', parentId())
            ->select('category_id', \DB::raw('sum(amount) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // 8. Payment Method Breakdown (Cash, UPI, Card, Bank, etc.)
        $paymentMethods = InvoicePayment::where('parent_id', parentId())
            ->select('payment_type', \DB::raw('sum(amount) as total'))
            ->groupBy('payment_type')
            ->get();

        // 9. Monthly Revenue & Expense Trends (Last 6 Months)
        $monthlyLabels = [];
        $monthlyRevenues = [];
        $monthlyExpenses = [];

        for ($i = 5; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $dt->format('M Y');

            $rev = InvoicePayment::where('parent_id', parentId())
                ->whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->sum('amount');

            $exp = Expense::where('parent_id', parentId())
                ->whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->sum('amount');

            $payout = ProductionAssignment::where('parent_id', parentId())
                ->where('status', 'completed')
                ->whereMonth('updated_at', $dt->month)
                ->whereYear('updated_at', $dt->year)
                ->sum('piece_rate_pay');

            $monthlyRevenues[] = (float) $rev;
            $monthlyExpenses[] = (float) ($exp + $payout);
        }

        // 10. Recent Transactions
        $recentPayments = InvoicePayment::where('parent_id', parentId())
            ->with(['invoice', 'invoice.customers'])
            ->latest()
            ->take(6)
            ->get();

        return view('financials.analytics', compact(
            'filter',
            'totalRevenue',
            'outstandingAmount',
            'tailorPayouts',
            'stockValuation',
            'operatingExpenses',
            'totalExpenses',
            'netProfit',
            'profitMargin',
            'expenseCategories',
            'paymentMethods',
            'monthlyLabels',
            'monthlyRevenues',
            'monthlyExpenses',
            'recentPayments'
        ));
    }
}
