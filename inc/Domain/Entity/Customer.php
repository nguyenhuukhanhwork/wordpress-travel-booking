<?php

namespace TravelBooking\Domain\Entity;

final class Customer
{
    private function __construct(
        public readonly string              $id,
        public readonly string              $name,
        public readonly string              $email,
        public readonly string              $phone,
        public readonly ?string             $note = null,
        public readonly ?string             $metadata = null,
        public readonly ?\DateTimeImmutable $createdAt = null
    )
    {
    }

    // --- Factory
    public static function fromArray(array $data): self
    {
        return new self(
            id : $data['id'],
            name: trim($data['name'] ?? ''),
            email: trim($data['email'] ?? ''),
            phone: trim($data['phone'] ?? ''),
            note: trim($data['note']) ?? null,
            metadata: trim($data['metadata']) ?? null,
            createdAt: $data['created_at'] ?? current_time('mysql')
        );
    }

    // --- Convert to Array ---
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'note' => $this->note,
            'metadata' => $this->metadata,
            'created_at' => $this->createdAt
        ];
    }

    // --- Getter
    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function note(): ?string
    {
        return $this->note;
    }

    public function metadata(): ?string
    {
        return $this->metadata;
    }

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}