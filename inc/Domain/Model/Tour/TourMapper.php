<?php
/**
 * Date: 27-11-2025
 */

namespace TravelBooking\Domain\Model\Tour;

use TravelBooking\Domain\Enum\BookingStatus;
use TravelBooking\Domain\Enum\TourStatus;
use TravelBooking\Domain\ValueObject\DateTimeVO;

final class TourMapper
{
    public static function toRow(Tour $tour): array
    {
        return [
            'id' => $tour->id,
            'name' => $tour->name,
            'tour_code' => $tour->tourCode,
            'is_featured' => $tour->isFeatured,
            'duration' => $tour->durationSlug,
            'is_linked' => $tour->linkedSlug,
            'gallery' => $tour->gallery,
            'kind' => $tour->typeSlug,
            'personal_range' => $tour->personRangeSlug,
            'locations' => $tour->locationSlugs,
            'rating' => $tour->ratingSlug,
            'featured_image' => $tour->featuredImage,
            'created_at' => $tour->createdAt ?? DateTimeVO::null()->format('Y-m-d H:i:s'),
            'updated_at' => $tour->updatedAt ?? DateTimeVO::null()->format('Y-m-d H:i:s'),
            'status' => $tour->status ?? BookingStatus::UNKNOWN->value,
        ];
    }
}