<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING    = 'pending';
    case PAID       = 'paid';
    case CANCELLED  = 'cancelled';
    case DELIVERED  = 'delivered';

    public function label(): string
    {
        return match($this) {
            self::PENDING   => __('orders.status.pending'),
            self::PAID      => __('orders.status.paid'),
            self::CANCELLED => __('orders.status.cancelled'),
            self::DELIVERED => __('orders.status.delivered'),
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING   => 'warning',
            self::PAID      => 'success',
            self::CANCELLED => 'danger',
            self::DELIVERED => 'info',
        };
    }
}
