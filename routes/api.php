<?php

use App\Http\Controllers\Api\DashboardController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

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
    Route::post('/subscriptions/verify-razorpay', [\App\Http\Controllers\Api\SubscriptionController::class, 'verifyRazorpayPayment']);
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
});
