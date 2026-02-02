@extends('layouts.app')

@section('title', 'Admin Dashboard - Shipment Tracker')

@section('content')
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white shadow-lg">
        <div class="p-6 border-b border-gray-800">
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-box"></i> Shipment Tracker
            </h1>
        </div>

        <nav class="mt-6 px-4">
            <a href="{{ route('admin.shipments.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.shipments*') ? 'bg-blue-600' : 'hover:bg-gray-800' }} transition">
                <i class="fas fa-list mr-2"></i> All Shipments
            </a>
            <a href="{{ route('admin.shipments.create') }}" class="block px-4 py-3 rounded-lg mt-2 hover:bg-gray-800 transition">
                <i class="fas fa-plus mr-2"></i> Create Shipment
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-600 transition flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <div class="p-8">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                <p class="text-gray-600 mt-2">@yield('page-subtitle', 'Manage your shipments and tracking updates')</p>
            </div>

            <!-- Alerts -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <strong class="block mb-2"><i class="fas fa-exclamation-circle mr-2"></i> Please correct the following errors:</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center justify-between">
                    <span><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</span>
                    <button onclick="this.parentElement.style.display='none';" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @yield('admin-content')
        </div>
    </div>
</div>
@endsection
