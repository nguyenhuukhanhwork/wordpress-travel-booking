<?php

namespace TravelBooking\Domain\Entity;

use DateTimeImmutable;
use TravelBooking\Config\Enum\BookingStatus;

final class Booking
{
    private function __construct(
        public readonly ?int               $id = null,
        public readonly ?string            $code = null,
        public readonly string             $customerId,
        public readonly string             $tourName,
        public readonly DateTimeImmutable  $startDate,
        public readonly int                $totalPersons,
        public readonly ?string            $note,
        public readonly DateTimeImmutable  $createAt,
        public readonly ?DateTimeImmutable $updateAt = null,
        public BookingStatus               $status = BookingStatus::PENDING
    )
    {
    }

    public static function create(
        int               $customerId,
        string            $tourName,
        DateTimeImmutable $startDate,
        int               $adults,
        int               $children,
        ?string           $note = null,
    ): self
    {
        return new self(
            id: null,
            code: null,
            customerId: $customerId,
            tourName: $tourName,
            startDate: $startDate,
            totalPersons: $adults + $children,
            note: $note,
            createAt: new DateTimeImmutable(),
            updateAt: new DateTimeImmutable(),
            status: BookingStatus::PENDING
        );
    }



    // Factory ĐẶC BIỆT để reconstruct từ DB (bỏ qua validation)
    public static function reconstruct(
        ?int                $id,
        ?string             $code,
        int                 $customerId,
        string              $tourName,
        DateTimeImmutable   $startDate,
        int                 $totalPersons,
        ?string             $note,
        DateTimeImmutable   $createdAt,
        ?DateTimeImmutable  $updatedAt,
        BookingStatus       $status,
    ): self {
        $instance = new self(
            id:           $id,
            code:         $code,
            customerId:   $customerId,
            tourName:     $tourName,
            startDate:    $startDate,
            totalPersons: $totalPersons,
            note:         $note,
            createAt:    $createdAt,
            updateAt:    $updatedAt,
        );
        $instance->status = $status; // Reflection hoặc private setter nếu cần
        return $instance;
    }

    /**
     * Behavior
     */
    private function changeStatus(BookingStatus $status): void
    {
        $this->status = $status;
    }

}