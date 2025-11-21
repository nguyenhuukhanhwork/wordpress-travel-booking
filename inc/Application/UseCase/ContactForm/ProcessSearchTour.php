<?php

namespace TravelBooking\Application\UseCase\ContactForm;

use TravelBooking\Infrastructure\Logger\Logger;

class ProcessSearchTour
{
    private static ?self $instance = null;

    public static function getInstance(): self
    {
        return self::$instance ?? (self::$instance = new self());
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        try {
            throw new \Exception("Cannot unserialize a singleton.");
        } catch (\Exception $e) {
            Logger::log("Cannot unserialize a singleton.");
        }
    }
}