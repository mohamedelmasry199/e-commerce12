<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutSession extends Model
{
    protected $fillable = [
        'user_id',
        'idempotency_key',
        'order_id',
        'status',
        'cart_snapshot',
        'expires_at',
    ];

    protected $casts = [
        'cart_snapshot' => 'array',
        'expires_at'    => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ── Helpers ──────────────────────────────────────────────────────

    /**
     * Is this session still valid (not expired and still pending)?
     */
    public function isValid(): bool
    {
        return $this->status === 'pending'
            && $this->expires_at->isFuture();
    }

    /**
     * Does this session already have an order created?
     */
    public function hasOrder(): bool
    {
        return $this->order_id !== null;
    }

    // ── Scopes ───────────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }
}
