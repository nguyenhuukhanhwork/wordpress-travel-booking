<?php

namespace TravelBooking\Infrastructure\Repository;

use TravelBooking\Domain\Entity\Customer;
use TravelBooking\Infrastructure\Database\CustomerTable;

class CustomerRepository extends BaseCustomTable
{
    private static ?self $instance = null;
    private function __construct() {
        parent::__construct(CustomerTable::getInstance());
    }
    public static function getInstance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function add(Customer $customer): int
    {
        $insertedId = parent::insertRow($customer->toArray());
        return $insertedId ?: throw new \RuntimeException('Insert customer failed' . print_r($customer, true));
    }

}
