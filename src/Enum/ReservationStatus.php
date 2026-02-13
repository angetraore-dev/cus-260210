<?php

namespace App\Enum;

enum ReservationStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';

    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function getBadgeColor(): string
    {
        return match($this) {
            self::PENDING => 'warning',   // Orange
            self::CONFIRMED => 'success', // Vert
            self::CANCELLED => 'danger',  // Rouge
        };
    }
}
