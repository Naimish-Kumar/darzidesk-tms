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
use App\Models\TailorService;
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
                $result['totalPlatformCustomers'] = User::where('type', 'customer')->count();
                $result['totalPlatformOrders'] = Order::count();

                $result['recentOwners'] = User::where('type', 'owner')->with('subscriptions')->latest()->take(5)->get();
                $result['recentTransactions'] = PackageTransaction::with('user')->latest()->take(5)->get();

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
                    ->leftJoin('taxes', 'invoice_items.tax', '=', 'taxes.id')
                    ->where('invoices.customer_id', Auth::user()->id)
                    ->where('invoices.status', 'paid')
                    ->selectRaw('
                            SUM(invoice_items.amount * invoice_items.quantity)
                            + COALESCE(SUM((invoice_items.amount * invoice_items.quantity) * taxes.rate / 100), 0) as total
                        ')
                    ->value('total');

                $result['totalUnpaidAmount'] = \DB::table('invoices')
                    ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
                    ->leftJoin('taxes', 'invoice_items.tax', '=', 'taxes.id')
                    ->where('invoices.customer_id', Auth::user()->id)
                    ->where('invoices.status', 'unpaid')
                    ->selectRaw('SUM(invoice_items.amount * invoice_items.quantity) + COALESCE(SUM((invoice_items.amount * invoice_items.quantity) * taxes.rate / 100), 0) as total')
                    ->value('total');
                $result['notifyOrder'] = $this->getnotify();
                $result['recentOrders'] = Order::where('customer_id', Auth::user()->id)->with(['clothTypes', 'users'])->orderBy('id', 'desc')->take(5)->get();
                $result['ordersByMonth'] = $this->customerOrdersByMonth();
                return view('dashboard.index', compact('result'));
            } else {
                $result['totalCustomer'] = User::where('parent_id', parentId())->where('type', 'customer')->count();
                $result['totalClothType'] = ClothType::where('parent_id', parentId())->count();
                $result['totalIncome'] = InvoicePayment::where('parent_id', parentId())->sum('amount');
                $result['totalExpense'] = Expense::where('parent_id', parentId())->sum('amount');
                $result['totalOrders'] = Order::where('parent_id', parentId())->count();
                $result['pendingOrders'] = Order::where('parent_id', parentId())->whereIn('status', ['pending', 'in_progress'])->count();
                $result['completedOrders'] = Order::where('parent_id', parentId())->whereIn('status', ['completed', 'delivered'])->count();
                $result['recentOrders'] = Order::where('parent_id', parentId())->with(['customers', 'clothTypes'])->orderBy('id', 'desc')->take(6)->get();
                $result['incomeExpenseByMonth'] = $this->incomeByMonth();
                $result['orderStatusDistribution'] = $this->orderStatusDistribution();
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

    public function orderStatusDistribution()
    {
        $statuses = Order::$status;
        $labels = [];
        $counts = [];
        foreach ($statuses as $key => $label) {
            $count = Order::where('parent_id', parentId())->where('status', $key)->count();
            $labels[] = __($label);
            $counts[] = $count;
        }
        return ['labels' => $labels, 'counts' => $counts];
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

    public function tailorDetail($id)
    {
        // Check if database has seeded owners, if not seed automatically
        if (User::where('type', 'owner')->count() == 0) {
            try {
                \Artisan::call('db:seed', ['--class' => 'MarketplaceSeeder']);
            } catch (\Throwable $e) {}
        }

        $dbTailor = User::where('type', 'owner')->where('id', $id)->first();
        if (!$dbTailor) {
            $dbTailor = User::where('type', 'owner')->first();
        }

        $dbServices = [];
        if ($dbTailor) {
            $servicesFromDb = TailorService::where('user_id', $dbTailor->id)->get();
            foreach ($servicesFromDb as $srv) {
                $dbServices[] = [
                    'name' => $srv->title,
                    'price' => '₹' . number_format($srv->price_starts_at, 2),
                    'time' => $srv->estimated_days . ' Days Turnaround',
                    'desc' => $srv->description ?? 'Bespoke custom fitting and stitching by master artisans.',
                ];
            }
        }

        $shops = [
            '1' => [
                'id' => $dbTailor ? $dbTailor->id : 1,
                'shop_name' => $dbTailor && $dbTailor->shop_name ? $dbTailor->shop_name : 'Savile & Row Atelier',
                'owner_name' => $dbTailor ? $dbTailor->name : 'Master Tailor Julian Vance',
                'location' => $dbTailor && $dbTailor->city ? $dbTailor->city : 'Mayfair, London',
                'address' => $dbTailor && $dbTailor->address ? $dbTailor->address : '24 Savile Row, Mayfair, London W1S 3PR, UK',
                'phone' => $dbTailor && $dbTailor->phone_number ? $dbTailor->phone_number : '+442079460912',
                'whatsapp' => $dbTailor && $dbTailor->whatsapp_number ? $dbTailor->whatsapp_number : '+442079460912',
                'rating' => $dbTailor && $dbTailor->rating ? number_format($dbTailor->rating, 1) : '4.9',
                'reviews_count' => $dbTailor && $dbTailor->review_count ? $dbTailor->review_count : 248,
                'experience' => '15+ Yrs',
                'orders_completed' => '2.4k+',
                'response_time' => '< 2hr',
                'fitting_accuracy' => '99.8%',
                'cover_image' => asset('assets/images/hero_tailor_atelier.jpg'),
                'banner_image' => asset('assets/images/bespoke_tailor_atelier_hero.jpg'),
                'avatar_image' => asset('assets/images/logo_wide.png'),
                'bio' => 'Savile & Row Atelier, led by Master Tailor Julian Vance, has been the cornerstone of sartorial excellence for over 15 years. Specializing in handcrafted bespoke suits, double-breasted tuxedos, and traditional heritage wear, we combine ancient hand-stitching techniques with modern silhouettes. Every stitch is a testament to our commitment to precision, durability, and individual character.',
                'specialties' => ['Bespoke Suits', 'Tuxedos', 'Double-Breasted Jackets', 'Executive Restyling', 'Fitting Consultations', 'Monogramming'],
                'company_partners' => [
                    ['name' => 'Loro Piana', 'country' => 'Italy', 'tag' => 'Official Mill Partner', 'icon' => 'ti-crown'],
                    ['name' => 'Ermenegildo Zegna', 'country' => 'Italy', 'tag' => 'Luxury Fine Cloth', 'icon' => 'ti-diamond'],
                    ['name' => 'Scabal', 'country' => 'Savile Row', 'tag' => 'Bespoke Fabrics', 'icon' => 'ti-award'],
                    ['name' => 'Dormeuil', 'country' => 'France / UK', 'tag' => 'Heritage Textiles', 'icon' => 'ti-certificate'],
                    ['name' => 'Holland & Sherry', 'country' => 'Scotland', 'tag' => 'Superfine Tweeds', 'icon' => 'ti-star'],
                    ['name' => 'Albini 1876', 'country' => 'Italy', 'tag' => 'Egyptian Cotton', 'icon' => 'ti-building']
                ],
                'craftsmanship_guarantees' => [
                    ['title' => 'Full Floating Horsehair Canvas', 'desc' => '100% natural horsehair canvas mold for perfect natural drape and breathability.'],
                    ['title' => '3,000+ Hand Lapel Stitches', 'desc' => 'Over 3,000 individual hand stitches in lapels ensuring a lifetime natural roll.'],
                    ['title' => '12-Month Fit Warranty', 'desc' => 'Complimentary fitting adjustments for 1 full year after purchase.'],
                    ['title' => 'Digital 3D Measurement Passport', 'desc' => 'Your exact physical anatomy measurements saved securely in DarziDesk.']
                ],
                'amenities' => ['Private VIP Fitting Lounge', 'Master Tailor In-Person Session', 'Complimentary Espresso & Champagne Bar', 'On-Site Alteration Studio', 'Worldwide Express Delivery'],
                'languages' => ['English', 'Italian', 'French', 'Hindi'],
                'payment_methods' => ['Visa / Mastercard', 'American Express', 'Apple Pay / Google Pay', 'Wire Transfer', 'Cash'],
                'services' => !empty($dbServices) ? $dbServices : [
                    ['name' => 'Bespoke 2-Piece Suit', 'price' => '₹18,500', 'time' => '14 Days Turnaround', 'desc' => 'Full canvas construction with hand-padded lapels and 2 fitting sessions.'],
                    ['name' => 'Ceremonial Tuxedo & Vest', 'price' => '₹22,000', 'time' => '10 Days Turnaround', 'desc' => 'Satin peak lapels, custom silk lining, and hand-embroidered monogramming.'],
                    ['name' => 'Master Alteration & Fitting', 'price' => '₹1,800', 'time' => '48 Hours Turnaround', 'desc' => 'Waist, shoulder, and sleeve length adjustments for off-the-rack garments.'],
                    ['name' => 'Custom Dress Shirt', 'price' => '₹2,500', 'time' => '5 Days Turnaround', 'desc' => 'Italian Egyptian cotton with choice of collar, cuff style, and pearl buttons.']
                ],
                'fabrics' => [
                    ['name' => 'Super 150s Merino Wool', 'mill' => 'Loro Piana, Italy', 'badge' => 'Premium Mill'],
                    ['name' => 'Handwoven Mulberry Silk', 'mill' => 'Varanasi Weavers, India', 'badge' => 'Heritage Weave'],
                    ['name' => 'English Tweed Wool', 'mill' => 'Harris Tweed, Scotland', 'badge' => 'Durable Pure Wool'],
                    ['name' => 'Egyptian Giza Cotton', 'mill' => 'Albini 1876, Italy', 'badge' => 'Soft Touch Cotton'],
                ],
                'reviews' => [
                    ['name' => 'Jameson Aris', 'role' => 'Creative Director', 'rating' => 5, 'text' => 'The level of precision Julian provides is unmatched. I\'ve never had a suit fit so perfectly on the first try. A truly seamless experience from fabric selection to final fitting.'],
                    ['name' => 'Priya Sharma', 'role' => 'Cultural Specialist', 'rating' => 5, 'text' => 'Finding a tailor for traditional heritage wear used to be a challenge. Julian\'s studio connected me with an incredible artisan who understood silk embroidery.'],
                    ['name' => 'Robert Sterling', 'role' => 'Investment Partner', 'rating' => 5, 'text' => 'The tracking feature during production is a game-changer. I could see exactly when my coat was being cut and stitched. Exceptional service and transparency.']
                ]
            ],
            '2' => [
                'id' => 2,
                'slug' => 'the-stitch-lab',
                'shop_name' => 'The Stitch Lab Studio',
                'owner_name' => 'Master Artisan Clara Sterling',
                'location' => 'Soho, London',
                'address' => '88 Soho High Street, London W1D 3BF, UK',
                'phone' => '+442079460915',
                'whatsapp' => '+442079460915',
                'rating' => 4.8,
                'reviews_count' => 192,
                'experience' => '10+ Yrs',
                'orders_completed' => '1.8k+',
                'response_time' => '< 1hr',
                'fitting_accuracy' => '99.5%',
                'cover_image' => asset('assets/images/hero_tailor_atelier.jpg'),
                'banner_image' => asset('assets/images/bespoke_tailor_atelier_hero.jpg'),
                'avatar_image' => asset('assets/images/logo_wide.png'),
                'bio' => 'The Stitch Lab Studio focuses on modern silhouettes, Italian drape, and contemporary bespoke tailoring for executives and wedding parties. We combine state-of-the-art digital body scanning with hand finishing.',
                'specialties' => ['Modern Cut Suits', 'Elite Alterations', 'Silk Dresses', 'Blazer Restyling'],
                'company_partners' => [
                    ['name' => 'Reda 1865', 'country' => 'Italy', 'tag' => 'Sustainable Wool', 'icon' => 'ti-leaf'],
                    ['name' => 'Baird McNutt', 'country' => 'Ireland', 'tag' => 'Irish Linen', 'icon' => 'ti-sun'],
                    ['name' => 'Loro Piana', 'country' => 'Italy', 'tag' => 'Superfine Wool', 'icon' => 'ti-crown'],
                    ['name' => 'Albini 1876', 'country' => 'Italy', 'tag' => 'Luxury Cotton', 'icon' => 'ti-building']
                ],
                'craftsmanship_guarantees' => [
                    ['title' => 'Digital Body Scanning', 'desc' => 'Millimeter-precise 3D anatomical scanning for perfect modern contouring.'],
                    ['title' => 'Lightweight Unconstructed Drape', 'desc' => 'Soft shoulder construction designed for modern comfort and versatility.'],
                    ['title' => '6-Month Fit Warranty', 'desc' => 'Complimentary adjustments for 6 months after delivery.']
                ],
                'amenities' => ['Digital Fitting Suite', 'Same-Day Express Fitting', 'High-Speed Wi-Fi & Lounge', 'Courier Delivery'],
                'languages' => ['English', 'Spanish', 'Italian'],
                'payment_methods' => ['Visa / Mastercard', 'Apple Pay', 'Google Pay', 'Cash'],
                'services' => [
                    ['name' => 'Italian Slim Fit Blazer', 'price' => '₹14,500', 'time' => '10 Days Turnaround', 'desc' => 'Lightweight unconstructed blazer with horn buttons.'],
                    ['name' => 'Express Alteration Service', 'price' => '₹1,400', 'time' => '24 Hours Turnaround', 'desc' => 'Emergency resizing for jackets, trousers, and skirts.'],
                ],
                'fabrics' => [
                    ['name' => 'Italian Stretch Wool', 'mill' => 'Reda 1865, Italy', 'badge' => 'Modern Fit'],
                    ['name' => 'Organic Irish Linen', 'mill' => 'Baird McNutt, Ireland', 'badge' => 'Summer Breathable'],
                ],
                'reviews' => [
                    ['name' => 'Marcus Chen', 'role' => 'Architect', 'rating' => 5, 'text' => 'Clara is a genius with modern cuts. The fit of my unstructured blazer is phenomenal.']
                ]
            ],
            '3' => [
                'id' => 3,
                'slug' => 'heritage-threads',
                'shop_name' => 'Heritage Threads Atelier',
                'owner_name' => 'Master Craftsman Rajesh Sharma',
                'location' => 'Kensington, London',
                'address' => '12 Kensington Palace Gardens, London W8 4QQ, UK',
                'phone' => '+442079460920',
                'whatsapp' => '+442079460920',
                'rating' => 5.0,
                'reviews_count' => 310,
                'experience' => '20+ Yrs',
                'orders_completed' => '3.5k+',
                'response_time' => '< 30min',
                'fitting_accuracy' => '99.9%',
                'cover_image' => asset('assets/images/hero_tailor_atelier.jpg'),
                'banner_image' => asset('assets/images/bespoke_tailor_atelier_hero.jpg'),
                'avatar_image' => asset('assets/images/logo_wide.png'),
                'bio' => 'Heritage Threads Atelier is world-renowned for hand-embroidered royal Sherwanis, Zardozi craftsmanship, Bandhgala suits, and ceremonial wedding ensembles crafted with pure gold and silver wire work.',
                'specialties' => ['Royal Sherwanis', 'Silk Kurtas', 'Zardozi Embroidery', 'Bandhgala Suits'],
                'company_partners' => [
                    ['name' => 'Varanasi Royal Looms', 'country' => 'India', 'tag' => 'Pure Silk', 'icon' => 'ti-crown'],
                    ['name' => 'Heritage Crafts India', 'country' => 'India', 'tag' => 'Gold Wire Work', 'icon' => 'ti-star'],
                    ['name' => 'Loro Piana', 'country' => 'Italy', 'tag' => 'Cashmere & Silk', 'icon' => 'ti-diamond'],
                    ['name' => 'Scabal', 'country' => 'Savile Row', 'tag' => 'Royal Velvet', 'icon' => 'ti-award']
                ],
                'craftsmanship_guarantees' => [
                    ['title' => 'Authentic Hand Zardozi', 'desc' => 'Hand-stitched metallic embroidery using pure silver and gold wire.'],
                    ['title' => 'Custom Weave Heritage Silk', 'desc' => 'Handloom silk sourced directly from master weavers in Varanasi.'],
                    ['title' => 'Lifetime Stitching Guarantee', 'desc' => 'Free lifetime seam repair and fitting preservation.']
                ],
                'amenities' => ['Private Bridal & Groom Lounge', 'Personal Artisan Consultation', 'Tea & Confectionery Service', 'Global Doorstep Delivery'],
                'languages' => ['English', 'Hindi', 'Punjabi', 'Gujarati'],
                'payment_methods' => ['Visa / Mastercard', 'UPI / NetBanking', 'Wire Transfer', 'Cash'],
                'services' => [
                    ['name' => 'Hand-Embroidered Bridal Sherwani', 'price' => '₹35,000', 'time' => '21 Days Turnaround', 'desc' => 'Custom velvet or raw silk Sherwani with Zardozi embroidery and matching dupatta.'],
                    ['name' => 'Classic Bandhgala Suit', 'price' => '₹16,000', 'time' => '12 Days Turnaround', 'desc' => 'Structured Indo-Western royal jacket with custom brass buttons.'],
                ],
                'fabrics' => [
                    ['name' => 'Pure Banarasi Raw Silk', 'mill' => 'Varanasi Royal Looms, India', 'badge' => 'Royal Heritage'],
                    ['name' => 'Velvet & Zardozi Thread', 'mill' => 'Heritage Crafts, India', 'badge' => 'Hand Embroidered'],
                ],
                'reviews' => [
                    ['name' => 'Amina Patel', 'role' => 'Event Designer', 'rating' => 5, 'text' => 'The embroidery detail on my husband\'s wedding Sherwani was breathtaking. Authentic master craftsmanship.']
                ]
            ]
        ];

        $shopKey = isset($shops[$id]) ? $id : '1';
        $tailor = $shops[$shopKey];
        $settings = settings();

        return view('tailor_detail', compact('tailor', 'settings'));
    }

    public function bookTailorAppointment(\Illuminate\Http\Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'customer_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'appointment_date' => 'required|date',
            'service_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
        }

        $bookingRef = 'APT-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

        return redirect()->back()->with('success', __("Fitting consultation booked successfully! Your Booking Reference ID is :ref. The studio master tailor will contact you via WhatsApp / Phone to confirm your appointment time.", ['ref' => $bookingRef]));
    }

    public function customerOrdersByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));
        $currentdate = $start;

        $ordersData = [
            'label' => [],
            'data' => [],
        ];
        while ($currentdate <= $end) {
            $ordersData['label'][] = date('M', $currentdate);
            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $ordersData['data'][] = Order::where('customer_id', Auth::user()->id)
                ->whereMonth('order_date', $month)
                ->whereYear('order_date', $year)
                ->count();
            $currentdate = strtotime('+1 month', $currentdate);
        }
        return $ordersData;
    }
}

