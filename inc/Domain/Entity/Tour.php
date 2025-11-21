<?php

namespace TravelBooking\Domain\Entity;

use \DateTimeImmutable;
use TravelBooking\Config\Enum\TourStatus;

final class Tour
{
    private function __construct(
        public readonly ?int               $id = null,
        public readonly string             $name,
        public readonly string             $tourCode,
        public readonly bool               $tourFeatured,
        public readonly int                $durationDays,
        public readonly int                $durationNights,
        public readonly array              $gallery,
        public readonly array              $tourType,
        public readonly array              $tourLocation,
        public readonly int                $tourRating,
        public readonly string             $featuredImage,
        public readonly DateTimeImmutable  $createdAt,
        public readonly ?DateTimeImmutable  $updatedAt = null,
        private TourStatus                 $status = TourStatus::OPEN,
    )
    {
    }

    // ========== GETTER ==========
    public function id(): ?int {return $this->id;}
    public function name(): string {return $this->name;}
    public function tourCode(): string {return $this->tourCode;}
    public function tourFeatured(): bool {return $this->tourFeatured;}
    public function durationDays(): int {return $this->durationDays;}
    public function durationNights(): int {return $this->durationNights;}
    public function gallery(): array {return $this->gallery;}
    public function tourType(): array {return $this->tourType;}
    public function tourLocation(): array {return $this->tourLocation;}
    public function tourRating(): float {return $this->tourRating;}
    public function featureImage(): string {return $this->featuredImage;}
    public function createAt(): DateTimeImmutable {return $this->createdAt;}

    // Reconstruct
    public static function reconstruct(
        int               $id,
        string            $name,
        string            $tourCode,
        bool              $tourFeatured,
        int               $durationDays,
        int               $durationNights,
        array             $gallery,
        array             $tourType,
        array             $tourLocation,
        float             $tourRating,
        string            $featureImage,
        DateTimeImmutable $createAt
    ): self {
        return new self(
            id: $id,
            name: $name,
            tourCode: $tourCode,
            tourFeatured: $tourFeatured,
            durationDays: $durationDays,
            durationNights: $durationNights,
            gallery: $gallery,
            tourType: $tourType,
            tourLocation: $tourLocation,
            tourRating: $tourRating,
            featuredImage: $featureImage,
            createdAt: $createAt
        );
    }

}