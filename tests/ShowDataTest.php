<?php
/**
 * Use var_dum function for test print data
 * @warning just test in local
 */

use TravelBooking\Infrastructure\Database\BookingTable;

add_action('plugins_loaded', function() {
    BookingTable::getInstance();
    \TravelBooking\Infrastructure\Database\CustomerTable::getInstance();
    \TravelBooking\Infrastructure\Database\NotificationTable::getInstance();
    \TravelBooking\Infrastructure\Database\BookingTable::getInstance();
});