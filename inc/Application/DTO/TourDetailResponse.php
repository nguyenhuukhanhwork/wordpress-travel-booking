<?php

namespace TravelBooking\Application\DTO;

use TravelBooking\Domain\Service\TourTaxonomyReader;

final class TourDetailResponse
{
    public function __construct(private Tour $tour)
    {
    }

    public function toArray(TourTaxonomyReader $reader): array
    {
        return [
            'id' => $this->tour->getId(),
            'name' => $this->tour->getName(),

        ];
    }
}