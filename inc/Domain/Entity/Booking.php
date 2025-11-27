<?php

namespace TravelBooking\Domain\Entity;

use DateTimeImmutable;
use TravelBooking\Config\Enum\BookingStatus;
use TravelBooking\Domain\ValueObject\DateTimeValue;

#[Entity]
final readonly class Booking
{
    private function __construct(
        public ?int           $id = null,
        public ?string        $code = null,
        public string         $customerId,
        public string         $tourName,
        public DateTimeValue  $startDate,
        public int            $totalPersons,
        public ?string        $note,
        public DateTimeValue  $createdAt,
        public ?DateTimeValue $updatedAt = null,
        public BookingStatus  $status = BookingStatus::PENDING
    )
    {
    }

    public static function create(
        int           $customerId,
        string        $tourName,
        DateTimeValue $startDate,
        int           $adults,
        int           $children,
        ?string       $note = null,
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
            createdAt: DateTimeValue::now(),
            updatedAt: DateTimeValue::now(),
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
        return new self(
            id:           $id,
            code:         $code,
            customerId:   $customerId,
            tourName:     $tourName,
            startDate:    $startDate,
            totalPersons: $totalPersons,
            note:         $note,
            createdAt:    $createdAt,
            updatedAt:    $updatedAt,
            status:       $status
        );
    }

    /**
     * Behavior
     */

    /**
     * Change Booking Status
     * @param BookingStatus $status
     * @return self
     */
    public function changeStatus(BookingStatus $status): self
    {
        return new self(
            id: $this->id,
            code: $this->code,
            customerId: $this->customerId,
            tourName: $this->tourName,
            startDate: $this->startDate,
            totalPersons: $this->totalPersons,
            note: $this->note,
            createdAt: $this->createdAt,
            updatedAt: $this->updatedAt,
            status: $status
        );
    }
}