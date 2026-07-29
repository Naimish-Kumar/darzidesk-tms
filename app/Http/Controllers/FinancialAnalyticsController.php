<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Material;
use App\Models\ProductionAssignment;
use Illuminate\Http\Request;

class FinancialAnalyticsController extends Controller
{
    public function index()
    {
        // 1. Total Revenue from Payments
        $totalRevenue = InvoicePayment::sum('amount');

        // 2. Outstanding Collections (Unpaid parts of invoices)
        $invoices = Invoice::with(['items', 'payments'])->get();
        $outstandingAmount = $invoices->sum(fn($inv) => $inv->getInvoiceDueAmount());

        // 3. Piece-rate Payouts (Expenses to tailors)
        $tailorPayouts = ProductionAssignment::where('status', 'completed')->sum('piece_rate_pay');

        // 4. Material Stock Valuation
        $stockValuation = Material::sum(\DB::raw('quantity * unit_cost'));

        // 5. Total Operating Expenses (excluding tailor payouts)
        $operatingExpenses = Expense::sum('amount');

        // 6. Grouped Expenses Category-wise for charts
        $expenseCategories = Expense::select('category_id', \DB::raw('sum(amount) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        return view('financials.analytics', compact(
            'totalRevenue',
            'outstandingAmount',
            'tailorPayouts',
            'stockValuation',
            'operatingExpenses',
            'expenseCategories'
        ));
    }
}
