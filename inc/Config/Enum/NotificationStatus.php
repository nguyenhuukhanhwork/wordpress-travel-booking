<?php

namespace TravelBooking\Config\Enum;

use MyCLabs\Enum\Enum;

Enum NotificationStatus: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case PENDING = 'pending';

    public function label(): string
    {
        return match($this) {
            self::SUCCESS => 'Thành công',
            self::ERROR   => 'Lỗi',
            self::PENDING => 'Đang chờ',
        };
    }
}