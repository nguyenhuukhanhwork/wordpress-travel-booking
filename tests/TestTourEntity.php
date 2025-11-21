<?php

function travel_booking_test_tour_entity(): void {

    // Mock data
    $tour = \TravelBooking\Domain\Entity\Tour::reconstruct(
        id: 999,
        name: 'Hà Nội - Đà Nẵng - Phú Quốc 5N4Đ Bay Vietnam Airlines',
        tourCode: 'HN-DN-PQ-0525',
        isFeatured: true,
        durationSlug: '5n4d',
        linkedSlug: 'co',
        gallery: ['img1.jpg', 'img2.jpg', 'img3.jpg'],
        typeSlug: 'noi-dia',
        personRangeSlug: '10-15',
        locationSlugs: ['ha-noi', 'da-nang', 'phu-quoc'],
        ratingSlug: '5-sao',
        featuredImage: 'https://example.com/featured-hanoi-danang.jpg',
        createdAt: new DateTimeImmutable('2025-04-01 08:00:00'),
        updatedAt: new DateTimeImmutable('2025-11-20 14:30:00'),
        status: \TravelBooking\Config\Enum\TourStatus::OPEN,
    );

    // Show data in web
    echo '<pre>';
    print_r($tour);
    echo '</pre>';
}

add_action('init', function () {
    travel_booking_test_tour_entity();
});