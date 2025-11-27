<?php
/**
 * Notification – Domain Entity (Aggregate Root)
 *
 * Represents a notification (Telegram, Email, SMS, etc.)
 * This entity is 100% immutable and persistence-ignorant.
 *
 * @package   TravelBooking\Domain\Entity
 * @author    Nguyễn Văn A <you@example.com>
 * @since     1.0.0 Introduced
 * @version   1.1.0 Added readonly class + factory methods
 *
 * @immutable This entity cannot be modified – only replaced with new instance
 * @internal  Use Notification::create() or Notification::reconstitute() only
 */

namespace TravelBooking\Domain\Entity;
use DateTimeImmutable;
use TravelBooking\Config\Enum\NotificationStatus;

final readonly class Notification
{
    private function __construct(
        public ?int               $id,
        public string             $kind,
        public string             $message,
        public NotificationStatus $status,
        public ?string            $error,
        public ?DateTimeImmutable $sentDate,
        public ?DateTimeImmutable $createdDate
    )
    {
    }

    // --- Factory

    /**
     * Factory method to create new Notification
     *
     * @param string $kind
     * @param string $message
     * @param NotificationStatus $status
     * @return self
     */
    public static function create(
        string $kind,
        string $message,
        NotificationStatus $status,
    ): self {
        return new self(
            id: null,
            kind: $kind,
            message: $message,
            status: $status,
            error: null,
            sentDate: null,
            createdDate: null
        );
    }

    /**
     * Factory method for Mapper database -> Entity
     * @param int|null $id
     * @param string $kind
     * @param string $message
     * @param NotificationStatus $status
     * @param string|null $error
     * @param DateTimeImmutable|null $sentDate
     * @param DateTimeImmutable|null $createdDate
     * @return self
     */
    public static function reconstitute(
        ?int $id,
        string $kind,
        string $message,
        NotificationStatus $status,
        ?string $error,
        ?DateTimeImmutable $sentDate,
        ?DateTimeImmutable $createdDate,
    ): self {
        return new self(
            id: $id,
            kind: $kind,
            message: $message,
            status: $status,
            error: $error,
            sentDate: $sentDate,
            createdDate: $createdDate ?? new DateTimeImmutable(),
        );
    }

    /**
     * Change Status form Pending/Error -> Success
     * @return self
     */
    public function markAsSent(): self
    {
        return new self(
            id: $this->id,
            kind: $this->kind,
            message: $this->message,
            status: NotificationStatus::SUCCESS,
            error: null,
            sentDate: new DateTimeImmutable(),
            createdDate: $this->createdDate,
        );
    }

    /**
     * Change Status form Pending/Success -> Error
     * @param string $error
     * @return self
     */
    public function markAsError(string $error): self
    {
        return new self(
            id: $this->id,
            kind: $this->kind,
            message: $this->message,
            status: NotificationStatus::ERROR,
            error: $error,
            sentDate: new DateTimeImmutable(),
            createdDate: $this->createdDate,
        );
    }
}