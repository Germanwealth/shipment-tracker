@extends('layouts.app')

@section('title', 'Admin Login - Shipment Tracker')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-block bg-blue-600 text-white p-4 rounded-full mb-4">
                <i class="fas fa-lock text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">Admin Portal</h1>
            <p class="text-gray-400 mt-2">Shipment Tracker Management</p>
        </div>

        <!-- Login Form -->
        <div class="bg-gray-800 rounded-lg shadow-2xl p-8 border border-gray-700">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-900 border border-red-700 text-red-200 rounded-lg">
                    <strong class="block mb-2"><i class="fas fa-exclamation-circle mr-2"></i> Login Failed</strong>
                    <p class="text-sm">{{ $errors->first('email') ?? 'Invalid credentials. Please try again.' }}</p>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        placeholder="admin@example.com"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                    >
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember"
                        class="w-4 h-4 bg-gray-700 border border-gray-600 rounded focus:ring-2 focus:ring-blue-500"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-400">Remember me</label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition mt-8"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center gap-4">
                <div class="flex-1 h-px bg-gray-700"></div>
                <span class="text-gray-500 text-sm">or</span>
                <div class="flex-1 h-px bg-gray-700"></div>
            </div>

            <!-- Demo Credentials -->
            <div class="bg-gray-700 rounded-lg p-4 text-center text-sm text-gray-300">
                <p class="font-semibold mb-2">Demo Credentials</p>
                <p>Email: <span class="font-mono text-xs">admin@example.com</span></p>
                <p>Password: <span class="font-mono text-xs">password123</span></p>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('tracking.index') }}" class="text-gray-400 hover:text-white transition flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Tracking
            </a>
        </div>
    </div>
</div>
@endsection
