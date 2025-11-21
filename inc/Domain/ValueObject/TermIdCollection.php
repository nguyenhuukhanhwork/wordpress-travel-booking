<?php

namespace TravelBooking\Domain\ValueObject;

final class TermIdCollection
{
    private array $items = [];

    private function __construct(TermID ...$items) {
        $this->items = $items;
    }

    /** @param array<int> $termIds */
    public static function fromWordPress(array $termIds): self
    {
        $items = array_map(fn(int $id) => new TermId($id), $termIds);
        return new self(...$items);
    }

    public static function from(TermId ...$items): self
    {
        return new self(...$items);
    }

    public static function empty(): self
    {
        return new self();
    }

    public function contains(TermId $id): bool
    {
        foreach ($this->items as $item) {
            if ($item->equals($id)) return true;
        }
        return false;
    }

    public function count(): int { return count($this->items); }
    public function isEmpty(): bool { return $this->items === []; }


}