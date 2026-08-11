<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Expense;
use App\Models\Invoice;
use Illuminate\Http\Request;

class FinancialDashboardController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $expenses = Expense::all();
        $invoices = Invoice::all();

        $totalRevenue = $orders->sum('total_amount');
        $totalExpenses = $expenses->sum('amount');
        $netProfit = $totalRevenue - $totalExpenses;

        return view('financials.index', compact('totalRevenue', 'totalExpenses', 'netProfit', 'orders', 'expenses', 'invoices'));
    }
}
