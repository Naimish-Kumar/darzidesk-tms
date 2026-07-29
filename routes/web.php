<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthPageController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseSubCategoryController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Models\User;



use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ClothTypeController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'index'])->middleware(['XSS',])->name('home');
// Blog Management
Route::middleware(['auth', 'XSS'])->group(function () {
    Route::get('blogs', [App\Http\Controllers\BlogController::class, 'adminIndex'])->name('blog.admin.index');
    Route::get('blog/create', [App\Http\Controllers\BlogController::class, 'create'])->name('blog.create');
    Route::post('blog/store', [App\Http\Controllers\BlogController::class, 'store'])->name('blog.store');
    Route::get('blog/{id}/edit', [App\Http\Controllers\BlogController::class, 'edit'])->name('blog.edit');
    Route::put('blog/{id}/update', [App\Http\Controllers\BlogController::class, 'update'])->name('blog.update');
    Route::delete('blog/{id}/destroy', [App\Http\Controllers\BlogController::class, 'destroy'])->name('blog.destroy');
    Route::post('blog/{id}/status', [App\Http\Controllers\BlogController::class, 'status'])->name('blog.status');
});

Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Public Self-Service Client Portal & Digital QR Receipt Routes
Route::get('/order/track/{token}', [\App\Http\Controllers\PublicOrderTrackingController::class, 'track'])->name('order.public.track');
Route::get('/order/qr-receipt/{token}', [\App\Http\Controllers\PublicOrderTrackingController::class, 'qrReceipt'])->name('order.public.qr-receipt');
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);

Route::get('home', [HomeController::class, 'index'])->name('home')->middleware(
    [

        'XSS',
    ]
);
Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware(
    [

        'XSS',
    ]
);

//-------------------------------User-------------------------------------------

Route::resource('users', UserController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::get('login/otp', [OTPController::class, 'show'])->name('otp.show')->middleware(
    [

        'XSS',
    ]
);
Route::post('login/otp', [OTPController::class, 'check'])->name('otp.check')->middleware(
    [

        'XSS',
    ]
);
Route::get('login/2fa/disable', [OTPController::class, 'disable'])->name('2fa.disable')->middleware(['XSS',]);

//-------------------------------Subscription-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::resource('subscriptions', SubscriptionController::class);
        Route::get('coupons/history', [CouponController::class, 'history'])->name('coupons.history');
        Route::delete('coupons/history/{id}/destroy', [CouponController::class, 'historyDestroy'])->name('coupons.history.destroy');
        Route::get('coupons/apply', [CouponController::class, 'apply'])->name('coupons.apply');
        Route::resource('coupons', CouponController::class);
        Route::get('subscription/transaction', [SubscriptionController::class, 'transaction'])->name('subscription.transaction');
    }
);

//-------------------------------Subscription Payment-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::post('subscription/{id}/stripe/payment', [SubscriptionController::class, 'stripePayment'])->name('subscription.stripe.payment');

        // Thermal Print Web Routes
        Route::get('/orders/{id}/print-receipt', function ($id) {
            $order = \App\Models\Order::where('parent_id', parentId())->findOrFail($id);
            return view('order.print_receipt', compact('order'));
        })->name('orders.print-receipt');

        Route::get('/orders/{id}/print-tag', function ($id) {
            $order = \App\Models\Order::where('parent_id', parentId())->findOrFail($id);
            return view('order.print_tag', compact('order'));
        })->name('orders.print-tag');
    }
);
//-------------------------------Settings-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('settings', [SettingController::class, 'index'])->name('setting.index');

        Route::post('settings/account', [SettingController::class, 'accountData'])->name('setting.account');
        Route::delete('settings/account/delete', [SettingController::class, 'accountDelete'])->name('setting.account.delete');
        Route::post('settings/password', [SettingController::class, 'passwordData'])->name('setting.password');
        Route::post('settings/general', [SettingController::class, 'generalData'])->name('setting.general');
        Route::post('settings/smtp', [SettingController::class, 'smtpData'])->name('setting.smtp');
        Route::get('settings/smtp-test', [SettingController::class, 'smtpTest'])->name('setting.smtp.test');
        Route::post('settings/smtp-test', [SettingController::class, 'smtpTestMailSend'])->name('setting.smtp.testing');
        Route::post('settings/payment', [SettingController::class, 'paymentData'])->name('setting.payment');
        Route::post('settings/site-seo', [SettingController::class, 'siteSEOData'])->name('setting.site.seo');
        Route::post('settings/google-recaptcha', [SettingController::class, 'googleRecaptchaData'])->name('setting.google.recaptcha');
        Route::post('settings/company', [SettingController::class, 'companyData'])->name('setting.company');
        Route::post('settings/2fa', [SettingController::class, 'twofaEnable'])->name('setting.twofa.enable');

        Route::get('footer-setting', [SettingController::class, 'footerSetting'])->name('footerSetting');
        Route::post('settings/footer', [SettingController::class, 'footerData'])->name('setting.footer');

        Route::get('language/{lang}', [SettingController::class, 'lanquageChange'])->name('language.change');
        Route::post('theme/settings', [SettingController::class, 'themeSettings'])->name('theme.settings');

        Route::post('settings/twilio', [SettingController::class, 'twilio'])->name('setting.twilio');
    }
);


