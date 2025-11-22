<?php

namespace TravelBooking\Domain\Mapper;

use DateTimeImmutable;
use TravelBooking\Config\Enum\NotificationStatus;
use TravelBooking\Domain\Entity\Notification;

final class NotificationMapper
{
    public static function fromRow(array $row): Notification
    {
        return Notification::reconstitute(
            id: isset($row['id']) ? (int) $row['id'] : null,
            kind: $row['kind'],
            message: $row['message'],
            status: NotificationStatus::from($row['status']),
            error: $row['error'] ?? null,
            sentDate: isset($row['sent_date']) ? new DateTimeImmutable($row['sent_date']) : null,
            createdDate: isset($row['created_date']) ? new DateTimeImmutable($row['created_date']) : new DateTimeImmutable(),
        );
    }

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
            'status' => $notification->status,
            'error' => $notification->error,
            'sent_date' => $notification->sentDate,
            'created_date' => $notification->createdDate ?? (new DateTimeImmutable())->format('Y-m-d H:i:s')
        ];
    }
}