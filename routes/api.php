<?php

use App\Http\Controllers\Api\DashboardController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json([
        'success' => true,
        'token' => $user->createToken($request->device_name)->plainTextToken,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => $user->type,
        ]
    ]);
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'device_name' => 'required',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'type' => 'owner',
        'parent_id' => 1,
        'lang' => 'en',
    ]);

    return response()->json([
        'success' => true,
        'token' => $user->createToken($request->device_name)->plainTextToken,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => $user->type,
        ]
    ]);
});

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Email address not found'], 404);
    }

    $token = (string) rand(100000, 999999);
    try {
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );
    } catch (\Throwable $e) {
        // Fallback for newer Laravel schema password_reset_tokens table
        try {
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['token' => Hash::make($token), 'created_at' => now()]
            );
        } catch (\Throwable $e2) {}
    }

    try {
        Mail::to($user->email)->send(new \App\Mail\PasswordResetMail($token, $user));
        $emailSent = true;
    } catch (\Throwable $e) {
        \Log::error('SMTP Mail send failed for ' . $user->email . ': ' . $e->getMessage());
        $emailSent = false;
    }

    return response()->json([
        'success' => true,
        'message' => 'Password reset OTP code sent to ' . $user->email,
        'otp' => $token, // Provided for easy development & mobile testing
        'email_sent' => $emailSent,
    ]);
});

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }

    $resetRecord = DB::table('password_resets')->where('email', $user->email)->first();
    if (!$resetRecord) {
        $resetRecord = DB::table('password_reset_tokens')->where('email', $user->email)->first();
    }

    if (!$resetRecord || !Hash::check($request->otp, $resetRecord->token)) {
        // Fallback check if plain text OTP matched
        if (!$resetRecord || $resetRecord->token !== $request->otp) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP code'], 400);
        }
    }

    $user->password = Hash::make($request->password);
    $user->save();

    try {
        DB::table('password_resets')->where('email', $user->email)->delete();
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
    } catch (\Throwable $e) {}

    return response()->json(['success' => true, 'message' => 'Password reset successfully. You can now log in.']);
});

// Customer Self-Registration
Route::post('/register/customer', [\App\Http\Controllers\Api\CustomerPortalController::class, 'registerCustomer']);

// Public Order Tracking Endpoint (supports UUID tracking token or Order ID)
Route::get('/orders/track/{token}', function ($token) {
    $order = \App\Models\Order::where('tracking_token', $token)
        ->orWhere('order_id', $token)
        ->with(['customers', 'clothTypes', 'productionStage'])
        ->first();

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found with provided tracking code'], 404);
    }

    return response()->json([
        'success' => true,
        'order' => [
            'id' => $order->id,
            'order_id' => $order->order_id,
            'customer_name' => $order->customers->name ?? 'Customer',
            'cloth_type' => $order->clothTypes->title ?? 'Custom Garment',
            'fabric' => $order->febric ?? 'Custom Fabric',
            'status' => $order->status,
            'stage' => $order->productionStage->name ?? 'Pending',
            'order_date' => $order->order_date,
            'deadline' => $order->deadline_date,
            'tracking_token' => $order->tracking_token,
        ],
    ]);
});

