<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function orderData()
    {
        if (Auth::user()->can('manage order report')) {
            $responsibles = User::whereNotIn('type', ['customer', 'owner', 'super admin'])->where('parent_id', parentId())->pluck('name', 'id');
            $customers = User::where('type', 'customer')->where('parent_id', parentId())->pluck('name', 'id');
            $orders = Order::where('parent_id', parentId())->get();

            return view('report.order', compact('responsibles', 'customers', 'orders'));
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function generateOrderReport(Request $request)
    {
        if (Auth::user()->can('manage order report')) {

            $query = Order::where('parent_id', parentId());

            if ($request->filled('responsible')) {
                $query->where('responsible', $request->responsible);
            }

            if ($request->filled('customer_id')) {
                $query->where('customer_id', $request->customer_id);
            }

            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);

                if (count($dates) === 2) {

                    $order_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
                    $deadline_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');

                    $query->whereDate('order_date', '>=', $order_date)
                        ->whereDate('deadline_date', '<=', $deadline_date);
                }
            }

            $orders = $query->orderBy('id', 'desc')->get();
            $html = view('report.order_table', compact('orders'))->render();

            return response()->json(['html' => $html]);
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function incomeData()
    {
        if (Auth::user()->can('manage income report')) {
            $incomes = Invoice::where('parent_id', parentId())->whereIn('status', ['paid', 'partial_paid'])->get();
            $customers = User::where('type', 'customer')->where('parent_id', parentId())->pluck('name', 'id');
            return view('report.income', compact('incomes', 'customers'));
        } else {
            return redirect()->back()->with('error', 'Permission deneid');
        }
    }

    public function generateIncomeReport(Request $request)
    {
        if (Auth::user()->can('manage income report')) {
            $query = Invoice::where('parent_id', parentId())->whereIn('status', ['partial_paid', 'paid']);

            if ($request->filled('customer_id')) {
                $query->where('customer_id', $request->customer_id);
            }

            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);

                if (count($dates) === 2) {

                    $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
                    $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');

                    $query->whereDate('invoice_date', '>=', $start_date)
                        ->whereDate('invoice_date', '<=', $end_date);
                }
            }

            $incomes = $query->orderBy('id', 'desc')->get();
            $totalAmount = $incomes->sum(function ($invoice) {
                return $invoice->getInvoiceTotalAmount();
            });
            $formattedTotal = priceFormat($totalAmount);
            $html = view('report.income_table', compact('incomes'))->render();

            return response()->json(['html' => $html, 'total_amount' => $formattedTotal]);
        } else {
            return redirect()->back()->with('error', 'Permission deneid');
        }
    }
    public function expenseData()
    {
        if (Auth::user()->can('manage expense report')) {
            $expenses = Expense::where('parent_id', parentId())->get();
            $categories = ExpenseCategory::where('parent_id', parentId())->pluck('name', 'id');
            $subCategories = ExpenseSubCategory::where('parent_id', parentId())->pluck('name', 'id');

            return view('report.expense', compact('expenses', 'categories', 'subCategories'));
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function generateExpenseReport(Request $request)
    {
        if (Auth::user()->can('manage expense report')) {
            $query = Expense::where('parent_id', parentId());

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->filled('sub_category_id')) {
                $query->where('sub_category_id', $request->sub_category_id);
            }

            if ($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);

                if (count($dates) === 2) {

                    $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
                    $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');

                    $query->whereDate('date', '>=', $start_date)
                        ->whereDate('date', '<=', $end_date);
                }
            }

            $expenses = $query->orderBy('id', 'desc')->get();
            $totalAmount = $expenses->sum('amount');
            $formattedTotal = priceFormat($totalAmount);
            $html = view('report.expense_table', compact('expenses'))->render();

            return response()->json(['html' => $html, 'total_amount' => $formattedTotal]);
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function yearlyProfitLoss()
    {
        if (Auth::user()->can('manage profit loss report')) {
            return view('report.yearly_profit_loss');
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function generateProfitLossReport(Request $request)
    {
        if (Auth::user()->can('manage profit loss report')) {
            $year = $request->input('year', now()->year);

            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                $expenses = Expense::select(
                    DB::raw("strftime('%m', date) as month"),
                    DB::raw('SUM(amount) as total_expense')
                )
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
                    ->whereYear('date', $year)
                    ->groupBy(DB::raw('MONTH(date)'))
                    ->orderBy('month')
                    ->get()
                    ->keyBy('month');
            }

            $invoiceGroups = Invoice::whereYear('invoice_date', $year)
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

            $html = view('report.yearly_summary_table', compact('report'))->render();

            return response()->json([
                'html' => $html,
                'report' => $report,
                'total_income' => priceFormat(number_format($total_income, 2)),
                'total_expense' => priceFormat(number_format($total_expense, 2)),
                'total_profit' => priceFormat(number_format($total_income - $total_expense, 2)),
                'currency_symbol' => $currency_symbol,
            ]);
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }
}
