<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingUpdate extends Model
{
    protected $fillable = [
        'shipment_id',
        'status_title',
        'location',
        'note',
    ];

    /**
     * Get the shipment that owns the tracking update
     */
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
