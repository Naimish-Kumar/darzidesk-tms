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
    Route::get('/orders/{id}', [\App\Http\Controllers\Api\OrderController::class, 'show']);
    Route::patch('/orders/{id}/status', [\App\Http\Controllers\Api\OrderController::class, 'updateStatus']);

    // Expense Routes
    Route::get('/expenses', [\App\Http\Controllers\Api\ExpenseController::class, 'index']);
    Route::get('/expenses/categories', [\App\Http\Controllers\Api\ExpenseController::class, 'getCategories']);
    Route::post('/expenses', [\App\Http\Controllers\Api\ExpenseController::class, 'store']);
    Route::put('/expenses/{id}', [\App\Http\Controllers\Api\ExpenseController::class, 'update']);
    Route::delete('/expenses/{id}', [\App\Http\Controllers\Api\ExpenseController::class, 'destroy']);

    // Invoice Routes
    Route::get('/invoices', [\App\Http\Controllers\Api\InvoiceController::class, 'index']);
    Route::get('/invoices/{id}', [\App\Http\Controllers\Api\InvoiceController::class, 'show']);
    Route::get('/invoices/{id}/receipt', [\App\Http\Controllers\Api\InvoiceController::class, 'receipt'])->name('api.receipt');

    // Customer Routes
    Route::get('/customers', [\App\Http\Controllers\Api\CustomerController::class, 'index']);
    Route::post('/customers', [\App\Http\Controllers\Api\CustomerController::class, 'store']);
    Route::put('/customers/{id}', [\App\Http\Controllers\Api\CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [\App\Http\Controllers\Api\CustomerController::class, 'destroy']);

    // Cloth Type Routes
    Route::get('/cloth-types', [\App\Http\Controllers\Api\ClothTypeController::class, 'index']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
