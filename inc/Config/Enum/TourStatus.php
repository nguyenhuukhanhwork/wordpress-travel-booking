<?php

namespace TravelBooking\Config\Enum;

enum TourStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case FULL = 'full';

    public function label(): string
    {
        return match($this) {
            self::OPEN   => 'Mở đặt tour',
            self::CLOSED => 'Đã đóng',
            self::FULL   => 'Đầy chỗ',
        };
    }
}
