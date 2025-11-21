<?php

namespace TravelBooking\Application\DTO;

final class BookingFormDTO
{
    public function __construct(
        public readonly string  $customer_name,
        public readonly string  $customer_email,
        public readonly string  $customer_phone,
        public readonly string  $tour_name,
        public readonly string  $start_date,
        public readonly int     $adults,
        public readonly int     $children,
        public readonly ?string $note = null
    )
    {
    }

    /**
     * Chuyển đổi dữ liệu Submit Form của Contact Form 7 về  thành dữ liệu sạch hơn
     * @param array $raw_data
     * @return self
     */
    public static function fromCF7Form(array $raw_data): self
    {
        // Get data
        $customer_name = $raw_data['trbooking_customer_name'] ?? '';
        $customer_email = $raw_data['trbooking_customer_email'] ?? '';
        $customer_phone = $raw_data['trbooking_customer_phone'] ?? '';
        $tour_name = $raw_data['trbooking_tour_name'] ?? '';
        $startDate = $raw_data['trbooking_tour_start_date'] ?? '';
        $adults = $raw_data['trbooking_tour_adults'] ?? '';
        $children = $raw_data['trbooking_tour_child'] ?? '';
        $note = $raw_data['trbooking_tour_note'] ?? '';

        // Return self and sanitize data
        return new self(
            customer_name: sanitize_text_field($customer_name),
            customer_email: sanitize_email($customer_email),
            customer_phone: sanitize_text_field($customer_phone),
            tour_name: sanitize_text_field($tour_name),
            start_date: sanitize_text_field($startDate),
            adults: absint($adults),
            children: absint($children),
            note: sanitize_text_field($note),
        );
    }

    /**
     * Validate theo nghiệp vụ
     * @return array
     */
    public function validate(): array
    {
        $errors = [];
        if (empty($this->customer_name)) $errors[] = 'Tên bắt buộc';
        if (!is_email($this->customer_email)) $errors[] = 'Email không hợp lệ';
        return $errors;
    }

    // --- Convert to Entity Array

    /**
     * Customer Array
     * @return array
     */
    public function toCustomerArray(): array
    {
        return [
            'name' => $this->customer_name,
            'email' => $this->customer_email,
            'phone' => $this->customer_phone,
            'note' => $this->note
        ];
    }

    /**
     * Map to Booking Array
     * @param int $customer_id
     * @return array
     */
    public function toBookingArray(int $customer_id): array
    {
        return [
            'customer_id' => $customer_id,
            'tour_name' => $this->tour_name,
            'start_date' => $this->start_date,
            'tour_person' => $this->adults + $this->children,
            'booking_note' => $this->note
        ];
    }
}
