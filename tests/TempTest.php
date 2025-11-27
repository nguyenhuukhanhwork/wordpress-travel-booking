<?php



$data = \TravelBooking\Domain\ValueObject\MoneyVO::vnd(120980555);

print_r($data->format());