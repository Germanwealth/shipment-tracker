<?php

namespace Database\Seeders;

use App\Models\Shipment;
use App\Models\TrackingUpdate;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample shipments
        $shipment1 = Shipment::create([
            'tracking_code' => Shipment::generateTrackingCode(),
            'sender_name' => 'Tech Store Lagos',
            'receiver_name' => 'John Doe',
            'item_description' => 'Samsung Galaxy A50 Smartphone',
            'origin' => 'Lagos Warehouse',
            'destination' => 'Abuja',
            'current_status' => 'Delivered',
            'expected_delivery_date' => Carbon::now()->addDays(7),
        ]);

        // Add tracking updates for shipment 1
        TrackingUpdate::create([
            'shipment_id' => $shipment1->id,
            'status_title' => 'Order Received',
            'location' => 'Lagos Warehouse',
            'note' => 'Your order has been received and is being processed.',
        ]);

        TrackingUpdate::create([
            'shipment_id' => $shipment1->id,
            'status_title' => 'In Transit',
            'location' => 'Lagos - Ibadan Route',
            'note' => 'Package is on its way to the destination.',
        ]);

        TrackingUpdate::create([
            'shipment_id' => $shipment1->id,
            'status_title' => 'Delivered',
            'location' => 'Abuja',
            'note' => 'Package has been delivered successfully.',
        ]);

        // Create second sample shipment
        $shipment2 = Shipment::create([
            'tracking_code' => Shipment::generateTrackingCode(),
            'sender_name' => 'Fashion Boutique Nigeria',
            'receiver_name' => 'Jane Smith',
            'item_description' => 'Cotton Ankara Dress Collection',
            'origin' => 'Lagos',
            'destination' => 'Port Harcourt',
            'current_status' => 'In Transit',
            'expected_delivery_date' => Carbon::now()->addDays(5),
        ]);

        // Add tracking updates for shipment 2
        TrackingUpdate::create([
            'shipment_id' => $shipment2->id,
            'status_title' => 'Order Placed',
            'location' => 'Lagos',
            'note' => 'Order placed successfully.',
        ]);

        TrackingUpdate::create([
            'shipment_id' => $shipment2->id,
            'status_title' => 'Picked Up',
            'location' => 'Lagos Hub',
            'note' => 'Package picked up from warehouse.',
        ]);

        TrackingUpdate::create([
            'shipment_id' => $shipment2->id,
            'status_title' => 'In Transit',
            'location' => 'Port Harcourt Route',
            'note' => 'On the way to destination.',
        ]);
    }
}
