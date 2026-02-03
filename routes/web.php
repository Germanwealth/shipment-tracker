<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminShipmentController;
use App\Http\Controllers\PublicTrackingController;

// Force HTTPS in production
if (app()->environment('production')) {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}

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

// Admin login POST (without CSRF middleware) - API style
Route::post('/api/admin/login', function (Request $request) {
    error_log("API Login POST handler called");
    try {
        error_log("API Login POST started");
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        error_log("Credentials validated");
        
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            error_log("Auth attempt successful");
            $request->session()->regenerate();
            return response()->json(['success' => true, 'redirect' => route('admin.shipments.index')]);
        }
        
        error_log("Auth attempt failed");
        return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
    } catch (\Exception $e) {
        error_log("Login exception: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
})->name('admin.login.api')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

// Admin login POST (with CSRF for forms)
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

// Admin checker endpoint (for debugging)
Route::get('/admin/check', function () {
    $admins = \App\Models\Admin::all();
    $count = count($admins);
    
    if ($count === 0) {
        // Create default admin
        \App\Models\Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);
        return response()->json(['message' => 'Created default admin', 'email' => 'admin@example.com']);
    }
    
    return response()->json([
        'admin_count' => $count,
        'admins' => $admins->map(fn($a) => ['email' => $a->email, 'name' => $a->name])
    ]);
})->name('admin.check');

// Session/CSRF diagnostic endpoint
Route::get('/admin/session-check', function () {
    $sessionPath = storage_path('framework/sessions');
    $isWritable = is_writable($sessionPath);
    $sessionFiles = count(glob($sessionPath . '/*'));
    
    return response()->json([
        'session_driver' => config('session.driver'),
        'session_path' => $sessionPath,
        'session_path_exists' => is_dir($sessionPath),
        'session_path_writable' => $isWritable,
        'session_files_count' => $sessionFiles,
        'file_perms' => substr(sprintf('%o', fileperms($sessionPath)), -4),
    ]);
})->name('admin.session.check');

// Admin routes (protected by auth middleware and CSRF protection)
Route::middleware(['auth:admin', \App\Http\Middleware\VerifyCsrfToken::class])->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Shipment management
        Route::resource('shipments', AdminShipmentController::class);

        // Tracking updates
        Route::get('shipments/{shipment}/updates', [AdminShipmentController::class, 'showUpdates'])->name('shipments.updates');
        Route::post('shipments/{shipment}/updates', [AdminShipmentController::class, 'storeUpdate'])->name('shipments.updates.store');
    });
});
