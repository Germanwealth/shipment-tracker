@extends('layouts.admin')

@section('page-title', 'All Shipments')
@section('page-subtitle', 'Manage and track all shipments')

@section('admin-content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('admin.shipments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Create New Shipment
    </a>
</div>

<!-- Shipments Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    @if ($shipments->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tracking Code</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Sender</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Receiver</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Expected Delivery</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($shipments as $shipment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-mono text-sm font-bold text-blue-600">
                                {{ $shipment->tracking_code }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $shipment->sender_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $shipment->receiver_name }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-white text-xs font-semibold 
                                    @if ($shipment->current_status === 'Delivered')
                                        bg-green-500
                                    @elseif ($shipment->current_status === 'In Transit')
                                        bg-blue-500
                                    @else
                                        bg-yellow-500
                                    @endif
                                ">
                                    {{ $shipment->current_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $shipment->expected_delivery_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.shipments.edit', $shipment) }}" class="inline-block px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition text-xs font-semibold">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <a href="{{ route('admin.shipments.updates', $shipment) }}" class="inline-block px-3 py-1 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition text-xs font-semibold">
                                    <i class="fas fa-history mr-1"></i> Updates
                                </a>
                                <form action="{{ route('admin.shipments.destroy', $shipment) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this shipment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg transition text-xs font-semibold">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $shipments->links() }}
        </div>
    @else
        <div class="p-8 text-center">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4 block"></i>
            <p class="text-gray-600 text-lg mb-4">No shipments yet.</p>
            <a href="{{ route('admin.shipments.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                Create Your First Shipment
            </a>
        </div>
    @endif
</div>
@endsection
