@extends('layouts.app')

@section('title', 'Track Your Shipment')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo / Title -->
        <div class="text-center mb-12">
            <div class="inline-block bg-blue-600 text-white p-4 rounded-full mb-4">
                <i class="fas fa-box text-4xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900">Shipment Tracker</h1>
            <p class="text-gray-600 mt-2">Track your packages in real-time</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-xl p-8">
            <form method="GET" onsubmit="handleSearch(event)" class="space-y-4">
                <div>
                    <label for="tracking_code" class="block text-sm font-semibold text-gray-700 mb-2">Enter Tracking Code</label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="tracking_code" 
                            name="tracking_code"
                            placeholder="e.g., TRK-8F3A9C2D" 
                            required
                            maxlength="20"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition font-mono text-lg"
                        >
                        <button type="submit" class="absolute right-0 top-0 h-full px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-r-lg transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <p class="text-xs text-gray-500 text-center">Your tracking code is displayed on your shipment label</p>
            </form>

            <!-- Info Box -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i> How to Track
                    </h3>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>✓ Find your tracking code on the shipment label</li>
                        <li>✓ Enter it in the search box above</li>
                        <li>✓ View live updates of your package</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-600 text-sm">Need help? <a href="#" class="text-blue-600 hover:underline">Contact Support</a></p>
            <p class="text-gray-500 text-xs mt-4"><a href="{{ route('admin.login') }}" class="hover:text-blue-600">Admin Login</a></p>
        </div>
    </div>
</div>

<script>
function handleSearch(e) {
    e.preventDefault();
    const code = document.getElementById('tracking_code').value.trim().toUpperCase();
    if (code) {
        window.location.href = `/track/${code}`;
    }
}
</script>
@endsection
