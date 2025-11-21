<?php

// Truy cập vào http://localhost:10014/?travel_booking_reinstall_database=1 để reset lại các Database. Chỉ có Admin mới được quyền này

use TravelBooking\Infrastructure\Database\BookingTable;
use TravelBooking\Infrastructure\Database\CustomerTable;
use TravelBooking\Infrastructure\Database\NotificationTable;

add_action('init', function() {

    // Drop Table
    $reinstall = filter_input(INPUT_GET, 'travel_booking_reinstall_database', FILTER_VALIDATE_BOOLEAN);

    if ($reinstall && current_user_can('manage_options')) {
        global $wpdb;
        $wpdb->query(
            'DROP TABLE IF EXISTS wp_travel_booking_booking_data, wp_travel_booking_customer, wp_travel_booking_notifications'
        );
        error_log('Table is dropped');
    }

    // Create Table
    BookingTable::getInstance()->createTable();
    CustomerTable::getInstance()->createTable();
    NotificationTable::getInstance()->createTable();
});