<?php

namespace TravelBooking\Domain\Mapper;

use TravelBooking\Config\Enum\CustomerSource;
use TravelBooking\Config\Enum\CustomerType;
use TravelBooking\Domain\Entity\Customer;
use DateTimeImmutable;

final class CustomerMapper
{
    private const DEFAULT_TYPE = CustomerType::INDIVIDUAL;
    private const DEFAULT_SOURCE = CustomerSource::WEBSITE;

    /**
     * Use in Repository
     *
     * @param array $row
     * @return Customer
     * @throws \Exception
     */
    public static function fromRow(array $row): Customer
    {
        return Customer::reconstitute(
            id: !empty($row['id']) ? (int)$row['id'] : null,
            name: $row['name'],
            email: $row['email'] ?? null,
            phone: $row['phone'],
            address: $row['address'] ?? null,
            note: $row['note'] ?? null,
            metadata: $row['metadata'] ?? null,
            customerSource: CustomerSource::from($row['customer_source'] ?? self::DEFAULT_SOURCE->value),
            customerType: CustomerType::from($row['customer_type'] ?? self::DEFAULT_TYPE->value),
            createdAt:  new DateTimeImmutable($row['created_at']) ?? new DateTimeImmutable(),
            updatedAt: !empty($row['updated_at']) ? new DateTimeImmutable($row['updated_at']) : null
        );
    }

    /**
     * Use insert to database
     * @param Customer $customer
     * @return array
     */
    public static function toRow(Customer $customer): array
    {
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email ?? null,
            'phone' => $customer->phone ?? null,
            'address' => $customer->address ?? null,
            'note' => $customer->note ?? null,
            'metadata' => $customer->metadata ?? null,
            'customer_source' => $customer->customerSource->value ?? self::DEFAULT_SOURCE->value,
            'customer_type' => $customer->customerType->value ?? self::DEFAULT_TYPE->value,
            'created_at' => $customer->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $customer->updatedAt?->format('Y-m-d H:i:s') ?? null
        ];
    }
}