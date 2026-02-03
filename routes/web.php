<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminShipmentController;
use App\Http\Controllers\PublicTrackingController;

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'app_env' => config('app.env'),
        'app_debug' => config('app.debug'),
        'database' => 'connected',
    ]);
});

// Public tracking routes
Route::get('/', [PublicTrackingController::class, 'index'])->name('tracking.home');
Route::get('/track', [PublicTrackingController::class, 'index'])->name('tracking.index');
Route::get('/track/{code}', [PublicTrackingController::class, 'search'])->name('tracking.search');

// Admin login GET
Route::get('/admin/login', function () {
    error_log("Login page requested");
    return view('auth.login');
})->name('admin.login');

// Admin login POST
Route::post('/admin/login', function (Request $request) {
    error_log("Login POST handler called");
    try {
        error_log("Login POST started");
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        error_log("Credentials validated");
        
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            error_log("Auth attempt successful");
            $request->session()->regenerate();
            return redirect()->intended(route('admin.shipments.index'));
        }
        
        error_log("Auth attempt failed");
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    } catch (\Exception $e) {
        error_log("Login exception: " . $e->getMessage());
        error_log("Exception trace: " . $e->getTraceAsString());
        return back()->withErrors([
            'email' => 'An error occurred: ' . $e->getMessage(),
        ]);
    }
})->name('admin.login.post');

// Admin routes (protected by auth middleware)
Route::middleware('auth:admin')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Shipment management
        Route::resource('shipments', AdminShipmentController::class);

        // Tracking updates
        Route::get('shipments/{shipment}/updates', [AdminShipmentController::class, 'showUpdates'])->name('shipments.updates');
        Route::post('shipments/{shipment}/updates', [AdminShipmentController::class, 'storeUpdate'])->name('shipments.updates.store');
    });
});
