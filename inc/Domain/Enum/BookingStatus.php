<?php

namespace TravelBooking\Domain\Enum;

enum BookingStatus : string
{
    case PENDING   = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
    case UNKNOWN    = 'unknown';

    public  function label(): string
    {
        return match ($this) {
            self::PENDING   => 'Chờ',
            self::CONFIRMED => 'Xác nhận',
            self::CANCELLED => 'Hủy',
            self::UNKNOWN   => 'Chưa rõ'
        };
    }
}