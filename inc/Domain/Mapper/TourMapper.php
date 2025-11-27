<?php
/**
 * Date: 27-11-2025
 */

namespace TravelBooking\Domain\Mapper;

use TravelBooking\Domain\Entity\Tour;
use TravelBooking\Config\Enum\TourStatus;
use TravelBooking\Domain\ValueObject\DateTimeVO;

final class TourMapper
{
    public static function fromRow(array $row): Tour
    {
        return Tour::reconstruct(
            id:              !empty($row['id']) ? (int)$row['id'] : null,
            name:            $row['name'] ?? '',
            tourCode:        $row['tour_code'] ?? '',
            isFeatured:      !empty($row['is_featured']),
            durationSlug:    $row['duration_slug'] ?? '',
            linkedSlug:      $row['linked_slug'] ?? null,
            gallery:         $row['gallery'] ?? [],
            typeSlug:        $row['type_slug'] ?? '',
            personRangeSlug: $row['person_range_slug'] ?? '',
            locationSlugs:   $row['location_slugs'] ?? [],
            ratingSlug:      $row['rating_slug'] ?? '',
            featuredImage:   $row['featured_image'] ?? '',
            createdAt:       DateTimeVO::fromString($row['created_at'] ?? ''),
            updatedAt:       DateTimeVO::fromString($row['updated_at'] ?? ''),
            status:          TourStatus::tryFrom($row['status'] ?? '') ?? TourStatus::OPEN,
        );
    }
}