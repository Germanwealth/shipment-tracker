@extends('layouts.app')

@section('title', 'Admin Dashboard - Shipment Tracker')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Mobile Overlay -->
    <div id="admin-overlay" class="fixed inset-0 bg-black/40 hidden z-40 md:hidden"></div>

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white shadow-lg transform -translate-x-full transition-transform duration-200 ease-out z-50 md:translate-x-0 md:static md:inset-auto">
        <div class="p-6 border-b border-gray-800">
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-box"></i> Shipment Tracker
            </h1>
        </div>

        <nav class="mt-6 px-4 pb-6">
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
    </aside>

    <!-- Main Content -->
    <div class="flex-1 w-full">
        <!-- Mobile Header -->
        <div class="md:hidden sticky top-0 z-30 bg-white border-b border-gray-200">
            <div class="px-4 py-3 flex items-center justify-between">
                <button id="admin-menu-toggle" type="button" class="text-gray-700" aria-label="Open menu" aria-expanded="false" aria-controls="admin-sidebar">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="font-semibold text-gray-900">Shipment Tracker</div>
                <div class="w-6"></div>
            </div>
        </div>

        <div class="p-4 sm:p-6 lg:p-8">
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

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('admin-menu-toggle');
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('admin-overlay');
        if (!toggle || !sidebar || !overlay) return;

        const openMenu = () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            toggle.setAttribute('aria-expanded', 'true');
        };

        const closeMenu = () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', () => {
            if (sidebar.classList.contains('-translate-x-full')) {
                openMenu();
            } else {
                closeMenu();
            }
        });

        overlay.addEventListener('click', closeMenu);

        sidebar.querySelectorAll('a, button').forEach((el) => {
            el.addEventListener('click', () => {
                if (window.innerWidth < 768) closeMenu();
            });
        });
    });
</script>
@endsection
