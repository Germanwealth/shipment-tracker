<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    protected $fillable = [
        'tracking_code',
        'sender_name',
        'receiver_name',
        'item_description',
        'origin',
        'destination',
        'current_status',
        'expected_delivery_date',
    ];

    protected $casts = [
        'expected_delivery_date' => 'date',
    ];

    /**
     * Get the tracking updates for the shipment
     */
    public function trackingUpdates(): HasMany
    {
        return $this->hasMany(TrackingUpdate::class)->orderBy('created_at', 'desc');
    }

    /**
     * Generate a unique tracking code
     */
    public static function generateTrackingCode(): string
    {
        do {
            $code = 'TRK-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        } while (self::where('tracking_code', $code)->exists());

        return $code;
    }
}
