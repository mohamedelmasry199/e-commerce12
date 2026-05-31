<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryReservation extends Model
{
    protected $fillable = [
        'order_id',
        'variant_id',
        'quantity',
        'expires_at',
        'released_at',
    ];

    protected $casts = [
        'expires_at'  => 'datetime',
        'released_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isReleased(): bool
    {
        return $this->released_at !== null;
    }

    public function scopeUnreleased($query)
    {
        return $query->whereNull('released_at');
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }
}
