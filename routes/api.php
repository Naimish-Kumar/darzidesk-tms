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
    
    // Measurement Routes
    Route::get('/measurements', [\App\Http\Controllers\Api\MeasurementController::class, 'index']);
    Route::get('/measurements/form-data', [\App\Http\Controllers\Api\MeasurementController::class, 'getFormData']);
    Route::post('/measurements', [\App\Http\Controllers\Api\MeasurementController::class, 'store']);

    // Staff Routes
    Route::get('/staff', [\App\Http\Controllers\Api\StaffController::class, 'index']);
    Route::get('/staff/roles', [\App\Http\Controllers\Api\StaffController::class, 'getRoles']);
    Route::post('/staff', [\App\Http\Controllers\Api\StaffController::class, 'store']);
    Route::delete('/staff/{id}', [\App\Http\Controllers\Api\StaffController::class, 'destroy']);

    // Order Routes
    Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);
    Route::get('/orders/statuses', [\App\Http\Controllers\Api\OrderController::class, 'getStatuses']);
    Route::get('/orders/{id}', [\App\Http\Controllers\Api\OrderController::class, 'show']);
    Route::patch('/orders/{id}/status', [\App\Http\Controllers\Api\OrderController::class, 'updateStatus']);

    // Expense Routes
    Route::get('/expenses', [\App\Http\Controllers\Api\ExpenseController::class, 'index']);
    Route::get('/expenses/categories', [\App\Http\Controllers\Api\ExpenseController::class, 'getCategories']);
    Route::post('/expenses', [\App\Http\Controllers\Api\ExpenseController::class, 'store']);

    // Invoice Routes
    Route::get('/invoices', [\App\Http\Controllers\Api\InvoiceController::class, 'index']);
    Route::get('/invoices/{id}', [\App\Http\Controllers\Api\InvoiceController::class, 'show']);
    Route::get('/invoices/{id}/receipt', [\App\Http\Controllers\Api\InvoiceController::class, 'receipt'])->name('api.receipt');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
