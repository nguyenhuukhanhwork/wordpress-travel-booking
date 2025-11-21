<?php

namespace TravelBooking\Infrastructure\Integrations\CF7;
use Exception;
use TravelBooking\Application\Service\BookingService;
use TravelBooking\Application\UseCase\SubmitBookingUseCase;
use TravelBooking\Config\Enum\CF7_Form_Id;
use TravelBooking\Infrastructure\Repository\BookingDataRepository;
use TravelBooking\Infrastructure\Repository\CustomerRepository;
use WPCF7_ContactForm;
use WPCF7_Submission;

final class HandleFormSubmit
{
    private static ?self $instance = null;
    private $form_booking_id;
    private $form_search_tour_id;
    public static function getInstance(): self
    {

        return self::$instance ?? (self::$instance = new self());
    }
    private function __construct() {
        $this->form_booking_id = CF7_Form_Id::FORM_BOOKING_ID->value;
        $this->form_search_tour_id = CF7_Form_Id::FORM_SEARCH_TOUR_ID->value;
        add_action('wpcf7_before_send_mail', [$this, 'handle']);
        add_action('wpcf7_before_send_mail', [$this, 'handSearchForm']);
    }

    private function __clone() {}
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }

    public function handle(WPCF7_ContactForm $contact_form): void {

        // Form ID Contact Form 7
        $form_id = $this->form_booking_id;
        if ($contact_form->id() !== $form_id) return;

        $submission = WPCF7_Submission::get_instance();
        if (!$submission) return;

        $data = $submission->get_posted_data();

        $customer = CustomerRepository::getInstance();
        $submit_form_use_case = new SubmitBookingUseCase($customer);
        $submit_form_use_case->execute($data);
    }

    public function handSearchForm(WPCF7_ContactForm $contact_form): void {
        $form_id = $this->form_search_tour_id;

        $submission = WPCF7_Submission::get_instance();
        if (!$submission) return;

        $data = $submission->get_posted_data();

        error_log(print_r($data, true));
    }
}



