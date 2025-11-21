<?php
namespace TravelBooking\Presentation\Rest;

use TravelBooking\Infrastructure\Repository\TourRepository;
use WP_REST_Request;
use WP_REST_Response;

final class TourEntitySearchController
{
    private static ?self $instance = null;

    private function __construct() {
        add_action('rest_api_init', [$this, 'init']);
    }

    public static function getInstance(): self
    {
        return self::$instance ?? (self::$instance = new self());
    }

    private function __clone() {}
    public function __wakeup() {
        throw new \Exception('Cannot unserialize a singleton.');
    }

    public function init(): void
    {
        register_rest_route('travel-booking/v1', '/search-tours', [
            'methods'             => 'GET',
            'callback'            => [$this, 'handleSearchTours'],
            'permission_callback' => '__return_true',
            'args'                => $this->getArgs(),
        ]);
    }

    private function getArgs(): array
    {
        return [
            'type'      => ['sanitize_callback' => 'sanitize_text_field', 'default' => ''],
            'location'  => ['sanitize_callback' => 'sanitize_text_field', 'default' => ''],
            'person'    => ['sanitize_callback' => 'absint',           'default' => 0],
            'linked'    => ['sanitize_callback' => 'sanitize_text_field', 'default' => ''],
            'page'      => ['sanitize_callback' => 'absint',           'default' => 1],
            'per_page'  => ['sanitize_callback' => fn($v) => min(100, max(1, absint($v))), 'default' => 20],
            'sort'      => ['sanitize_callback' => 'sanitize_text_field', 'default' => 'name'],
            'order'     => ['sanitize_callback' => fn($v) => in_array(strtolower($v), ['asc', 'desc']) ? strtolower($v) : 'asc', 'default' => 'asc'],
        ];
    }

    public function handleSearchTours(WP_REST_Request $request): WP_REST_Response
    {
        $repo = TourRepository::getInstance();

        // Lấy tham số
        $filters = [
            'type'     => $request->get_param('type'),
            'location' => $request->get_param('location'),
            'person'   => $request->get_param('person'),
            'linked'   => $request->get_param('linked'),
        ];

        $page     = max(1, $request->get_param('page'));
        $per_page = $request->get_param('per_page');
        $sort     = $request->get_param('sort');
        $order    = $request->get_param('order');

        // Gọi search từ repository
        $result = $repo->searchTours($filters, $page, $per_page, $sort, $order);

        // Response chuẩn
        return new WP_REST_Response([
            'success'    => true,
            'data'       => $result['items'],
            'pagination' => [
                'current_page' => $result['page'],
                'per_page'     => $result['per_page'],
                'total_items'  => $result['total'],
                'total_pages'  => $result['total_pages'],
            ],
            'filters'    => array_filter($filters, fn($v) => $v !== '' && $v !== 0),
            'sorting'    => ['sort' => $sort, 'order' => $order],
        ], 200);
    }
}