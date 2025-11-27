<?php

//function test_tour_tax(): void
//{
//    $term = new \TravelBooking\Infrastructure\WordPress\Taxonomy\TermReader();
//
//    $tour = \TravelBooking\Domain\Entity\Tour::reconstruct(
//        id: 999,
//        name: 'Hà Nội - Đà Nẵng - Phú Quốc 5N4Đ Bay Vietnam Airlines',
//        tourCode: 'HN-DN-PQ-0525',
//        isFeatured: true,
//        durationSlug: '5n4d',
//        linkedSlug: 'co',
//        gallery: ['img1.jpg', 'img2.jpg', 'img3.jpg'],
//        typeSlug: 'mien-bac',
//        personRangeSlug: '10-15',
//        locationSlugs: ['ha-noi', 'da-nang', 'phu-quoc'],
//        ratingSlug: '5-sao',
//        featuredImage: 'https://example.com/featured-hanoi-danang.jpg',
//        createdAt: new \DateTimeImmutable('2025-04-01 08:00:00'),
//        updatedAt: new \DateTimeImmutable('2025-11-20 14:30:00'),
//        status: \TravelBooking\Config\Enum\TourStatus::OPEN,
//    );
//
//    $data = $tour->typeLabel($term);
//}
//
//add_action('init', 'test_tour_tax');