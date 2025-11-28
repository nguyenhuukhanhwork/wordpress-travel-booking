<?php
/**
 * Notification <-> Database mapper
 *
 * @package   TravelBooking\Domain\Mapper
 * @author    KhanhECB
 * @since     1.0.0
 * @version   1.0.0
 *
 * @internal  Only Repository should use this class
 *             Part of Clean Architecture / DDD implementation
 */

namespace TravelBooking\Domain\Model\Notification;

use DateTimeImmutable;
use TravelBooking\Domain\Enum\NotificationStatus;

final class NotificationMapper
{
      /**
     * To array for insert to database
     * @param Notification $notification
     * @return array
     */
    public static function toRow(Notification $notification): array
    {
        return [
            'id' => $notification->id,
            'kind' => $notification->kind,
            'message' => $notification->message,
            'status' => $notification->status->value,
            'error' => $notification->error,
            'sent_date' => $notification->sentDate?->format('Y-m-d H:i:s'),
            'created_date' => $notification->createdDate ?? (new DateTimeImmutable())->format('Y-m-d H:i:s')
        ];
    }
}