//-------------------------------Role & Permissions-------------------------------------------
Route::resource('permission', PermissionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('role', RoleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Note-------------------------------------------
Route::resource('note', NoticeBoardController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Contact-------------------------------------------
Route::resource('contact', ContactController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------logged History-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('logged/history', [UserController::class, 'loggedHistory'])->name('logged.history');
        Route::get('logged/{id}/history/show', [UserController::class, 'loggedHistoryShow'])->name('logged.history.show');
        Route::delete('logged/{id}/history', [UserController::class, 'loggedHistoryDestroy'])->name('logged.history.destroy');

        // Production Management Routes
        Route::get('production/kanban', [\App\Http\Controllers\ProductionKanbanController::class, 'index'])->name('production.kanban');
        Route::post('production/stage-update', [\App\Http\Controllers\ProductionKanbanController::class, 'updateStage'])->name('production.stage.update');

        Route::resource('production-stages', \App\Http\Controllers\ProductionStageController::class);
        Route::resource('materials', \App\Http\Controllers\MaterialController::class);
        Route::post('materials/{id}/restock', [\App\Http\Controllers\MaterialController::class, 'restock'])->name('materials.restock');

        Route::resource('worker-assignments', \App\Http\Controllers\WorkerAssignmentController::class);
        Route::post('worker-assignments/{id}/status', [\App\Http\Controllers\WorkerAssignmentController::class, 'updateStatus'])->name('worker-assignments.update-status');

        // POS & Invoicing Routes
        Route::get('pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
        Route::post('pos/store', [\App\Http\Controllers\PosController::class, 'store'])->name('pos.store');

        // Financial Analytics Routes
        Route::get('financials/analytics', [\App\Http\Controllers\FinancialAnalyticsController::class, 'index'])->name('financials.analytics');
        Route::get('financials', function () { return view('financials.index'); })->name('financials.index');

        // Dashboard Pages Navigation Routes
        Route::get('branches', function () { return view('branch.index'); })->name('branches.index');
        Route::get('branches/create/step-1', function () { return view('branch.create-step1'); })->name('branches.create.step1');
        Route::get('branches/create/step-2', function () { return view('branch.create-step2'); })->name('branches.create.step2');
        Route::get('branches/create/step-3', function () { return view('branch.create-step3'); })->name('branches.create.step3');
        Route::get('roles-permissions', function () { return view('roles.index'); })->name('roles.index');
        Route::get('billing', function () { return view('billing.index'); })->name('billing.index');
        Route::get('staff-management', function () { return view('staff.index'); })->name('staff.index');
        Route::get('orders-list', function () { return view('order.index'); })->name('orders.index');
        Route::get('business-profile', function () { return view('profile.index'); })->name('profile.index');

        // Staff Onboarding Multi-step Wizard Routes
        Route::get('staff-onboard/step-1', function () { return view('staff.onboard-step1'); })->name('staff.onboard.step1');
        Route::get('staff-onboard/step-2', function () { return view('staff.onboard-step2'); })->name('staff.onboard.step2');
        Route::get('staff-onboard/step-3', function () { return view('staff.onboard-step3'); })->name('staff.onboard.step3');

        // Customer Directory & Detail Profile Routes
        Route::get('customer-directory', function () { return view('customer.index'); })->name('customers.index');
        Route::get('customer-directory/{id}', function ($id) { return view('customer.show'); })->name('customers.show');

        // Production Pipeline Route
        Route::get('production-pipeline', function () { return view('production.index'); })->name('production.index');

        // Inventory Management & Add Material Routes
        Route::get('inventory-management', function () { return view('inventory.index'); })->name('inventory.index');
        Route::get('inventory/create', function () { return view('inventory.create'); })->name('inventory.create');

        // New Custom Order Multi-step Wizard Routes
        Route::get('orders/create/step-1', [\App\Http\Controllers\OrderController::class, 'createStep1'])->name('orders.create.step1');
        Route::post('orders/create/step-1', [\App\Http\Controllers\OrderController::class, 'storeStep1'])->name('orders.store.step1');
        Route::get('orders/create/step-2', [\App\Http\Controllers\OrderController::class, 'createStep2'])->name('orders.create.step2');
        Route::post('orders/create/step-2', [\App\Http\Controllers\OrderController::class, 'storeStep2'])->name('orders.store.step2');
        Route::get('orders/create/step-3', [\App\Http\Controllers\OrderController::class, 'createStep3'])->name('orders.create.step3');
        Route::post('orders/create/step-3', [\App\Http\Controllers\OrderController::class, 'storeStep3'])->name('orders.store.step3');

        // Communication Dashboard & Messaging Routes
        Route::get('communication', [\App\Http\Controllers\CommunicationController::class, 'index'])->name('communication.index');
        Route::get('communication/alerts', [\App\Http\Controllers\CommunicationController::class, 'alerts'])->name('communication.alerts');
        Route::get('communication/templates', [\App\Http\Controllers\CommunicationController::class, 'templates'])->name('communication.templates');
        Route::post('communication/send-alert', [\App\Http\Controllers\CommunicationController::class, 'sendAlert'])->name('communication.sendAlert');

        // POS & Invoicing Console Route
        Route::get('pos-console', function () { return view('pos.index'); })->name('pos.index');

        // Checkout & Payment Route
        Route::get('checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('checkout/process', [\App\Http\Controllers\CheckoutController::class, 'processPayment'])->name('checkout.process');

        // Promotions & Rewards Route
        Route::get('promotions', function () { return view('promotions.index'); })->name('promotions.index');

        // Register Reconciliation Route
        Route::get('reconciliation', [\App\Http\Controllers\ReconciliationController::class, 'index'])->name('reconciliation.index');
        Route::post('reconciliation/store', [\App\Http\Controllers\ReconciliationController::class, 'store'])->name('reconciliation.store');

        // Executive Overview Route
        Route::get('executive-overview', [\App\Http\Controllers\ExecutiveAnalyticsController::class, 'index'])->name('executive.index');
    }
);


//-------------------------------Plan Payment-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::post('subscription/{id}/bank-transfer', [PaymentController::class, 'subscriptionBankTransfer'])->name('subscription.bank.transfer');
        Route::get('subscription/{id}/bank-transfer/action/{status}', [PaymentController::class, 'subscriptionBankTransferAction'])->name('subscription.bank.transfer.action');
        Route::post('subscription/{id}/paypal', [PaymentController::class, 'subscriptionPaypal'])->name('subscription.paypal');
        Route::get('subscription/{id}/paypal/{status}', [PaymentController::class, 'subscriptionPaypalStatus'])->name('subscription.paypal.status');
        Route::post('subscription/{id}/{user_id}/manual-assign-package', [PaymentController::class, 'subscriptionManualAssignPackage'])->name('subscription.manual_assign_package');
        Route::get('subscription/flutterwave/{sid}/{tx_ref}', [PaymentController::class, 'subscriptionFlutterwave'])->name('subscription.flutterwave');
        Route::post('/subscription-pay-with-paystack', [PaymentController::class, 'subscriptionPayWithPaystack'])->name('subscription.pay.with.paystack')->middleware(['auth', 'XSS']);
        Route::get('/subscription/paystack/{pay_id}/{plan_id}', [PaymentController::class, 'getsubscriptionsPaymentStatus'])->name('subscription.paystack');
        Route::post('/subscription-pay-with-razorpay', [PaymentController::class, 'subscriptionPayWithRazorpay'])->name('subscription.pay.with.razorpay')->middleware(['auth', 'XSS']);
        Route::get('/subscription/razorpay/{payment_id}', [PaymentController::class, 'getSubscriptionPaymentStatusRazorpay'])->name('subscription.razorpay');
    }
);

//-------------------------------Notification-------------------------------------------
Route::resource('notification', NotificationController::class)->middleware(
    [
        'auth',
        'XSS',

    ]
);

Route::get('email-verification/{token}', [VerifyEmailController::class, 'verifyEmail'])->name('email-verification')->middleware(
    [
        'XSS',
    ]
);

//-------------------------------FAQ-------------------------------------------
Route::resource('FAQ', FAQController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Home Page-------------------------------------------
Route::resource('homepage', HomePageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
//-------------------------------FAQ-------------------------------------------
Route::resource('pages', PageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Auth page-------------------------------------------
Route::resource('authPage', AuthPageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Customer-------------------------------------------
Route::resource('customer', CustomerController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Expense-------------------------------------------
Route::resource('expense', ExpenseController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Measurement Unit-------------------------------------------
Route::resource('measurement-unit', MeasurementUnitController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
//-------------------------------Tax-------------------------------------------
Route::resource('tax', TaxController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
//-------------------------------Cloth Type-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::delete('cloth-type/measure/destroy', [ClothTypeController::class, 'clothTypeMeasureDestroy'])->name('cloth-type.measure.destroy');
        Route::resource('cloth-type', ClothTypeController::class);
    }
);

//-------------------------------Measurement-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('measurement/type', [MeasurementController::class, 'measurementType'])->name('measurement.type');
        Route::resource('measurement', MeasurementController::class);
    }
);
//-------------------------------Order-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('calendar', [OrderController::class, 'calendar'])->name('calendar');
        Route::get('order/today', [OrderController::class, 'todayOrder'])->name('order.today');
        Route::get('order/today/delivery', [OrderController::class, 'todayDelivery'])->name('order.today.delivery');
        Route::get('customers/measurement', [OrderController::class, 'customerMeasurement'])->name('customer.measurement');
        Route::resource('order', OrderController::class);
        Route::get('order-kanban', [OrderController::class, 'kanban'])->name('order.kanban');
        Route::post('order-status-update', [OrderController::class, 'statusUpdate'])->name('order.status.update');
    }
);
//-------------------------------Invoice-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('invoice/{id}/item/create', [InvoiceController::class, 'invoiceItemCreate'])->name('invoice.item.create');
        Route::post('invoice/{id}/item/store', [InvoiceController::class, 'invoiceItemStore'])->name('invoice.item.store');
        Route::delete('invoice/{iid}/item/{id}/destroy', [InvoiceController::class, 'invoiceItemDestroy'])->name('invoice.item.destroy');
        Route::post('invoice/item/details', [InvoiceController::class, 'getItemDetails'])->name('get.invoice.item.details');

        Route::get('invoice/{id}/payment/create', [InvoiceController::class, 'invoicePaymentCreate'])->name('invoice.payment.create');
        Route::post('invoice/{id}/payment/store', [InvoiceController::class, 'invoicePaymentStore'])->name('invoice.payment.store');
        Route::delete('invoice/{id}/payment/{pid}/destroy', [InvoiceController::class, 'invoicePaymentDestroy'])->name('invoice.payment.destroy');
        Route::post('invoice/{id}/banktransfer/payment', [InvoiceController::class, 'banktransferPayment'])->name('invoice.banktransfer.payment');
        Route::get('invoice-payment-status/{id}/{status}', [InvoiceController::class, 'invoicePaymentStatus'])->name('invoice.bank.transfer.action');
        Route::post('invoice/{id}/stripe/payment', [InvoiceController::class, 'InvoiceStripePayment'])->name('invoice.stripe.payment');
        Route::post('invoice/{id}/paypal', [InvoiceController::class, 'invoicePaypal'])->name('invoice.paypal');
        Route::get('invoice/{id}/paypal/{status}', [InvoiceController::class, 'invoicePaypalStatus'])->name('invoice.paypal.status');
        Route::get('invoice/flutterwave/{id}/{tx_ref}', [InvoiceController::class, 'invoiceFlutterwave'])->name('invoice.flutterwave');
        Route::post('invoice/{id}/paystack/payment', [InvoiceController::class, 'invoicePaystack'])->name('invoice.paystack.payment');
        Route::get('/invoice/paystack/{pay_id}/{i_id}', [InvoiceController::class, 'invoicePaystackStatus'])->name('invoice.paystack');
        Route::get('orders/by-customer', [InvoiceController::class, 'byCustomer'])->name('orders.byCustomer');

        Route::resource('invoice', InvoiceController::class);
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::resource('expense-category', ExpenseCategoryController::class);
        Route::get('subcategory-by-category', [ExpenseController::class, 'getSubcategory'])->name('subcategory.by.category');
        Route::resource('expense-sub-category', ExpenseSubCategoryController::class);
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('order-data', [ReportController::class, 'orderData'])->name('order.data');
        Route::post('generate-order-report', [ReportController::class, 'generateOrderReport'])->name('generate.order.report');
        Route::get('expense-data', [ReportController::class, 'expenseData'])->name('expense.data');
        Route::post('generate-expense-report', [ReportController::class, 'generateExpenseReport'])->name('generate.expense.report');
        Route::get('income-data', [ReportController::class, 'incomeData'])->name('income.data');
        Route::post('generate-income-report', [ReportController::class, 'generateIncomeReport'])->name('generate.income.report');
        Route::get('yearly-profit-loss', [ReportController::class, 'yearlyProfitLoss'])->name('yearly.profit.loss');
        Route::post('generate-profit-loss-report', [ReportController::class, 'generateProfitLossReport'])->name('generate.profit.loss.report');
    }
);

Route::get('page/{slug}', [PageController::class, 'page'])->name('page');

Route::get('download-apk', function () {
    $file = public_path('download/darzidesk.apk');
    if (file_exists($file)) {
        return response()->download($file, 'darzidesk.apk', [
            'Content-Type' => 'application/vnd.android.package-archive',
        ]);
    }
    return abort(404);
})->name('download.apk');

//-------------------------------FAQ-------------------------------------------
Route::impersonate();

