<?php
/**
 * Booking Mapper Class build for Entity Booking can:
 * - Insert data into database form Entity
 * - Reconstruct entity from Database
 * Date: 27-11-2025
 */
namespace TravelBooking\Domain\Mapper;

use TravelBooking\Domain\Entity\Booking;
use DateTimeImmutable;
use TravelBooking\Config\Enum\BookingStatus;

class BookingMapper
{
    public static function fromRow(array $row): Booking
    {
        return Booking::reconstruct(
            id: !empty($row['id']) ? (int) $row['id'] : null,
            code: $row['code'],
            customerId: (int) $row['customer_id'],
            tourName: $row['tour_name'],
            startDate: new DateTimeImmutable($row['start_date']) ?? new DateTimeImmutable(),
            totalPersons: (int) $row['total_persons'],
            note: $row['note'],
            createdAt: new DateTimeImmutable($row['created_at']) ?? new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable($row['updated_at']) ?? new DateTimeImmutable(),
            status: BookingStatus::tryFrom($row['status']) ?? BookingStatus::CONFIRMED,
        );
    }

    public static function toRow(Booking $booking): array
    {
        return [
            'id' => $booking->id ?? null,
            'code' => $booking->code,
            'customer_id' => $booking->customer_id ?? null,
            'tour_name' => $booking->tourName ?? null,
            'start_date' => $booking->start_date ?? null,
            'total_persons' => $booking->total_persons ?? null,
            'note' => $booking->note ?? null,
            'created_at' => $booking->created_at ?? null,
            'updated_at' => $booking->updated_at ?? null,
            'status' => $booking->status
        ];
    }

}