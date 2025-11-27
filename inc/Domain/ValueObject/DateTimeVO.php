<?php
/**
 * Date: 27-11-2025
 */
namespace TravelBooking\Domain\ValueObject;
use DateTimeImmutable;
use DateTimeZone;
use \InvalidArgumentException;
final readonly class DateTimeVO
{
    private const NULL_DATE = '1970-01-01 00:00:00';
    private function __construct(private DateTimeImmutable $value) {}

    /**
     * @param string $dateTime
     * @return self
     * @throws
     */
    public static function fromString(string $dateTime): self
    {
        $dateTime = trim($dateTime);

        if (
            $dateTime === '' ||
            $dateTime === '0000-00-00 00:00:00' ||
            $dateTime === '0000-00-00'
        ) {
            return self::null();
        }

        $formats = [
            'Y-m-d H:i:s', 'Y-m-d H:i', 'Y-m-d',
            'd/m/Y H:i:s', 'd-m-Y H:i:s',
        ];

        foreach ($formats as $format) {
            $date = DateTimeImmutable::createFromFormat($format, $dateTime);
            if ($date !== false && $date->format($format) === $dateTime) {
                $tzName = date_default_timezone_get() ?: 'Asia/Ho_Chi_Minh';
                if (!in_array($tzName, timezone_identifiers_list(), true)) {
                    $tzName = 'Asia/Ho_Chi_Minh';
                }
                return new self($date->setTimezone(new DateTimeZone($tzName)));
            }
        }

        throw new InvalidArgumentException("Cannot parse datetime: '$dateTime'");
    }
    public static function now(): self {return new self(new DateTimeImmutable('now')); }
    public function toDateTimeImmutable(): DateTimeImmutable {
        return $this->value;
    }
    public static function null(): self
    {
        static $nullInstance = null;
        return $nullInstance ??= new self(new DateTimeImmutable(self::NULL_DATE));
    }
    public function isNull(): bool
    {
        return $this->value->format('Y-m-d H:i:s') === self::NULL_DATE;
    }
    public function format(string $format = 'Y-m-d H:i:s'): string
    {
        return $this->value->format($format);
    }
}