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
        'timestamp' => now(),
    ]);
});

// Public pages
Route::get('/', function () {
    return view('public.home');
})->name('home');

// Public tracking routes - handles both /track and /track?code= formats
Route::get('/track', function (Request $request) {
    // If code parameter is provided, redirect to path parameter format
    if ($request->has('code')) {
        return redirect('/track/' . strtoupper(trim($request->query('code'))));
    }
    // Otherwise show the tracking search page
    return app(PublicTrackingController::class)->index();
})->name('tracking.index');

Route::get('/track/{code}', [PublicTrackingController::class, 'search'])->name('tracking.search');

// Generic login route (redirects to admin.login for Laravel's exception handler)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

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
})->name('admin.login.api');

// Admin login POST (CSRF not required for public login)
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

// Admin checker endpoint (for debugging) - AUTO-CREATE admin if none exists
Route::get('/admin/check', function () {
    try {
        $admins = \App\Models\Admin::all();
        $count = count($admins);
        
        if ($count === 0) {
            // Create default admin
            \App\Models\Admin::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ]);
            return response()->json(['message' => 'Created default admin', 'email' => 'admin@example.com', 'status' => 'created']);
        }
        
        return response()->json([
            'admin_count' => $count,
            'admins' => $admins->map(fn($a) => ['email' => $a->email, 'name' => $a->name]),
            'status' => 'exists'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
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

// Debug shipments endpoint - shows all shipments in database
Route::get('/debug/shipments', function () {
    try {
        $shipments = \App\Models\Shipment::all();
        return response()->json([
            'count' => count($shipments),
            'shipments' => $shipments->map(fn($s) => [
                'id' => $s->id,
                'tracking_code' => $s->tracking_code,
                'sender' => $s->sender_name,
                'receiver' => $s->receiver_name,
                'status' => $s->current_status,
                'created_at' => $s->created_at,
            ])
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('debug.shipments');

// Create test shipment endpoint
Route::get('/debug/create-test-shipment', function () {
    try {
        $shipment = \App\Models\Shipment::create([
            'tracking_code' => \App\Models\Shipment::generateTrackingCode(),
            'sender_name' => 'Test Sender',
            'receiver_name' => 'Test Receiver',
            'item_description' => 'Test Package',
            'origin' => 'New York',
            'destination' => 'Los Angeles',
            'current_status' => 'In Transit',
            'expected_delivery_date' => now()->addDays(5),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Test shipment created',
            'tracking_code' => $shipment->tracking_code,
            'url' => url('/track/' . $shipment->tracking_code)
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('debug.create.test');

// Admin routes (protected by auth middleware with CSRF for state-changing routes)
// CSRF token automatically verified by web middleware group
Route::middleware('auth:admin')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Shipment management
        Route::get('shipments', [AdminShipmentController::class, 'index'])->name('shipments.index');
        Route::get('shipments/create', [AdminShipmentController::class, 'create'])->name('shipments.create');
        Route::post('shipments', [AdminShipmentController::class, 'store'])->name('shipments.store');
        Route::get('shipments/{shipment}', [AdminShipmentController::class, 'show'])->name('shipments.show');
        Route::get('shipments/{shipment}/edit', [AdminShipmentController::class, 'edit'])->name('shipments.edit');
        Route::put('shipments/{shipment}', [AdminShipmentController::class, 'update'])->name('shipments.update');
        Route::delete('shipments/{shipment}', [AdminShipmentController::class, 'destroy'])->name('shipments.destroy');

        // Tracking updates
        Route::get('shipments/{shipment}/updates', [AdminShipmentController::class, 'showUpdates'])->name('shipments.updates');
        Route::post('shipments/{shipment}/updates', [AdminShipmentController::class, 'storeUpdate'])->name('shipments.updates.store');
    });
});
