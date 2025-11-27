<?php

namespace TravelBooking\Domain\ValueObject;

use http\Exception\InvalidArgumentException;

final readonly class MoneyVO
{
    private const DEFAULT_CURRENCY = 'VND';
    private const MINOR_UNIT = 100;
    public function __construct(
        private int    $amount,
        private string $currency = self::DEFAULT_CURRENCY,
    ){
        if ($amount < 0) {
            throw new InvalidArgumentException('Amount must be greater than 0');
        }
    }

    public static function vnd(int|float|string $value): self
    {
        $value = self::normalizeInput($value);
        return new self((int)round($value * self::MINOR_UNIT));
    }

    // ==================== Hiển thị ====================
    public function format(): string
    {
        $formatted = number_format($this->amount / self::MINOR_UNIT, 0, ',', '.');
        return $formatted . ' ' .  $this->currency;
    }

    // ==================== Private helper ====================
    private static function normalizeInput(int|float|string $value): float
    {
        if (is_numeric($value)) {
            return (float)$value;
        }

        // Xử lý chuỗi có dấu chấm/phẩy: 1.250.000 hoặc 1,250,000
        $clean = preg_replace('/[^0-9.,]/', '', (string)$value);
        $clean = str_replace(',', '.', $clean);
        $parts = explode('.', $clean);
        if (count($parts) > 2) {
            throw new InvalidArgumentException("Invalid money format: {$value}");
        }
        return (float)$clean;
    }

}