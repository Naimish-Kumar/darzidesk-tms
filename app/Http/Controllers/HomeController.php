<?php

namespace App\Http\Controllers;

use App\Models\ClothType;
use App\Models\Contact;
use App\Models\Custom;
use App\Models\Expense;
use App\Models\FAQ;
use App\Models\HomePage;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Measurement;
use App\Models\NoticeBoard;
use App\Models\Order;
use App\Models\PackageTransaction;
use App\Models\Page;
use App\Models\Subscription;
use App\Models\Support;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->type == 'super admin') {
                $result['totalOrganization'] = User::where('type', 'owner')->count();
                $result['totalSubscription'] = Subscription::count();
                $result['totalTransaction'] = PackageTransaction::count();
                $result['totalIncome'] = PackageTransaction::sum('amount');
                $result['totalNote'] = NoticeBoard::where('parent_id', parentId())->count();
                $result['totalContact'] = Contact::where('parent_id', parentId())->count();

                $result['organizationByMonth'] = $this->organizationByMonth();
                $result['paymentByMonth'] = $this->paymentByMonth();

                return view('dashboard.super_admin', compact('result'));
            } elseif (Auth::user()->type == 'employee') {
                $result['totalCustomer'] = User::where('parent_id', parentId())->where('type', 'customer')->count();
                $result['totalMeasurement'] = Measurement::where('responsible', Auth::user()->id)->count();
                $result['totalOrder'] = Order::where('responsible', Auth::user()->id)->count();
                $result['totalTodayOrder'] = Order::where('responsible', Auth::user()->id)->where('order_date', today())->count();
                $result['totalOrderStatus'] = $this->totalOrderStatus();

                $result['notifyOrder'] = $this->getnotify();
                return view('dashboard.index', compact('result'));
            } elseif (Auth::user()->type == 'customer') {
                $result['totalMeasurement'] = Measurement::where('customer', Auth::user()->id)->count();
                $result['totalOrder'] = Order::where('customer_id', Auth::user()->id)->count();
                $result['totalPaidAmount'] = \DB::table('invoices')
                    ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
                    ->join('taxes', 'invoice_items.tax', '=', 'taxes.id')
                    ->where('invoices.customer_id', Auth::user()->id)
                    ->where('invoices.status', 'paid')
                    ->selectRaw('
                            SUM(invoice_items.amount * invoice_items.quantity)
                            + SUM((invoice_items.amount * invoice_items.quantity) * taxes.rate / 100) as total
                        ')
                    ->value('total');

                $result['totalUnpaidAmount'] = \DB::table('invoices')
                    ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
                    ->join('taxes', 'invoice_items.tax', '=', 'taxes.id')
                    ->where('invoices.customer_id', Auth::user()->id)
                    ->where('invoices.status', 'unpaid')
                    ->selectRaw('SUM(invoice_items.amount * invoice_items.quantity) + SUM((invoice_items.amount * invoice_items.quantity) * taxes.rate / 100) as total')
                    ->value('total');
                $result['notifyOrder'] = $this->getnotify();
                return view('dashboard.index', compact('result'));
            } else {
                $result['totalCustomer'] = User::where('parent_id', parentId())->where('type', 'customer')->count();
                $result['totalClothType'] = ClothType::where('parent_id', parentId())->count();
                $result['totalIncome'] = InvoicePayment::where('parent_id', parentId())->sum('amount');
                $result['totalExpense'] = Expense::where('parent_id', parentId())->sum('amount');
                $result['incomeExpenseByMonth'] = $this->incomeByMonth();
                $result['settings'] = settings();
                $result['subscription'] = Subscription::find(Auth::user()->subscription);

                return view('dashboard.index', compact('result'));
            }
        } else {
            if (!file_exists(setup())) {
                header('location:install');
                die;
            } else {

                $landingPage = getSettingsValByName('landing_page');
                if ($landingPage == 'on') {
                    $subscriptions = Subscription::get();
                    $menus = Page::where('enabled', 1)->get();
                    $FAQs = FAQ::where('enabled', 1)->get();
                    return view('layouts.landing', compact('subscriptions', 'menus', 'FAQs'));
                } else {
                    return redirect()->route('login');
                }
            }
        }
    }

    public function organizationByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $organization = [];
        while ($currentdate <= $end) {
            $organization['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $organization['data'][] = User::where('type', 'owner')->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            $currentdate = strtotime('+1 month', $currentdate);
        }


        return $organization;

    }

    public function paymentByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['data'][] = PackageTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('amount');
            $currentdate = strtotime('+1 month', $currentdate);
        }

        return $payment;

    }

    public function incomeByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['income'][] = InvoicePayment::where('parent_id', parentId())->whereMonth('payment_date', $month)->whereYear('payment_date', $year)->sum('amount');
            $payment['expense'][] = Expense::where('parent_id', parentId())->whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
            $currentdate = strtotime('+1 month', $currentdate);
        }

        return $payment;

    }

    public function totalOrderStatus()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $currentDate = $start->copy();

        $orderData = [
            'label' => [],
            'completed' => [],
            'pending' => [],
        ];

        while ($currentDate <= $end) {
            $orderData['label'][] = $currentDate->format('d-M');

            $completed = Order::where('responsible', Auth::user()->id)
                ->where('status', 'completed')
                ->whereDate('order_date', $currentDate->toDateString())
                ->count();

            $pending = Order::where('responsible', Auth::user()->id)
                ->where('status', 'pending')
                ->whereDate('order_date', $currentDate->toDateString())
                ->count();

            $orderData['completed'][] = $completed;
            $orderData['pending'][] = $pending;

            $currentDate->addDay();
        }

        return $orderData;
    }

public function getnotify()
{
    if (Auth::user()->type == 'customer') {
        $orders = Order::where('customer_id', Auth::user()->id)
                    ->where('status', '!=', 'delivered')
                    ->get();
        return $orders;

    } elseif (Auth::user()->type == 'employee') {
        $today = now()->startOfDay();
        $nextWeek = now()->addDays(7)->endOfDay(); // get next 7 days

        $orders = Order::where('responsible', Auth::user()->id)
                    ->whereBetween('deadline_date', [$today, $nextWeek])
                    ->get();
        return $orders;
    }
}

}
