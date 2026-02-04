@extends('layouts.public')

@section('title', 'Tracking Result - Nuelcargo')

@section('content')
<style>
    .route-map {
        background: radial-gradient(120% 120% at 10% 10%, #0f172a 0%, #0b1220 55%, #070b14 100%);
    }
    .route-map::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(148, 163, 184, 0.12) 1px, transparent 1px),
            linear-gradient(90deg, rgba(148, 163, 184, 0.12) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }
    .route-haze {
        background: radial-gradient(circle at 70% 30%, rgba(56, 189, 248, 0.25), transparent 55%),
            radial-gradient(circle at 30% 70%, rgba(59, 130, 246, 0.2), transparent 50%);
    }
    .route-path {
        stroke-dasharray: 8 10;
        animation: route-dash 16s linear infinite;
    }
    .route-pulse {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background: #22c55e;
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        animation: route-pulse 2s infinite;
    }
    .route-endpoint {
        animation: endpoint-pulse 2.5s ease-in-out infinite;
        transform-origin: center;
    }
    .route-dot {
        filter: drop-shadow(0 0 6px rgba(56, 189, 248, 0.8));
    }
    @keyframes route-dash {
        to { stroke-dashoffset: -180; }
    }
    @keyframes route-pulse {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { box-shadow: 0 0 0 12px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    @keyframes endpoint-pulse {
        0%, 100% { transform: scale(1); opacity: 0.85; }
        50% { transform: scale(1.15); opacity: 1; }
    }
</style>

<div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('tracking.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-4">
                <i class="fas fa-arrow-left"></i> Search Again
            </a>
            <h1 class="text-4xl font-bold text-gray-900">Your Shipment</h1>
        </div>

        <!-- Shipment Details Card -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <!-- Tracking Code -->
            <div class="mb-6 pb-6 border-b">
                <p class="text-sm text-gray-600 mb-1">Tracking Code</p>
                <p class="text-3xl font-mono font-bold text-blue-600">{{ $shipment->tracking_code }}</p>
            </div>

            <!-- Status Badge -->
            <div class="mb-6 pb-6 border-b">
                <p class="text-sm text-gray-600 mb-2">Current Status</p>
                <div class="flex items-center gap-3">
                    <span class="px-4 py-2 rounded-full text-white font-semibold text-lg
                        @if ($shipment->current_status === 'Delivered')
                            bg-green-500
                        @elseif ($shipment->current_status === 'In Transit')
                            bg-blue-500
                        @elseif ($shipment->current_status === 'Out for Delivery')
                            bg-purple-500
                        @else
                            bg-yellow-500
                        @endif
                    ">
                        {{ $shipment->current_status }}
                    </span>
                </div>
            </div>

            <!-- Shipment Info Grid -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Sender</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $shipment->sender_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Receiver</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $shipment->receiver_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Origin</p>
                    <p class="text-gray-900"><i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>{{ $shipment->origin }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Destination</p>
                    <p class="text-gray-900"><i class="fas fa-map-marker-alt text-green-500 mr-2"></i>{{ $shipment->destination }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Item Description</p>
                    <p class="text-gray-900">{{ $shipment->item_description }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Expected Delivery</p>
                    <p class="text-gray-900 font-semibold">{{ $shipment->expected_delivery_date->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Live Route Map -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Live Route</h2>
                    <p class="text-sm text-gray-500">Auto-updating visual path based on your shipment activity</p>
                </div>
                <div class="inline-flex items-center gap-2 text-sm text-green-600 font-semibold">
                    <span class="route-pulse"></span>
                    Tracking active
                </div>
            </div>

            <div class="route-map route-haze relative overflow-hidden rounded-2xl border border-slate-800">
                <div class="absolute inset-0 opacity-80"></div>
                <svg viewBox="0 0 900 300" class="w-full h-64 md:h-72 relative z-10" aria-hidden="true">
                    <defs>
                        <linearGradient id="routeLine" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#38bdf8" />
                            <stop offset="100%" stop-color="#6366f1" />
                        </linearGradient>
                        <filter id="routeGlow">
                            <feGaussianBlur stdDeviation="4" result="blur" />
                            <feMerge>
                                <feMergeNode in="blur" />
                                <feMergeNode in="SourceGraphic" />
                            </feMerge>
                        </filter>
                        <path id="routeCurve" d="M100 230 C 260 120, 380 110, 520 160 S 760 240, 820 90" />
                    </defs>
                    <path d="M100 230 C 260 120, 380 110, 520 160 S 760 240, 820 90" stroke="url(#routeLine)" stroke-width="4" fill="none" class="route-path" filter="url(#routeGlow)" />
                    <circle cx="100" cy="230" r="8" fill="#22c55e" class="route-endpoint" />
                    <circle cx="820" cy="90" r="8" fill="#f97316" class="route-endpoint" />
                    <circle r="6" fill="#38bdf8" class="route-dot">
                        <animateMotion dur="9s" repeatCount="indefinite" path="M100 230 C 260 120, 380 110, 520 160 S 760 240, 820 90" />
                    </circle>
                </svg>

                <div class="absolute left-6 bottom-5 bg-white/90 backdrop-blur px-4 py-2 rounded-lg border border-white/60 shadow-sm text-xs text-slate-700">
                    <div class="font-semibold text-slate-900">Origin</div>
                    <div>{{ $shipment->origin }}</div>
                </div>
                <div class="absolute right-6 top-5 bg-white/90 backdrop-blur px-4 py-2 rounded-lg border border-white/60 shadow-sm text-xs text-slate-700 text-right">
                    <div class="font-semibold text-slate-900">Destination</div>
                    <div>{{ $shipment->destination }}</div>
                </div>

                @if ($updates->count() > 0)
                    <div class="absolute left-1/2 -translate-x-1/2 bottom-4 bg-slate-900/80 text-slate-100 text-xs px-4 py-2 rounded-full border border-slate-700">
                        Latest scan: {{ $updates->first()->location }} · {{ $updates->first()->created_at->format('M d, Y \a\t H:i') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Tracking Timeline</h2>

            @if ($updates->count() > 0)
                <div class="space-y-6">
                    @foreach ($updates as $index => $update)
                        <div class="relative">
                            <!-- Timeline Line -->
                            @if ($index !== $updates->count() - 1)
                                <div class="absolute left-5 top-12 w-0.5 h-12 bg-blue-200"></div>
                            @endif

                            <!-- Timeline Item -->
                            <div class="flex gap-6">
                                <!-- Timeline Dot -->
                                <div class="relative flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full 
                                        @if ($index === 0)
                                            bg-blue-600
                                        @else
                                            bg-gray-300
                                        @endif
                                        flex items-center justify-center text-white flex-shrink-0">
                                        @if ($index === 0)
                                            <i class="fas fa-check"></i>
                                        @else
                                            <i class="fas fa-circle text-xs"></i>
                                        @endif
                                    </div>
                                </div>

                                <!-- Timeline Content -->
                                <div class="pb-6">
                                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 
                                        @if ($index === 0)
                                            border-blue-600
                                        @else
                                            border-gray-300
                                        @endif
                                    ">
                                        <h3 class="font-bold text-lg text-gray-900">
                                            {{ $update->status_title }}
                                        </h3>
                                        <p class="text-gray-600 mt-1">
                                            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                            {{ $update->location }}
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            <i class="fas fa-clock mr-2"></i>
                                            {{ $update->created_at->format('M d, Y \a\t H:i') }}
                                        </p>
                                        @if ($update->note)
                                            <p class="text-gray-700 mt-3 italic">
                                                <i class="fas fa-quote-left mr-2 text-gray-400"></i>
                                                {{ $update->note }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4 block"></i>
                    <p class="text-gray-600 text-lg">No tracking updates yet. Check back soon!</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center">
            <a href="{{ route('tracking.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                <i class="fas fa-search mr-2"></i> Track Another Shipment
            </a>
        </div>
    </div>
</div>
@endsection
