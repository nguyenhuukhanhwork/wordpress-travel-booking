<?php

namespace TravelBooking\Domain\Entity;

final class Notification
{
    private function __construct(
        public readonly int    $id,
        public readonly string $kind,
        public readonly string $message,
        public readonly string $status,
        public readonly string $error,
        public readonly string $sent_date,
        public readonly string $create_date
    )
    {
    }

    // --- Getter
    public function getId(): int {return $this->id;}
    public function getKind(): string {return $this->kind;}
    public function getMessage(): string {return $this->message;}
    public function getStatus(): string {return $this->status;}
    public function getError(): string {return $this->error;}
    public function getSentDate(): string {return $this->sent_date;}
    public function getCreateDate(): string {return $this->create_date;}

    // --- Business Logic
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'kind' => $this->kind,
            'message' => $this->message,
            'status' => $this->status,
            'error' => $this->error ?? null,
            'sent_date' => $this->sent_date,
            'create_date' => $this->create_date
        ];
    }

    // --- Factory
    public function fromArray(array $data): Notification
    {
        return new self(
            id: $data['id'] ?? 0,
            kind: $data['kind'] ?? '',
            message: $data['message'] ?? '',
            status: $data['status'] ?? '',
            error: $data['error'] ?? null,
            sent_date: $data['sent_date'] ?? null,
            create_date: $data['create_date'] ?? null
        );
    }

}