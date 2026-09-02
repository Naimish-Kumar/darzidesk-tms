<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function getYearlyProfitLoss(Request $request)
    {
        $year = $request->input('year', now()->year);

        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $expenses = Expense::select(
                DB::raw("strftime('%m', date) as month"),
                DB::raw('SUM(amount) as total_expense')
            )
                ->where('parent_id', parentId())
                ->whereYear('date', $year)
                ->groupBy(DB::raw("strftime('%m', date)"))
                ->orderBy('month')
                ->get();
            $expenses = $expenses->map(function($item) {
                $item->month = (int)$item->month;
                return $item;
            })->keyBy('month');
        } else {
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
        }

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
    public function getOrderReport(Request $request)
    {
        if (!auth()->user()->can('manage order report')) {
            return response()->json(['success' => false, 'message' => 'Permission denied'], 403);
        }

        $query = Order::with('customer')->where('parent_id', parentId());

        if ($request->filled('responsible')) {
            $query->where('responsible', $request->responsible);
        }
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('order_date', '>=', $request->start_date)
                  ->whereDate('deadline_date', '<=', $request->end_date);
        }

        $orders = $query->orderBy('id', 'desc')->get();
        
        $settings = settings();
        $currency_symbol = $settings['CURRENCY_SYMBOL'] ?? '₹';

        $data = $orders->map(function ($o) {
            return [
                'id' => $o->id,
                'order_id' => $o->order_id,
                'customer_name' => $o->customer->name ?? 'Unknown',
                'order_date' => $o->order_date,
                'deadline_date' => $o->deadline_date,
                'total_amount' => $o->total_amount,
                'status' => $o->status,
            ];
        });

        $totalAmount = $orders->sum('total_amount');

        return response()->json([
            'success' => true,
            'data' => $data,
            'total_amount' => $totalAmount,
            'currency_symbol' => $currency_symbol,
        ]);
    }

    public function getIncomeReport(Request $request)
    {
        if (!auth()->user()->can('manage income report')) {
            return response()->json(['success' => false, 'message' => 'Permission denied'], 403);
        }

        $query = Invoice::with('customer')->where('parent_id', parentId())->whereIn('status', ['partial_paid', 'paid']);

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('invoice_date', '>=', $request->start_date)
                  ->whereDate('invoice_date', '<=', $request->end_date);
        }

        $incomes = $query->orderBy('id', 'desc')->get();

        $settings = settings();
        $currency_symbol = $settings['CURRENCY_SYMBOL'] ?? '₹';

        $data = $incomes->map(function ($inv) {
            return [
                'id' => $inv->id,
                'invoice_id' => $inv->invoice_id,
                'customer_name' => $inv->customer->name ?? 'Unknown',
                'invoice_date' => $inv->invoice_date,
                'status' => $inv->status,
                'amount' => $inv->getInvoiceTotalAmount(),
            ];
        });

        $totalAmount = $data->sum('amount');

        return response()->json([
            'success' => true,
            'data' => $data,
            'total_amount' => $totalAmount,
            'currency_symbol' => $currency_symbol,
        ]);
    }

    public function getExpenseReport(Request $request)
    {
        if (!auth()->user()->can('manage expense report')) {
            return response()->json(['success' => false, 'message' => 'Permission denied'], 403);
        }

        $query = Expense::with(['category', 'subCategory'])->where('parent_id', parentId());

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('date', '>=', $request->start_date)
                  ->whereDate('date', '<=', $request->end_date);
        }

        $expenses = $query->orderBy('id', 'desc')->get();

        $settings = settings();
        $currency_symbol = $settings['CURRENCY_SYMBOL'] ?? '₹';

        $data = $expenses->map(function ($exp) {
            return [
                'id' => $exp->id,
                'title' => $exp->title,
                'category_name' => $exp->category->name ?? 'Unknown',
                'sub_category_name' => $exp->subCategory->name ?? '-',
                'date' => $exp->date,
                'amount' => $exp->amount,
            ];
        });

        $totalAmount = $expenses->sum('amount');

        return response()->json([
            'success' => true,
            'data' => $data,
            'total_amount' => $totalAmount,
            'currency_symbol' => $currency_symbol,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $year = $request->input('year', now()->year);
        $type = $request->input('type', 'yearly');

        $html = "<h2>DarziDesk Financial Report ({$year})</h2><p>Export Type: " . strtoupper($type) . "</p>";
        $html .= "<table border='1' cellpadding='8' cellspacing='0' style='width:100%; border-collapse:collapse;'>";
        $html .= "<tr style='background:#00796B; color:#fff;'><th>Period</th><th>Income</th><th>Expense</th><th>Net Profit</th></tr>";

        $reportData = $this->getYearlyProfitLoss($request)->getData(true)['data'] ?? [];
        foreach ($reportData['report'] ?? [] as $row) {
            $html .= "<tr><td>{$row['month']}</td><td>₹{$row['income']}</td><td>₹{$row['expense']}</td><td>₹{$row['profit']}</td></tr>";
        }
        $html .= "</table>";

        return response($html, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="financial_report_' . $year . '.pdf"',
        ]);
    }

    public function exportCsv(Request $request)
    {
        $year = $request->input('year', now()->year);
        $reportData = $this->getYearlyProfitLoss($request)->getData(true)['data'] ?? [];

        $csv = "Month,Income,Expense,Profit\n";
        foreach ($reportData['report'] ?? [] as $row) {
            $csv .= "{$row['month']},{$row['income']},{$row['expense']},{$row['profit']}\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="financial_report_' . $year . '.csv"',
        ]);
    }
}
