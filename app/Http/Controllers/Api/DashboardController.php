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
            $totalOrders = Order::where('parent_id', parentId())->count();
            $thisMonthOrders = Order::where('parent_id', parentId())
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();

            $monthlyIncome = InvoicePayment::where('parent_id', parentId())
                ->whereMonth('payment_date', Carbon::now()->month)
                ->whereYear('payment_date', Carbon::now()->year)
                ->sum('amount');
            if ($monthlyIncome == 0) {
                $monthlyIncome = Order::where('parent_id', parentId())
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('total_amount');
            }

            $activeFittings = Order::where('parent_id', parentId())
                ->whereIn('status', ['fitting', 'trial', 'pending', 'in_progress', 'in_stitching'])
                ->count();
            $scheduledToday = Order::where('parent_id', parentId())
                ->whereDate('delivery_date', Carbon::today())
                ->count();

            $totalCustomers = User::where('parent_id', parentId())->where('type', 'customer')->count();

            $result['stats'] = [
                'total_orders' => [
                    'label' => 'Total Orders',
                    'value' => (string) $totalOrders,
                    'subtext' => '+' . $thisMonthOrders . ' this month',
                    'icon' => 'shopping_bag_outlined',
                ],
                'revenue' => [
                    'label' => 'Monthly Revenue',
                    'value' => $currency_symbol . number_format($monthlyIncome, 0),
                    'subtext' => 'This month',
                    'icon' => 'account_balance_wallet_outlined',
                ],
                'active_fittings' => [
                    'label' => 'Active Fittings',
                    'value' => (string) $activeFittings,
                    'subtext' => $scheduledToday . ' scheduled today',
                    'icon' => 'checkroom_rounded',
                ],
                'customers' => [
                    'label' => 'Total Clients',
                    'value' => (string) $totalCustomers,
                    'subtext' => 'Registered clients',
                    'icon' => 'people_outline_rounded',
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
        $currency_symbol = settings()['CURRENCY_SYMBOL'] ?? '₹';
        $query = Order::with(['customer'])->orderBy('id', 'desc');

        if ($user->type == 'customer') {
            $query->where('customer_id', $user->id);
        } elseif ($user->type == 'employee') {
            $query->where('responsible', $user->id);
        } else {
            $query->where('parent_id', parentId());
        }

        return $query->limit(10)->get()->map(function ($order) use ($currency_symbol) {
            $customerName = 'Guest Customer';
            if ($order->customer) {
                $customerName = $order->customer->name;
            } elseif (!empty($order->customer_name)) {
                $customerName = $order->customer_name;
            }

            $garmentName = 'Bespoke Garment';
            if (!empty($order->product_name)) {
                $garmentName = $order->product_name;
            } elseif (!empty($order->item_name)) {
                $garmentName = $order->item_name;
            }

            return [
                'id' => $order->id,
                'order_id' => "#DD-" . str_pad($order->id, 3, '0', STR_PAD_LEFT),
                'client_name' => $customerName,
                'customer_name' => $customerName,
                'garment' => $garmentName,
                'date' => $order->created_at ? $order->created_at->format('M d, h:i A') : 'Today',
                'status' => ucfirst(str_replace('_', ' ', $order->status ?? 'pending')),
                'total_amount' => $currency_symbol . number_format($order->total_amount ?? 0, 0),
                'amount' => $currency_symbol . number_format($order->total_amount ?? 0, 0),
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
