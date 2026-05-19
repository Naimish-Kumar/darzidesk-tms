<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClothType;
use App\Models\Expense;
use App\Models\InvoicePayment;
use App\Models\Measurement;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $result = [];
        $currency_symbol = settings()['CURRENCY_SYMBOL'] ?? '₹';

        if ($user->type == 'super admin') {
            // Super Admin features can be added here if needed
            return response()->json(['success' => false, 'message' => 'Super Admin dashboard not implemented yet for mobile.']);
        } elseif ($user->type == 'employee') {
            $result['stats'] = [
                'total_customer' => [
                    'label' => 'Total Customers',
                    'value' => (string)User::where('parent_id', parentId())->where('type', 'customer')->count(),
                    'icon' => 'people',
                ],
                'total_measurement' => [
                    'label' => 'My Measurements',
                    'value' => (string)Measurement::where('responsible', $user->id)->count(),
                    'icon' => 'straighten',
                ],
                'total_order' => [
                    'label' => 'My Orders',
                    'value' => (string)Order::where('responsible', $user->id)->count(),
                    'icon' => 'shopping_bag',
                ],
                'today_orders' => [
                    'label' => "Today's Orders",
                    'value' => (string)Order::where('responsible', $user->id)->whereDate('order_date', Carbon::today())->count(),
                    'icon' => 'today',
                ],
            ];
            $result['chart_data'] = $this->totalOrderStatus();
            $result['recent_orders'] = $this->getRecentOrders($user);
        } elseif ($user->type == 'customer') {
            $result['stats'] = [
                'total_measurement' => [
                    'label' => 'My Measurements',
                    'value' => (string)Measurement::where('customer', $user->id)->count(),
                    'icon' => 'straighten',
                ],
                'total_order' => [
                    'label' => 'My Orders',
                    'value' => (string)Order::where('customer_id', $user->id)->count(),
                    'icon' => 'shopping_bag',
                ],
                'paid_amount' => [
                    'label' => 'Paid Amount',
                    'value' => $currency_symbol . number_format($this->getCustomerAmount($user->id, 'paid'), 2),
                    'icon' => 'check_circle',
                ],
                'unpaid_amount' => [
                    'label' => 'Unpaid Amount',
                    'value' => $currency_symbol . number_format($this->getCustomerAmount($user->id, 'unpaid'), 2),
                    'icon' => 'error_outline',
                ],
            ];
            $result['recent_orders'] = $this->getRecentOrders($user);
        } else {
            // Owner / Manager
            $result['stats'] = [
                'total_customer' => [
                    'label' => 'Total Customers',
                    'value' => (string)User::where('parent_id', parentId())->where('type', 'customer')->count(),
                    'icon' => 'people',
                ],
                'total_cloth_type' => [
                    'label' => 'Cloth Types',
                    'value' => (string)ClothType::where('parent_id', parentId())->count(),
                    'icon' => 'inventory_2',
                ],
                'total_income' => [
                    'label' => 'Total Income',
                    'value' => $currency_symbol . number_format(InvoicePayment::where('parent_id', parentId())->sum('amount'), 2),
                    'icon' => 'trending_up',
                ],
                'total_expense' => [
                    'label' => 'Total Expense',
                    'value' => $currency_symbol . number_format(Expense::where('parent_id', parentId())->sum('amount'), 2),
                    'icon' => 'trending_down',
                ],
            ];
            $result['chart_data'] = $this->incomeByMonth();
            $result['recent_orders'] = $this->getRecentOrders($user);
        }

        return response()->json([
            'success' => true,
            'data' => array_merge([
                'welcome_message' => "Welcome Back, " . $user->name,
            ], $result)
        ]);
    }

    private function getRecentOrders($user)
    {
        $query = Order::orderBy('id', 'desc');
        
        if ($user->type == 'customer') {
            $query->where('customer_id', $user->id);
        } elseif ($user->type == 'employee') {
            $query->where('responsible', $user->id);
        } else {
            $query->where('parent_id', parentId());
        }

        return $query->limit(10)->get()->map(function($order) {
            return [
                'id' => $order->id,
                'order_id' => "#DD" . $order->id,
                'customer_name' => $order->customer_name ?? 'Unknown',
                'date' => $order->created_at->format('M d, Y'),
                'status' => ucfirst($order->status),
                'total_amount' => $order->total_amount,
            ];
        });
    }

    private function getCustomerAmount($customerId, $status)
    {
        return \DB::table('invoices')
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->leftJoin('taxes', 'invoice_items.tax', '=', 'taxes.id')
            ->where('invoices.customer_id', $customerId)
            ->where('invoices.status', $status)
            ->selectRaw('
                    SUM(invoice_items.amount * invoice_items.quantity)
                    + SUM(COALESCE((invoice_items.amount * invoice_items.quantity) * taxes.rate / 100, 0)) as total
                ')
            ->value('total') ?? 0;
    }

    private function incomeByMonth()
    {
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $currentDate = $start->copy();
        $data = ['labels' => [], 'income' => [], 'expense' => []];

        while ($currentDate <= $end) {
            $data['labels'][] = $currentDate->format('M');
            $data['income'][] = InvoicePayment::where('parent_id', parentId())
                ->whereMonth('payment_date', $currentDate->month)
                ->whereYear('payment_date', $currentDate->year)
                ->sum('amount');
            $data['expense'][] = Expense::where('parent_id', parentId())
                ->whereMonth('date', $currentDate->month)
                ->whereYear('date', $currentDate->year)
                ->sum('amount');
            $currentDate->addMonth();
        }

        return $data;
    }

    private function totalOrderStatus()
    {
        $start = Carbon::now()->subDays(6);
        $end = Carbon::now();

        $currentDate = $start->copy();
        $data = ['labels' => [], 'completed' => [], 'pending' => []];

        while ($currentDate <= $end) {
            $data['labels'][] = $currentDate->format('D');
            $data['completed'][] = Order::where('responsible', Auth::id())
                ->where('status', 'completed')
                ->whereDate('order_date', $currentDate->toDateString())
                ->count();
            $data['pending'][] = Order::where('responsible', Auth::id())
                ->where('status', 'pending')
                ->whereDate('order_date', $currentDate->toDateString())
                ->count();
            $currentDate->addDay();
        }

        return $data;
    }
}
