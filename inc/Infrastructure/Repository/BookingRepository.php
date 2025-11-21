<?php

namespace TravelBooking\Infrastructure\Repository;

use DateTimeImmutable;
use RuntimeException;
use TravelBooking\Config\Enum\BookingStatus;
use TravelBooking\Domain\Entity\Booking;
use TravelBooking\Infrastructure\Database\BookingTable;

// class thực sự biết insert/update

final class BookingRepository
{
    public function __construct(
        private readonly BookingTable $table
    )
    {
    }

    /** DB → Entity */
    public function toEntity(array $data): Booking
    {
        $id = isset($data['booking_id']) ? (int)$data['booking_id'] : null;
        $booking_code = $data['booking_code'] ?? null;
        $customer_id = (int)$data['customer_id'];
        $tour_name = $data['tour_name'];
        $start_date = new DateTimeImmutable($data['start_date']);
        $tour_person = (int)$data['total_persons'];
        $note = $data['note'];
        $create_at = new DateTimeImmutable($data['create_at']);
        $update_at = isset($data['updated_at']) ? new DateTimeImmutable($data['updated_at']) : null;
        $booking_status = BookingStatus::tryFrom($data['booking_status']) ?? BookingStatus::PENDING;

        return Booking::reconstruct(
            id: $id,
            code: $booking_code,
            customerId: $customer_id,
            tourName: $tour_name,
            startDate: $start_date,
            totalPersons: $tour_person,
            note: $note,
            createdAt: $create_at,
            updatedAt: $update_at,
            status: $booking_status
        );
    }

    /** Entity → DB array (đúng tên cột thật) */
    private function toDatabaseArray(Booking $booking): array
    {
        return [
            'booking_id' => $booking->id(),
            'booking_code' => $booking->code() ?? wp_generate_uuid4(),
            'customer_id' => $booking->customerId(),
            'tour_name' => $booking->tourName(),
            'start_date' => $booking->startDate()->format('Y-m-d'),
            'total_person' => $booking->totalPersons(),
            'note' => $booking->note(),
            'created_at' => $booking->createdAt()->format('Y-m-d H:i:s'),
            'updated_at' => $booking->updateAt()?->format('Y-m-d H:i:s'),
            'booking_status' => $booking->status()->value,
        ];
    }

    // Các method thực sự dùng để lưu
    public function add(Booking $booking): int
    {
        $data = $this->toDatabaseArray($booking);
        $id = $this->table->insertBaseRow($data);
        if (!$id) {
            throw new RuntimeException('Failed to insert booking');
        }
        return $id;
    }

    public function update(int $id, Booking $booking): void
    {
        $data = $this->toDatabaseArray($booking);
        $this->table->updateRow($id, $data);
    }

}