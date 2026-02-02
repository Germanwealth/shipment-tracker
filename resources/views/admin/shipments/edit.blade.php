@extends('layouts.admin')

@section('page-title', 'Edit Shipment')
@section('page-subtitle', 'Update shipment details')

@section('admin-content')
<div class="max-w-2xl bg-white rounded-lg shadow-md p-8">
    <div class="mb-6 pb-4 border-b">
        <p class="text-gray-600"><strong>Tracking Code:</strong> <span class="font-mono text-lg text-blue-600">{{ $shipment->tracking_code }}</span></p>
        <p class="text-gray-600 text-sm mt-2">Created: {{ $shipment->created_at->format('M d, Y H:i') }}</p>
    </div>

    <form action="{{ route('admin.shipments.update', $shipment) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-6">
            <!-- Sender Name -->
            <div>
                <label for="sender_name" class="block text-sm font-semibold text-gray-700 mb-2">Sender Name <span class="text-red-500">*</span></label>
                <input type="text" id="sender_name" name="sender_name" value="{{ old('sender_name', $shipment->sender_name) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sender_name') border-red-500 @enderror">
                @error('sender_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Receiver Name -->
            <div>
                <label for="receiver_name" class="block text-sm font-semibold text-gray-700 mb-2">Receiver Name <span class="text-red-500">*</span></label>
                <input type="text" id="receiver_name" name="receiver_name" value="{{ old('receiver_name', $shipment->receiver_name) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('receiver_name') border-red-500 @enderror">
                @error('receiver_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Item Description -->
        <div>
            <label for="item_description" class="block text-sm font-semibold text-gray-700 mb-2">Item Description <span class="text-red-500">*</span></label>
            <textarea id="item_description" name="item_description" rows="3" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('item_description') border-red-500 @enderror">{{ old('item_description', $shipment->item_description) }}</textarea>
            @error('item_description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <!-- Origin -->
            <div>
                <label for="origin" class="block text-sm font-semibold text-gray-700 mb-2">Origin <span class="text-red-500">*</span></label>
                <input type="text" id="origin" name="origin" value="{{ old('origin', $shipment->origin) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('origin') border-red-500 @enderror">
                @error('origin')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Destination -->
            <div>
                <label for="destination" class="block text-sm font-semibold text-gray-700 mb-2">Destination <span class="text-red-500">*</span></label>
                <input type="text" id="destination" name="destination" value="{{ old('destination', $shipment->destination) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('destination') border-red-500 @enderror">
                @error('destination')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <!-- Current Status -->
            <div>
                <label for="current_status" class="block text-sm font-semibold text-gray-700 mb-2">Current Status <span class="text-red-500">*</span></label>
                <select id="current_status" name="current_status" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('current_status') border-red-500 @enderror">
                    <option value="">Select Status</option>
                    <option value="Pending" {{ old('current_status', $shipment->current_status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Processing" {{ old('current_status', $shipment->current_status) === 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="In Transit" {{ old('current_status', $shipment->current_status) === 'In Transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="Out for Delivery" {{ old('current_status', $shipment->current_status) === 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="Delivered" {{ old('current_status', $shipment->current_status) === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
                @error('current_status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Expected Delivery Date -->
            <div>
                <label for="expected_delivery_date" class="block text-sm font-semibold text-gray-700 mb-2">Expected Delivery Date <span class="text-red-500">*</span></label>
                <input type="date" id="expected_delivery_date" name="expected_delivery_date" value="{{ old('expected_delivery_date', $shipment->expected_delivery_date->format('Y-m-d')) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('expected_delivery_date') border-red-500 @enderror">
                @error('expected_delivery_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-4 pt-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                <i class="fas fa-save mr-2"></i> Update Shipment
            </button>
            <a href="{{ route('admin.shipments.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded-lg transition text-center">
                <i class="fas fa-times mr-2"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
