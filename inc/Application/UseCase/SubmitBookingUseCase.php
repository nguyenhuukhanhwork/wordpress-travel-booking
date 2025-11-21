<?php

namespace TravelBooking\Application\UseCase;

use SimplePie\Exception;
use TravelBooking\Application\DTO\BookingFormDTO;
use TravelBooking\Application\Service\BookingService;
use TravelBooking\Domain\Entity\Booking;
use TravelBooking\Domain\Entity\Customer;
use TravelBooking\Infrastructure\Logger\Logger;
use TravelBooking\Infrastructure\Notification\TelegramNotification;
use TravelBooking\Infrastructure\Repository\BookingDataRepository;
use TravelBooking\Infrastructure\Repository\CustomerRepository;
use TravelBooking\Infrastructure\Repository\NotificationRepository;
use WP_Error;
use WPCF7_Submission;
use function PHPUnit\Framework\throwException;

class SubmitBookingUseCase
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly BookingDataRepository $bookingRepository,
        private readonly NotificationRepository $notificationRepository,
    ){}

    public function execute(array $data): WP_Error|array
    {
        // Get data
        $dto = BookingFormDTO::fromCF7Form($data);
        $errors = $dto->validate();

        foreach ($errors as $error) {
            Logger::log($error);
        }

        // Init and Save Customer information to database
        $dto_customer_array = $dto->toCustomerArray();
        $dto_customer_array = apply_filters('booking_form_customer_data', $dto->toCustomerArray(), $dto, $data);
        $customer = Customer::fromArray($dto_customer_array); // Init Customer

        // Action for Custom data
        $customer = apply_filters('booking_form_pre_insert_customer', $customer, $dto, $data);

        if (empty($customer)) {
            throwException('[Booking Form] - Thông tin nhiều đại diện bị bỏ trống');
        }

        $customer_id = $this->customerRepository->add($customer); // Save Customer to Database

        // Init and Save Booking information to database
        $dto_booking_array = $dto->toBookingArray($customer_id); // DTO data
        $booking = Booking::fromArray($dto_booking_array);
        $booking_id = $this->bookingRepository->add($booking);

        // Send Notification

        $message =
            "<pre><code>" .
            "Tên: $name\n" .
            "Email: $email\n" .
            "SĐT: $phone\n" .
            "Tour: $tour_type\n" .
            "Giá: $tour_cost" .
            "</code></pre>";
        $teleram = TelegramNotification::getInstance()->send();

        return [];
    }

}