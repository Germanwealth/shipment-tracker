<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\View\View;

class PublicTrackingController extends Controller
{
    /**
     * Show the public tracking page
     */
    public function index(): View
    {
        return view('tracking.index');
    }

    /**
     * Search for a shipment by tracking code
     */
    public function search(string $trackingCode): View
    {
        $shipment = Shipment::where('tracking_code', strtoupper($trackingCode))->first();

        if (!$shipment) {
            return view('tracking.not-found', ['trackingCode' => $trackingCode]);
        }

        $updates = $shipment->trackingUpdates;

        return view('tracking.result', compact('shipment', 'updates'));
    }
}
