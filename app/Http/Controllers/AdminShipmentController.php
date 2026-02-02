<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\TrackingUpdate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminShipmentController extends Controller
{
    /**

     * Display dashboard with all shipments
     */
    public function index(): View
    {
        $shipments = Shipment::latest()->paginate(10);
        return view('admin.dashboard', compact('shipments'));
    }

    /**
     * Show create shipment form
     */
    public function create(): View
    {
        return view('admin.shipments.create');
    }

    /**
     * Store a newly created shipment
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'receiver_name' => 'required|string|max:255',
            'item_description' => 'required|string|max:1000',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'current_status' => 'required|string|max:255',
            'expected_delivery_date' => 'required|date|after:today',
        ]);

        $validated['tracking_code'] = Shipment::generateTrackingCode();

        Shipment::create($validated);

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Shipment created successfully!');
    }

    /**
     * Show edit shipment form
     */
    public function edit(Shipment $shipment): View
    {
        return view('admin.shipments.edit', compact('shipment'));
    }

    /**
     * Update the specified shipment
     */
    public function update(Request $request, Shipment $shipment): RedirectResponse
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'receiver_name' => 'required|string|max:255',
            'item_description' => 'required|string|max:1000',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'current_status' => 'required|string|max:255',
            'expected_delivery_date' => 'required|date',
        ]);

        $shipment->update($validated);

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Shipment updated successfully!');
    }

    /**
     * Delete the specified shipment
     */
    public function destroy(Shipment $shipment): RedirectResponse
    {
        $shipment->trackingUpdates()->delete();
        $shipment->delete();

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Shipment deleted successfully!');
    }

    /**
     * Show tracking updates for a shipment
     */
    public function showUpdates(Shipment $shipment): View
    {
        $updates = $shipment->trackingUpdates;
        return view('admin.shipments.updates', compact('shipment', 'updates'));
    }

    /**
     * Store a new tracking update
     */
    public function storeUpdate(Request $request, Shipment $shipment): RedirectResponse
    {
        $validated = $request->validate([
            'status_title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
        ]);

        $shipment->trackingUpdates()->create($validated);

        return redirect()->route('admin.shipments.updates', $shipment)
            ->with('success', 'Tracking update added successfully!');
    }
}
