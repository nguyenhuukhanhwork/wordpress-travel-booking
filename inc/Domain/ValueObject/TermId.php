<?php

namespace TravelBooking\Domain\ValueObject;

final readonly class TermId
{
    public function __construct(public int $value)
    {
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}