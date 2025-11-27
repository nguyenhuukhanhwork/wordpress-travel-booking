<?php
/**
 * @date 27-11-2025
 * @since 1.0.0
 */

namespace TravelBooking\Domain\Mapper;
use TravelBooking\Domain\Entity\Tour;
use TravelBooking\Config\Enum\TourStatus;
use DateTimeImmutable;
final class TourMapper
{
    public static function fromRow(array $row): Tour
    {
        return Tour::reconstruct(
            id: !empty($row['id']) ? (int) $row['id'] : null,
            name: $row['name'],
            tourCode: $row['tour_code'],
            isFeatured: (bool) $row['is_featured'],
            durationSlug: $row['duration_slug'],
            linkedSlug: $row['linked_slug'],
            gallery: $row['gallery'],
            typeSlug: $row['type_slug'],
            personRangeSlug: $row['person_range_slug'],
            locationSlugs: $row['location_slugs'],
            ratingSlug: $row['rating_slug'],
            featuredImage: $row['featured_image'],
            createdAt: new DateTimeImmutable($row['created_at']) ?? new \DateTimeImmutable(),
            updatedAt: new DateTimeImmutable($row['updated_at']) ?? new \DateTimeImmutable(),
            status: TourStatus::tryFrom($row['status']) ?? TourStatus::OPEN,
        );
    }
}