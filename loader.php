<?php

use TravelBooking\Infrastructure\Database\BookingTable;
use TravelBooking\Infrastructure\Database\CustomerTable;
use TravelBooking\Infrastructure\Database\NotificationTable;
use TravelBooking\Presentation\Rest\TourNameSearchRestController;
use TravelBooking\Presentation\Rest\TourEntitySearchController;
use \TravelBooking\Infrastructure\WordPress\Registry\CPTRegistry;
use \TravelBooking\Infrastructure\WordPress\Registry\ACFRegistry;
use \TravelBooking\Infrastructure\WordPress\Registry\TaxonomyRegistry;
use \TravelBooking\Infrastructure\Integrations\CF7\RegistrarTagOptions;
/** Autoload File */
require_once __DIR__.'/vendor/autoload.php';
/** Load Const */
require_once __DIR__.'/constant.php';


// REST API Controller
TourNameSearchRestController::getInstance();
TourEntitySearchController::getInstance();

function tour_booking_system_register_wordpress_infrastructure(): void {
    CPTRegistry::getInstance();
    ACFRegistry::getInstance();
    TaxonomyRegistry::getInstance();
}

function tour_booking_system_create_table(): void {
    $option_name = \TravelBooking\Config\Enum\OptionName::DB_INSTALLED->value;
    $database_installed = get_option($option_name);

    if (!$database_installed) {
        // BookingIndexTable::getInstance();
        BookingTable::getInstance();
        CustomerTable::getInstance();
        NotificationTable::getInstance();
        // \TravelBooking\Infrastructure\Database\ContactDataTable::getInstance();
        // TourSchedulerTable::getInstance();

        update_option($option_name, true);
    }
}

// Bootstrap
tour_booking_system_register_wordpress_infrastructure();
tour_booking_system_create_table();

// Load Contact form 7 tag
RegistrarTagOptions::getInstance();

\TravelBooking\Infrastructure\Integrations\CF7\HandleFormSubmit::getInstance();

// Load Shortcode
\TravelBooking\Presentation\Shortcodes\SearchTourShortcode::getInstance();
\TravelBooking\Presentation\Shortcodes\AdvancedSearchTourRestShortcode::getInstance();
new \TravelBooking\Presentation\Shortcodes\TourSearch();

require_once __DIR__."/tools/reinstall-database.php";
require_once __DIR__."/testing.php";