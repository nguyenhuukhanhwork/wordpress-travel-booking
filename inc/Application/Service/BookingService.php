<?php

namespace TravelBooking\Application\Service;

use TravelBooking\Infrastructure\Repository\BookingDataRepository;
use TravelBooking\Infrastructure\Repository\CustomerRepository;

class BookingService
{
    public function __construct(
        private CustomerRepository $customerRepo,
        private BookingDataRepository $bookingRepo
    ) {}

    public function createFromForm(array $form): void {
//        // Customer
//        $customer_name = $form['customer_name'];
//        $customer_email = $form['customer_email'];
//        $customer_phone = $form['customer_phone'];
//        $customer_id = $this->customerRepo->add($customer_name, $customer_email, $customer_phone);
//
//        // Booking data
//        $booking_tour_id = $form['tour_id'] ?? 0;
//        $booking_person = $form['tour_adults'] + $form['tour_child'];
//        $booking_start_date = $form['tour_start_date'];
//        $booking_name = $form['tour_name'];
//        $booking_note = $form['tour_note'];
//
//        $this->bookingRepo->add();
    }
}