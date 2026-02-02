@extends('layouts.admin')

@section('page-title', 'Tracking Updates')
@section('page-subtitle', "Manage updates for shipment {$shipment->tracking_code}")

@section('admin-content')
<div class="grid grid-cols-3 gap-6 mb-8">
    <!-- Shipment Info Card -->
    <div class="col-span-2 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Shipment Details</h3>
        <div class="space-y-2 text-sm">
            <p><strong>Tracking Code:</strong> <span class="font-mono text-blue-600">{{ $shipment->tracking_code }}</span></p>
            <p><strong>Sender:</strong> {{ $shipment->sender_name }}</p>
            <p><strong>Receiver:</strong> {{ $shipment->receiver_name }}</p>
            <p><strong>Item:</strong> {{ $shipment->item_description }}</p>
            <p><strong>Route:</strong> {{ $shipment->origin }} → {{ $shipment->destination }}</p>
            <p><strong>Expected Delivery:</strong> {{ $shipment->expected_delivery_date->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
        <div class="space-y-2">
            <a href="{{ route('admin.shipments.edit', $shipment) }}" class="block px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-center transition">
                <i class="fas fa-edit mr-2"></i> Edit Details
            </a>
            <a href="{{ route('admin.shipments.index') }}" class="block px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-center transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>
</div>

<!-- Add Tracking Update Form -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Add Tracking Update</h3>
    <form action="{{ route('admin.shipments.updates.store', $shipment) }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <!-- Status Title -->
            <div>
                <label for="status_title" class="block text-sm font-semibold text-gray-700 mb-2">Status Title <span class="text-red-500">*</span></label>
                <input type="text" id="status_title" name="status_title" value="{{ old('status_title') }}" required placeholder="e.g., Arrived at Hub"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_title') border-red-500 @enderror">
                @error('status_title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Location <span class="text-red-500">*</span></label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required placeholder="e.g., Lagos Hub"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('location') border-red-500 @enderror">
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Note -->
        <div>
            <label for="note" class="block text-sm font-semibold text-gray-700 mb-2">Note (Optional)</label>
            <textarea id="note" name="note" rows="2" placeholder="Add any additional notes about this update"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('note') border-red-500 @enderror">{{ old('note') }}</textarea>
            @error('note')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i> Add Update
        </button>
    </form>
</div>

<!-- Timeline of Updates -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-6">Tracking Timeline</h3>
    
    @if ($updates->count() > 0)
        <div class="space-y-6">
            @foreach ($updates as $update)
                <div class="relative pl-8 pb-6 border-l-2 border-blue-500 last:border-l-0">
                    <!-- Timeline dot -->
                    <div class="absolute left-0 top-0 w-4 h-4 bg-blue-500 rounded-full transform -translate-x-2"></div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $update->status_title }}</h4>
                                <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt mr-2"></i>{{ $update->location }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $update->created_at->format('M d, Y \a\t H:i') }}</p>
                                @if ($update->note)
                                    <p class="text-sm text-gray-700 mt-2 italic">{{ $update->note }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-4 block"></i>
            <p class="text-gray-600">No tracking updates yet. Add one to get started!</p>
        </div>
    @endif
</div>
@endsection
