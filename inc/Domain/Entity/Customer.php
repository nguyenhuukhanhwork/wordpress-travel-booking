<?php

namespace TravelBooking\Domain\Entity;

use TravelBooking\Config\Enum\CustomerSource;
use TravelBooking\Config\Enum\CustomerType;
use TravelBooking\Domain\ValueObject\DateTimeVO;

final readonly class Customer
{
    private function __construct(
        public ?int           $id,
        public string         $name,
        public string         $email,
        public string         $phone,
        public ?string        $address = null,
        public ?string        $note = null,
        public ?string        $metadata = null,
        public CustomerSource $customerSource,
        public CustomerType   $customerType,
        public ?DateTimeVO    $createdAt,
        public ?DateTimeVO    $updatedAt = null
    )
    {
    }

    // --- Factory

    /**
     * Create new Customer
     * @param string $name
     * @param string $phone
     * @param string|null $email
     * @param string|null $address
     * @param CustomerSource $customerSource
     * @param CustomerType $customerType
     * @return self
     */
    public static function create(
        string         $name,
        string         $phone,
        ?string        $email = null,
        ?string        $address = null,
        CustomerSource $customerSource = CustomerSource::WALK_IN,
        CustomerType   $customerType = CustomerType::INDIVIDUAL,
    ): self
    {
        return new self(
            id: null,
            name: $name,
            email: $email,
            phone: $phone,
            address: $address,
            customerSource: $customerSource,
            customerType: $customerType,
            createdAt: DateTimeVO::now(),
            updatedAt: null
        );
    }

    // Load từ DB – chỉ Mapper dùng
    public static function reconstitute(
        ?int           $id,
        string         $name,
        ?string        $email,
        string         $phone,
        ?string        $address,
        ?string        $note,
        ?string        $metadata,
        CustomerSource $customerSource,
        CustomerType   $customerType,
        DateTimeVO     $createdAt,
        ?DateTimeVO    $updatedAt
    ): self {
        return new self(
            id: $id,
            name: $name,
            email: $email,
            phone: $phone,
            address: $address,
            note: $note,
            metadata: $metadata,
            customerSource: $customerSource,
            customerType: $customerType,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }

    // ========== Behavior ==========

    /**
     * Upgrade customer type. Ex type family -> type group
     * @param CustomerType $newType
     * @return self
     */
    public function upgradeTypeTo(CustomerType $newType): self
    {
        return new self(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            phone: $this->phone,
            address: $this->address,
            customerSource: $this->customerSource,
            customerType: $newType,
            createdAt: $this->createdAt,
            updatedAt: DateTimeVO::now(),
        );
    }

    /**
     * Upgrade customer Source. Ex Facebook -> Zalo
     * @param CustomerSource $newSource
     * @return self
     */
    public function upgradeSourceTo(CustomerSource $newSource): self
    {
        return new self(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            phone: $this->phone,
            address: $this->address,
            customerSource: $newSource,
            customerType: $this->customerType,
            createdAt: $this->createdAt,
            updatedAt: DateTimeVO::now(),
        );
    }

    public function upgradeToVip(): self
    {
        return $this->upgradeTypeTo(CustomerType::VIP);
    }
}