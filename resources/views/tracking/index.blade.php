@extends('layouts.public')

@section('title', 'Track Your Shipment - Nuelcargo Logistics')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Back to home -->
            <a href="/" class="text-blue-600 hover:text-blue-800 mb-6 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
            </a>
            
            <!-- Main tracking card -->
            <div class="bg-white rounded-lg shadow-2xl p-10">
                <div class="text-center mb-8">
                    <div class="inline-block bg-blue-100 rounded-full p-4 mb-4">
                        <i class="fas fa-box text-4xl text-blue-600"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Track Your Shipment</h1>
                    <p class="text-gray-600 text-lg">Enter your tracking code to monitor your delivery in real-time</p>
                </div>
                
                <form action="/track" method="GET" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Tracking Code</label>
                        <input 
                            type="text" 
                            name="code" 
                            placeholder="e.g., TRK-ABC123DEF456"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition text-lg"
                            required
                        >
                        <p class="text-sm text-gray-500 mt-2">Your tracking code is shown on your shipment confirmation email</p>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold transition text-lg">
                        <i class="fas fa-search mr-2"></i>Track Now
                    </button>
                </form>
                
                <!-- Info boxes -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-10 pt-10 border-t border-gray-200">
                    <div class="text-center">
                        <i class="fas fa-clock text-3xl text-orange-500 mb-2"></i>
                        <h3 class="font-bold text-gray-800 mb-1">Real-Time Updates</h3>
                        <p class="text-sm text-gray-600">Get instant status updates on your delivery</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-map text-3xl text-orange-500 mb-2"></i>
                        <h3 class="font-bold text-gray-800 mb-1">Track Location</h3>
                        <p class="text-sm text-gray-600">See exactly where your package is</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-mobile-alt text-3xl text-orange-500 mb-2"></i>
                        <h3 class="font-bold text-gray-800 mb-1">Mobile Ready</h3>
                        <p class="text-sm text-gray-600">Access from any device, anywhere</p>
                    </div>
                </div>
                
                <!-- Example codes -->
                <div class="mt-10 p-6 bg-blue-50 rounded-lg">
                    <h3 class="font-bold text-gray-800 mb-3 text-lg">
                        <i class="fas fa-lightbulb text-orange-500 mr-2"></i>Need Help?
                    </h3>
                    <p class="text-sm text-gray-700 mb-3">Example tracking codes:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @php
                        $examples = ['TRK-ABC123DEF456', 'TRK-XYZ789UVW012', 'TRK-DEMO001', 'TRK-TEST002'];
                        @endphp
                        @foreach($examples as $code)
                        <div class="bg-white p-3 rounded border border-blue-200 cursor-pointer hover:border-blue-400 transition" onclick="document.querySelector('input[name=code]').value='{{ $code }}'; document.querySelector('form').submit();">
                            <code class="font-mono text-blue-600">{{ $code }}</code>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Contact support -->
                <div class="mt-10 text-center">
                    <p class="text-gray-600">Can't find your tracking code? 
                        <a href="mailto:support@nuellogistics.com" class="text-blue-600 hover:text-blue-800 font-bold">Contact our support team</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
