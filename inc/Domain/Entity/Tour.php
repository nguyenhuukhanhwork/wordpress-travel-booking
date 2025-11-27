<?php

namespace TravelBooking\Domain\Entity;

use DateTimeImmutable;
use TravelBooking\Config\Enum\TaxonomyName;
use TravelBooking\Config\Enum\TourStatus;
use TravelBooking\Domain\Service\TourTaxonomyReader;

final readonly class  Tour
{
    private function __construct(
        public ?int               $id = null,
        public string             $name,
        public string             $tourCode,
        public bool               $isFeatured,
        public string             $durationSlug,        // 3n2d, 5n4d, 7n6d...
        public ?string            $linkedSlug = null,   // co / khong / null
        public array              $gallery,
        public string             $typeSlug,            // noi-dia, quoc-te, teambuilding...
        public string             $personRangeSlug,     // 2-4, 5-9, 10-15...
        public array              $locationSlugs,       // ['ha-noi', 'da-nang', 'phu-quoc']
        public string             $ratingSlug,          // 5-sao, rat-tot, tot...
        public string             $featuredImage,
        public DateTimeImmutable  $createdAt,
        public ?DateTimeImmutable $updatedAt = null,
        private TourStatus        $status = TourStatus::OPEN,
    ) {}

    // ==================== GETTER ====================

    public function id(): ?int                  { return $this->id; }
    public function name(): string              { return $this->name; }
    public function tourCode(): string          { return $this->tourCode; }
    public function isFeatured(): bool          { return $this->isFeatured; }
    public function gallery(): array                { return $this->gallery; }
    public function featuredImage(): string         { return $this->featuredImage; }
    public function createdAt(): DateTimeImmutable  { return $this->createdAt; }
    public function updatedAt(): ?DateTimeImmutable     { return $this->updatedAt; }
    public function status(): TourStatus        { return $this->status; }

    // Slug thô
    public function durationSlug(): string      { return $this->durationSlug; }
    public function linkedSlug(): ?string       { return $this->linkedSlug; }
    public function typeSlug(): string          { return $this->typeSlug; }
    public function personRangeSlug(): string   { return $this->personRangeSlug; }
    public function locationSlugs(): array      { return $this->locationSlugs; }
    public function ratingSlug(): string        { return $this->ratingSlug; }

    // ==================== Behavior ====================

    public function durationLabel(TourTaxonomyReader $reader): ?string
    {
        $taxonomy = TaxonomyName::TOUR_DURATION->value;
        return $reader->getName($taxonomy, $this->durationSlug);
    }

    public function linkedLabel(TourTaxonomyReader $reader): ?string
    {
        $taxonomy = TaxonomyName::TOUR_LINKED->value;
        return $this->linkedSlug ? $reader->getName($taxonomy, $this->linkedSlug) : null;
    }

    public function typeLabel(TourTaxonomyReader $reader): ?string
    {
        $taxonomy = TaxonomyName::TOUR_TYPE->value;
        return $reader->getName($taxonomy, $this->typeSlug);
    }

    public function personRangeLabel(TourTaxonomyReader $reader): ?string
    {
        $taxonomy = TaxonomyName::TOUR_PERSON->value;
        return $reader->getName($taxonomy, $this->personRangeSlug);
    }

    /** @return string[] ví dụ: ['Hà Nội', 'Đà Nẵng', 'Sapa'] */
    public function locationLabels(TourTaxonomyReader $reader): array
    {
        $taxonomy = TaxonomyName::TOUR_LOCATION->value;
        return array_values(array_filter(
            array_map(fn($slug) => $reader->getName($taxonomy, $slug), $this->locationSlugs)
        ));
    }

    public function ratingLabel(TourTaxonomyReader $reader): ?string
    {
        $taxonomy = TaxonomyName::TOUR_RATING->value;
        return $reader->getName($taxonomy, $this->ratingSlug);
    }

    // ==================== RECONSTRUCT (Repository dùng) ====================

    public static function reconstruct(
        ?int                $id,
        string              $name,
        string              $tourCode,
        bool                $isFeatured,
        string              $durationSlug,
        ?string             $linkedSlug,
        array               $gallery,
        string              $typeSlug,
        string              $personRangeSlug,
        array               $locationSlugs,
        string              $ratingSlug,
        string              $featuredImage,
        DateTimeImmutable   $createdAt,
        ?DateTimeImmutable  $updatedAt = null,
        TourStatus          $status = TourStatus::OPEN,
    ): self {
        return new self(
            id:              $id,
            name:            $name,
            tourCode:        $tourCode,
            isFeatured:      $isFeatured,
            durationSlug:    $durationSlug,
            linkedSlug:      $linkedSlug,
            gallery:         $gallery,
            typeSlug:        $typeSlug,
            personRangeSlug: $personRangeSlug,
            locationSlugs:   $locationSlugs,
            ratingSlug:      $ratingSlug,
            featuredImage:   $featuredImage,
            createdAt:       $createdAt,
            updatedAt:       $updatedAt,
            status:          $status,
        );
    }
}