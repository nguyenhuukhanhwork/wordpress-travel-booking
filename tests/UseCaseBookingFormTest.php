<?php
/**
 * Testing Contact Form 7
 * Form ID 551
 */
use TravelBooking\Application\UseCase\SubmitBookingUseCase;
use TravelBooking\Infrastructure\Repository\CustomerRepository;

function test_use_case_booking_form_cf7(): void {
    $mock_data = [
        'trbooking_customer_name' => 'John Doe',
        'trbooking_customer_email' => 'khanhecb@gmail.com',
        'trbooking_customer_phone' => '0332445085',
        'trbooking_customer_note' => 'Testing Note',
        'trbooking_tour_name' => 'Phú Quốc 7 ngày 3 đêm',
        'trbooking_tour_start_date' => '2025-10-10',
        'trbooking_tour_adults' => '5',
        'trbooking_tour_child' => '4',
        'trbooking_tour_note' => 'Testing Note'
    ];


    $customer = CustomerRepository::getInstance();
    $booking_repo = \TravelBooking\Infrastructure\Repository\BookingDataRepository::getInstance();
    $submit = new SubmitBookingUseCase($customer, $booking_repo);
    $submit->execute($mock_data);

}

add_action('init', function () {
    if (!isset($_GET['test_booking_use_case'])) {
        return;
    }
    test_use_case_booking_form_cf7();

    dd('DONE TESTING');
});
