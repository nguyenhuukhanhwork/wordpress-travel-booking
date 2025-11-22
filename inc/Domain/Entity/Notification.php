<?php

namespace TravelBooking\Domain\Entity;
use DateTimeImmutable;
use TravelBooking\Config\Enum\NotificationStatus;

final readonly class Notification
{
    private function __construct(
        public readonly ?int               $id,
        public readonly string             $kind,
        public readonly string             $message,
        public readonly NotificationStatus $status,
        public readonly ?string            $error,
        public readonly ?DateTimeImmutable $sentDate,
        public readonly ?DateTimeImmutable $createdDate
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