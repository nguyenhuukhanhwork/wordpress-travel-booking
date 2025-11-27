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
use TravelBooking\Config\Enum\NotificationStatus;
use TravelBooking\Domain\ValueObject\DateTimeVO;

final readonly class Notification
{
    private function __construct(
        public ?int               $id,
        public string             $kind,
        public string             $message,
        public NotificationStatus $status,
        public ?string            $error,
        public ?DateTimeVO        $sentDate,
        public ?DateTimeVO        $createdDate
    )
    {
    }

    // --- Factory

    /**
     * Create new Notification
     * @param string $kind
     * @param string $message
     * @param string|null $sendDate
     * @param NotificationStatus $status
     * @return self
     */
    public static function create(
        string $kind,
        string $message,
        NotificationStatus $status,
        ?string $sendDate = null,
    ): self {
        return new self(
            id: null,
            kind: $kind,
            message: $message,
            status: $status,
            error: null,
            sentDate: $sendDate ? DateTimeVO::fromString($sendDate) : DateTimeVO::now(),
            createdDate: DateTimeVO::now(),
        );
    }

    /**
     * Factory method for Mapper database -> Entity
     * @param int|null $id
     * @param string $kind
     * @param string $message
     * @param NotificationStatus $status
     * @param string|null $error
     * @param DateTimeVO|null $sentDate
     * @param DateTimeVO|null $createdDate
     * @return self
     */
    public static function reconstitute(
        ?int               $id,
        string             $kind,
        string             $message,
        NotificationStatus $status,
        ?string            $error,
        ?DateTimeVO        $sentDate,
        ?DateTimeVO        $createdDate,
    ): self {
        return new self(
            id: $id,
            kind: $kind,
            message: $message,
            status: $status,
            error: $error,
            sentDate: $sentDate,
            createdDate: $createdDate ?? DateTimeVO::now(),
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
            sentDate: DateTimeVO::fromString($this->sentDate) ?? DateTimeVO::now(),
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
            sentDate: DateTimeVO::fromString($this->sentDate) ?? DateTimeVO::now(),
            createdDate: $this->createdDate,
        );
    }
}