// Public Tailor Marketplace Discovery Routes
Route::get('/marketplace/shops', [\App\Http\Controllers\Api\TailorMarketplaceController::class, 'index']);
Route::get('/marketplace/categories', [\App\Http\Controllers\Api\TailorMarketplaceController::class, 'categories']);
Route::get('/marketplace/shops/{id}', [\App\Http\Controllers\Api\TailorMarketplaceController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Authenticated Customer Portal Routes
    Route::get('/customer/dashboard', [\App\Http\Controllers\Api\CustomerPortalController::class, 'dashboard']);
    Route::get('/customer/orders', [\App\Http\Controllers\Api\CustomerPortalController::class, 'myOrders']);
    Route::get('/customer/measurements', [\App\Http\Controllers\Api\CustomerPortalController::class, 'myMeasurements']);
    Route::get('/customer/invoices', [\App\Http\Controllers\Api\CustomerPortalController::class, 'myInvoices']);
    Route::get('/customer/appointments', [\App\Http\Controllers\Api\CustomerPortalController::class, 'myAppointments']);
    Route::post('/customer/appointments', [\App\Http\Controllers\Api\CustomerPortalController::class, 'bookAppointment']);
    Route::post('/customer/orders/request', [\App\Http\Controllers\Api\CustomerPortalController::class, 'requestCustomOrder']);

    // Shop Owner Services & Price List Management
    Route::get('/tailor-services', [\App\Http\Controllers\Api\TailorServiceController::class, 'index']);
    Route::post('/tailor-services', [\App\Http\Controllers\Api\TailorServiceController::class, 'store']);
    Route::put('/tailor-services/{id}', [\App\Http\Controllers\Api\TailorServiceController::class, 'update']);
    Route::delete('/tailor-services/{id}', [\App\Http\Controllers\Api\TailorServiceController::class, 'destroy']);

    // Ratings & Reviews
    Route::post('/shop-reviews', [\App\Http\Controllers\Api\ShopReviewController::class, 'store']);

    // Auth & Profile Routes
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Logged out successfully']);
    });
    Route::get('/profile', function (Request $request) {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'type' => $user->type,
                'profile' => !empty($user->profile) ? asset('/storage/upload/profile/' . $user->profile) : null,
            ]
        ]);
    });
    Route::post('/profile', function (Request $request) {
        $user = $request->user();
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:users,email,' . $user->id]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->phone_number) $user->phone_number = $request->phone_number;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Profile updated successfully', 'data' => $user]);
    });
    Route::post('/change-password', function (Request $request) {
        $request->validate(['current_password' => 'required', 'new_password' => 'required|min:6|confirmed']);
        $user = $request->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Current password is incorrect'], 422);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(['success' => true, 'message' => 'Password changed successfully']);
    });

    // Measurement Routes
    Route::get('/measurements', [\App\Http\Controllers\Api\MeasurementController::class, 'index']);
    Route::get('/measurements/form-data', [\App\Http\Controllers\Api\MeasurementController::class, 'getFormData']);
    Route::post('/measurements', [\App\Http\Controllers\Api\MeasurementController::class, 'store']);
    Route::put('/measurements/{id}', [\App\Http\Controllers\Api\MeasurementController::class, 'update']);
    Route::delete('/measurements/{id}', [\App\Http\Controllers\Api\MeasurementController::class, 'destroy']);

    // Staff Routes
    Route::get('/staff', [\App\Http\Controllers\Api\StaffController::class, 'index']);
    Route::get('/staff/roles', [\App\Http\Controllers\Api\StaffController::class, 'getRoles']);
    Route::post('/staff', [\App\Http\Controllers\Api\StaffController::class, 'store']);
    Route::delete('/staff/{id}', [\App\Http\Controllers\Api\StaffController::class, 'destroy']);

    // Order Routes
    Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);
    Route::get('/orders/statuses', [\App\Http\Controllers\Api\OrderController::class, 'getStatuses']);
    Route::post('/orders', [\App\Http\Controllers\Api\OrderController::class, 'store']);
    Route::get('/orders/{id}', [\App\Http\Controllers\Api\OrderController::class, 'show']);
    Route::put('/orders/{id}', [\App\Http\Controllers\Api\OrderController::class, 'update']);
    Route::delete('/orders/{id}', [\App\Http\Controllers\Api\OrderController::class, 'destroy']);
    Route::patch('/orders/{id}/status', [\App\Http\Controllers\Api\OrderController::class, 'updateStatus']);
    Route::get('/orders/{id}/tag-pdf', [\App\Http\Controllers\Api\OrderController::class, 'downloadGarmentTagPdf']);

    // Expense Routes
    Route::get('/expenses', [\App\Http\Controllers\Api\ExpenseController::class, 'index']);
    Route::get('/expenses/categories', [\App\Http\Controllers\Api\ExpenseController::class, 'getCategories']);
    Route::post('/expenses', [\App\Http\Controllers\Api\ExpenseController::class, 'store']);
    Route::put('/expenses/{id}', [\App\Http\Controllers\Api\ExpenseController::class, 'update']);
    Route::delete('/expenses/{id}', [\App\Http\Controllers\Api\ExpenseController::class, 'destroy']);

    // Invoice Routes
    Route::get('/invoices', [\App\Http\Controllers\Api\InvoiceController::class, 'index']);
    Route::post('/invoices', [\App\Http\Controllers\Api\InvoiceController::class, 'store']);
    Route::get('/invoices/{id}', [\App\Http\Controllers\Api\InvoiceController::class, 'show']);
    Route::put('/invoices/{id}', [\App\Http\Controllers\Api\InvoiceController::class, 'update']);
    Route::delete('/invoices/{id}', [\App\Http\Controllers\Api\InvoiceController::class, 'destroy']);
    Route::get('/invoices/{id}/receipt', [\App\Http\Controllers\Api\InvoiceController::class, 'receipt'])->name('api.receipt');
    
    // Invoice Items & Payments
    Route::post('/invoices/{id}/items', [\App\Http\Controllers\Api\InvoiceController::class, 'invoiceItemStore']);
    Route::delete('/invoices/{invoice_id}/items/{id}', [\App\Http\Controllers\Api\InvoiceController::class, 'invoiceItemDestroy']);
    Route::post('/invoices/{id}/payments', [\App\Http\Controllers\Api\InvoiceController::class, 'invoicePaymentStore']);
    Route::delete('/invoices/{invoice_id}/payments/{id}', [\App\Http\Controllers\Api\InvoiceController::class, 'invoicePaymentDestroy']);

    // Customer Routes
    Route::get('/customers', [\App\Http\Controllers\Api\CustomerController::class, 'index']);
    Route::get('/customers/{id}', [\App\Http\Controllers\Api\CustomerController::class, 'show']);
    Route::post('/customers', [\App\Http\Controllers\Api\CustomerController::class, 'store']);
    Route::put('/customers/{id}', [\App\Http\Controllers\Api\CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [\App\Http\Controllers\Api\CustomerController::class, 'destroy']);

    // Cloth Type Routes
    Route::get('/cloth-types', [\App\Http\Controllers\Api\ClothTypeController::class, 'index']);
    Route::post('/cloth-types', [\App\Http\Controllers\Api\ClothTypeController::class, 'store']);
    Route::put('/cloth-types/{id}', [\App\Http\Controllers\Api\ClothTypeController::class, 'update']);
    Route::delete('/cloth-types/{id}', [\App\Http\Controllers\Api\ClothTypeController::class, 'destroy']);
    
    // Notice Board Routes
    Route::get('/notes', [\App\Http\Controllers\Api\NoticeBoardController::class, 'index']);
    Route::post('/notes', [\App\Http\Controllers\Api\NoticeBoardController::class, 'store']);
    Route::put('/notes/{id}', [\App\Http\Controllers\Api\NoticeBoardController::class, 'update']);
    Route::delete('/notes/{id}', [\App\Http\Controllers\Api\NoticeBoardController::class, 'destroy']);
    
    // Report Routes
    // Reports
    Route::get('/reports/yearly-profit-loss', [\App\Http\Controllers\Api\ReportController::class, 'getYearlyProfitLoss']);
    Route::get('/reports/orders', [\App\Http\Controllers\Api\ReportController::class, 'getOrderReport']);
    Route::get('/reports/income', [\App\Http\Controllers\Api\ReportController::class, 'getIncomeReport']);
    Route::get('/reports/expense', [\App\Http\Controllers\Api\ReportController::class, 'getExpenseReport']);

    // Subscription Routes
    Route::get('/subscriptions', [\App\Http\Controllers\Api\SubscriptionController::class, 'index']);
    Route::get('/subscriptions/razorpay-config', [\App\Http\Controllers\Api\SubscriptionController::class, 'getRazorpayConfig']);
    Route::post('/subscriptions/create-razorpay-order', [\App\Http\Controllers\Api\SubscriptionController::class, 'createRazorpayOrder']);
    Route::post('/subscriptions/verify-razorpay', [\App\Http\Controllers\Api\SubscriptionController::class, 'verifyRazorpayPayment']);
    Route::get('/subscriptions/paypal-config', [\App\Http\Controllers\Api\SubscriptionController::class, 'getPaypalConfig']);
    Route::post('/subscriptions/verify-paypal', [\App\Http\Controllers\Api\SubscriptionController::class, 'verifyPaypalPayment']);
    Route::get('/subscription-transactions', [\App\Http\Controllers\Api\SubscriptionController::class, 'transactions']);
    Route::post('/subscriptions/{id}/activate-mock', [\App\Http\Controllers\Api\SubscriptionController::class, 'activateMock']);

    // User Management Routes
    Route::get('/user-management/roles', [\App\Http\Controllers\Api\UserManagementController::class, 'getRoles']);
    Route::post('/user-management/roles', [\App\Http\Controllers\Api\UserManagementController::class, 'storeRole']);
    Route::put('/user-management/roles/{id}', [\App\Http\Controllers\Api\UserManagementController::class, 'updateRole']);
    Route::delete('/user-management/roles/{id}', [\App\Http\Controllers\Api\UserManagementController::class, 'destroyRole']);
    Route::get('/user-management/logged-history', [\App\Http\Controllers\Api\UserManagementController::class, 'getLoggedHistory']);
    Route::delete('/user-management/logged-history/{id}', [\App\Http\Controllers\Api\UserManagementController::class, 'destroyLoggedHistory']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Production & Kanban Routes
    Route::get('/production/kanban', [\App\Http\Controllers\Api\ProductionController::class, 'kanban']);
    Route::post('/production/stage-update', [\App\Http\Controllers\Api\ProductionController::class, 'updateStage']);
    Route::get('/production/assignments', [\App\Http\Controllers\Api\ProductionController::class, 'assignments']);
    Route::post('/production/assignments/{id}/status', [\App\Http\Controllers\Api\ProductionController::class, 'updateAssignmentStatus']);

    // Materials / Inventory Routes
    Route::get('/materials', [\App\Http\Controllers\Api\MaterialController::class, 'index']);
    Route::post('/materials', [\App\Http\Controllers\Api\MaterialController::class, 'store']);
    Route::post('/materials/{id}/restock', [\App\Http\Controllers\Api\MaterialController::class, 'restock']);

    // Supplier Directory Routes
    Route::get('/suppliers', [\App\Http\Controllers\Api\SupplierController::class, 'index']);
    Route::post('/suppliers', [\App\Http\Controllers\Api\SupplierController::class, 'store']);
    Route::get('/suppliers/{id}', [\App\Http\Controllers\Api\SupplierController::class, 'show']);
    Route::put('/suppliers/{id}', [\App\Http\Controllers\Api\SupplierController::class, 'update']);
    Route::delete('/suppliers/{id}', [\App\Http\Controllers\Api\SupplierController::class, 'destroy']);

    // POS Checkout Route
    Route::post('/pos/store', [\App\Http\Controllers\Api\PosController::class, 'store']);

    // Financial Analytics Route
    Route::get('/financials/analytics', [\App\Http\Controllers\Api\FinancialAnalyticsController::class, 'index']);

    // Measurement History Route
    Route::get('/customers/{id}/measurement-history', function ($id) {
        $histories = \App\Models\MeasurementHistory::where('customer_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($h) {
                return [
                    'id' => $h->id,
                    'field_name' => $h->field_name,
                    'old_value' => $h->old_value,
                    'new_value' => $h->new_value,
                    'changed_at' => $h->created_at->format('Y-m-d H:i'),
                ];
            });
        return response()->json(['success' => true, 'history' => $histories]);
    });

    // Settings Routes
    Route::get('/settings', [\App\Http\Controllers\Api\SettingController::class, 'index']);
    Route::post('/settings', [\App\Http\Controllers\Api\SettingController::class, 'store']);

    // Production Stage Configuration Routes
    Route::get('/production-stages', [\App\Http\Controllers\Api\ProductionStageController::class, 'index']);
    Route::post('/production-stages', [\App\Http\Controllers\Api\ProductionStageController::class, 'store']);
    Route::put('/production-stages/{id}', [\App\Http\Controllers\Api\ProductionStageController::class, 'update']);
    Route::delete('/production-stages/{id}', [\App\Http\Controllers\Api\ProductionStageController::class, 'destroy']);

    // Notification Center Routes
    Route::get('/notifications', [\App\Http\Controllers\Api\NotificationController::class, 'index']);
    Route::post('/notifications/read-all', [\App\Http\Controllers\Api\NotificationController::class, 'markAllAsRead']);
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\Api\NotificationController::class, 'markAsRead']);

    // Expense Categories Routes
    Route::get('/expense-categories', [\App\Http\Controllers\Api\ExpenseCategoryController::class, 'index']);
    Route::post('/expense-categories', [\App\Http\Controllers\Api\ExpenseCategoryController::class, 'store']);
    Route::put('/expense-categories/{id}', [\App\Http\Controllers\Api\ExpenseCategoryController::class, 'update']);
    Route::delete('/expense-categories/{id}', [\App\Http\Controllers\Api\ExpenseCategoryController::class, 'destroy']);

    // Measurement Units Routes
    Route::get('/measurement-units', [\App\Http\Controllers\Api\MeasurementUnitController::class, 'index']);
    Route::post('/measurement-units', [\App\Http\Controllers\Api\MeasurementUnitController::class, 'store']);
    Route::put('/measurement-units/{id}', [\App\Http\Controllers\Api\MeasurementUnitController::class, 'update']);
    Route::delete('/measurement-units/{id}', [\App\Http\Controllers\Api\MeasurementUnitController::class, 'destroy']);

    // Tax Rates Routes
    Route::get('/taxes', [\App\Http\Controllers\Api\TaxController::class, 'index']);
    Route::post('/taxes', [\App\Http\Controllers\Api\TaxController::class, 'store']);
    Route::put('/taxes/{id}', [\App\Http\Controllers\Api\TaxController::class, 'update']);
    Route::delete('/taxes/{id}', [\App\Http\Controllers\Api\TaxController::class, 'destroy']);

    // Support Tickets / Helpdesk Routes
    Route::get('/support-tickets', [\App\Http\Controllers\Api\SupportController::class, 'index']);
    Route::post('/support-tickets', [\App\Http\Controllers\Api\SupportController::class, 'store']);
    Route::get('/support-tickets/{id}', [\App\Http\Controllers\Api\SupportController::class, 'show']);
    Route::post('/support-tickets/{id}/reply', [\App\Http\Controllers\Api\SupportController::class, 'reply']);

    // QR Code & Garment Tag Scanning Routes
    Route::get('/qr/{code}', [\App\Http\Controllers\Api\QrCodeController::class, 'generateSvg']);
    Route::post('/orders/scan', [\App\Http\Controllers\Api\QrCodeController::class, 'scan']);

    // WhatsApp & Twilio SMS Automation Routes
    Route::get('/whatsapp/settings', [\App\Http\Controllers\Api\WhatsAppWebhookController::class, 'getSettings']);
    Route::post('/whatsapp/settings', [\App\Http\Controllers\Api\WhatsAppWebhookController::class, 'updateSettings']);
    Route::post('/whatsapp/send-notification', [\App\Http\Controllers\Api\WhatsAppWebhookController::class, 'sendCustomNotification']);

    // Tailor Ledger & Payout Settlement Routes
    Route::get('/tailor-ledger', [\App\Http\Controllers\Api\TailorLedgerController::class, 'index']);
    Route::post('/tailor-ledger/advance', [\App\Http\Controllers\Api\TailorLedgerController::class, 'recordAdvance']);
    Route::post('/tailor-ledger/settle', [\App\Http\Controllers\Api\TailorLedgerController::class, 'processSettlement']);

    // Fitting & Trial Appointment Routes
    Route::get('/appointments', [\App\Http\Controllers\Api\AppointmentController::class, 'index']);
    Route::post('/appointments', [\App\Http\Controllers\Api\AppointmentController::class, 'store']);
    Route::put('/appointments/{id}/status', [\App\Http\Controllers\Api\AppointmentController::class, 'updateStatus']);

    // Multi-Store Branch Routes
    Route::get('/branches', [\App\Http\Controllers\Api\BranchController::class, 'index']);
    Route::post('/branches', [\App\Http\Controllers\Api\BranchController::class, 'store']);
    Route::post('/branches/switch', [\App\Http\Controllers\Api\BranchController::class, 'switchBranch']);

    // WebSocket / Pusher Broadcast Config & Channel Authentication
    Route::get('/broadcasting/config', function () {
        return response()->json([
            'success' => true,
            'broadcaster' => config('broadcasting.default'),
            'key' => env('PUSHER_APP_KEY', 'darzidesk-key'),
            'cluster' => env('PUSHER_APP_CLUSTER', 'mt1'),
            'host' => env('PUSHER_HOST', 'api-mt1.pusher.com'),
            'port' => (int) env('PUSHER_PORT', 443),
            'scheme' => env('PUSHER_SCHEME', 'https'),
        ]);
    });

    Route::post('/broadcasting/auth', function (\Illuminate\Http\Request $request) {
        return \Illuminate\Support\Facades\Broadcast::auth($request);
    });
});

// Public WhatsApp Webhook Route
Route::post('/webhooks/whatsapp', [\App\Http\Controllers\Api\WhatsAppWebhookController::class, 'handleWebhook']);
