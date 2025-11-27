<?php

namespace TravelBooking\Config\Enum;

use MyCLabs\Enum\Enum;

ENUM CustomerSource: string
{
    case WEBSITE        = 'website';
    case FACEBOOK       = 'facebook';
    case ZALO           = 'zalo';
    case TIKTOK         = 'tiktok';
    case GOOGLE         = 'google';
    case PARTNER        = 'partner';
    case RETURNING      = 'returning';
    case WALK_IN        = 'walk_in';

    public function label(): string
    {
        return match($this) {
            self::WEBSITE   => 'Website',
            self::FACEBOOK  => 'Facebook',
            self::ZALO      => 'Zalo',
            self::TIKTOK    => 'Tiktok',
            self::GOOGLE    => 'Google',
            self::PARTNER   => 'Đại lý giới thiệu',
            self::RETURNING => 'Khách trở lại',
            self::WALK_IN   => 'Khách đến trực tiếp',
        };
    }
}