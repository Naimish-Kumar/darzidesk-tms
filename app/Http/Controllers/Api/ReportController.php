<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Invoice;
use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getYearlyProfitLoss(Request $request)
    {
        $year = $request->input('year', now()->year);

        $expenses = Expense::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(amount) as total_expense')
        )
            ->where('parent_id', parentId())
            ->whereYear('date', $year)
            ->groupBy(DB::raw('MONTH(date)'))
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $invoiceGroups = Invoice::where('parent_id', parentId())
            ->whereYear('invoice_date', $year)
            ->whereIn('status', ['paid', 'partial_paid'])
            ->get()
            ->groupBy(function ($invoice) {
                return (int) \Carbon\Carbon::parse($invoice->invoice_date)->format('m');
            });

        $incomes = collect();

        foreach ($invoiceGroups as $month => $monthInvoices) {
            $incomes[$month] = (object) [
                'month' => $month,
                'total_income' => $monthInvoices->sum(function ($invoice) {
                    return $invoice->getInvoiceTotalAmount();
                }),
            ];
        }

        $report = [];
        $total_income = 0;
        $total_expense = 0;

        for ($month = 1; $month <= 12; $month++) {
            $income = $incomes[$month]->total_income ?? 0;
            $expense = $expenses[$month]->total_expense ?? 0;
            $profit = $income - $expense;

            $report[] = [
                'month' => date('F', mktime(0, 0, 0, $month, 10)),
                'income' => $income,
                'expense' => $expense,
                'profit' => $profit,
            ];

            $total_income += $income;
            $total_expense += $expense;
        }

        $settings = settings();
        $currency_symbol = $settings['CURRENCY_SYMBOL'] ?? '₹';

        return response()->json([
            'success' => true,
            'data' => [
                'report' => $report,
                'total_income' => $total_income,
                'total_expense' => $total_expense,
                'total_profit' => $total_income - $total_expense,
                'currency_symbol' => $currency_symbol,
            ]
        ]);
    }
}
