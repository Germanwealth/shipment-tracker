@extends('layouts.app')

@section('title', 'Tracking Result')

@section('content')
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
