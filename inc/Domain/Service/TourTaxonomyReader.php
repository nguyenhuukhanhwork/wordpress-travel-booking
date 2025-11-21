<?php

namespace TravelBooking\Domain\Service;

interface TourTaxonomyReader
{
    public function exists(string $taxonomy, ?string $slug): bool;

    public function getName(string $taxonomy, ?string $slug): ?string;

    public function all(string $taxonomy, ?string $slug): array;
}