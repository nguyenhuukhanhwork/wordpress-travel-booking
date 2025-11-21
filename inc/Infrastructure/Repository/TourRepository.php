<?php

namespace TravelBooking\Infrastructure\Repository;

use TravelBooking\Infrastructure\WordPress\Registry\CPTRegistry;

final class TourRepository extends BasePostTypeRepository
{
    private static ?self $instance = null;
    private function __construct() {
        parent::__construct();
    }
    private function __clone()
    {
    }

    public function __wakeup()
    {
    }
    public static function getInstance(): self
    {
        return self::$instance ?? (self::$instance = new self());
    }
    static function DEFINE_CACHE_KEY_PREFIX(): string
    {
        return 'tour_';
    }

    static function POST_TYPE(): string
    {
        return CPTRegistry::getPostTypes('tour') ?? 'tour';
    }
    static function FIELDS(): array
    {
        return [
            'tour_code',
            'tour_featured_tour',
            'tour_duration_days',
            'tour_duration_nights',
            'tour_gallery'
        ];
    }
    static function TAXONOMY(): array
    {
        return [
            'tour_type',
            'tour_location',
            'tour_rating_level'
        ];
    }

    public function getAllIds(array $args = []): array
    {
        return parent::getAllIds($args);
    }
    public function getById(int $post_id): ?\WP_Post
    {
        return parent::getById($post_id);
    }
    public function getAllEntities(): array
    {
        return parent::getAllEntity();
    }
    public function getAllNames(): array
    {
        return parent::getAllNames();
    }
    public function getTourTypeTermNames(): array
    {
        return parent::getTermList('tour_type');
    }
    public function geTourLocationTermNames(): array
    {
        return parent::getTermList('tour_location');
    }
    public function getTourCostTermNames(): array
    {
        return parent::getTermList('tour_cost');
    }
    public function getTourPersonTermNames(): array {
        return parent::getTermList('tour_person');
    }
    public function getTourLinkedTermNames(): array
    {
        return parent::getTermList('tour_linked');
    }

    public function getAll(array $args = []): array
    {
        return parent::getAll($args);
    }

    public function getPermalinkNameMap(): array{
        return parent::getPermalinkNameMap();
    }
    private function buildTaxQuery(
        ?int $type_id = null,
        ?int $loc_id = null,
        ?int $linked_id = null,
        ?int $person_id = null
    ): array {
        $relation = 'AND';
        $tax_query = ['relation' => $relation];

        $taxonomies = [
            'tour_type'     => $type_id,
            'tour_location' => $loc_id,
            'tour_linked'   => $linked_id,
            'tour_person'   => $person_id,
        ];

        foreach ($taxonomies as $taxonomy => $term_id) {
            if ($term_id > 0) {
                $tax_query[] = [
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => [$term_id],
                ];
            }
        }

        return ['tax_query' => $tax_query];
    }

    /**
     * Filter Tour Post Type Tour with all Taxonomy of Post Type Tour, return Post Type Object
     * @param int|null $type_id
     * @param int|null $loc_id
     * @param int|null $linked_id
     * @param int|null $person_id
     * @return array all Post Type Object
     */
    public function filterAdvancedTour(
        ?int $type_id = null,
        ?int $loc_id = null,
        ?int $linked_id = null,
        ?int $person_id = null
    ): array {
        $args = $this->buildTaxQuery($type_id, $loc_id, $linked_id, $person_id);

        $all_entity = parent::getAll($args);

        if (empty($all_entity)) {
            return [];
        }

        return $all_entity;
    }

    /**
     * Convert Post -> Array Entity
     * @param \WP_Post $post
     * @return array Array data chuẩn để Loop
     */
    public function mapToEntity(\WP_Post $post): array {
        return parent::mapToEntity($post);
    }

    public function searchTours(
        array $filters = [],
        int $page = 1,
        int $per_page = 20,
        string $sort = 'name',
        string $order = 'asc'
    ): array {
        $all = $this->getAllEntities();

        // Lọc
        $filtered = $this->applyFilters($all, $filters);

        // Sắp xếp
        $filtered = $this->applySorting($filtered, $sort, $order);

        // Phân trang
        $total = count($filtered);
        $offset = ($page - 1) * $per_page;
        $items = array_slice($filtered, $offset, $per_page);

        return [
            'items'       => array_values($items),
            'total'       => $total,
            'page'        => $page,
            'per_page'    => $per_page,
            'total_pages' => max(1, ceil($total / $per_page)),
        ];
    }

    private function applyFilters(array $tours, array $filters): array
    {
        return array_filter($tours, function ($tour) use ($filters) {
            foreach ($filters as $key => $value) {
                if ($value === '' || $value === 0) continue;

                $value = trim($value);
                $valueLower = mb_strtolower($value, 'UTF-8'); // hỗ trợ tiếng Việt

                switch ($key) {
                    case 'type':
                        if (empty($tour['tour_type'])) return false;
                        $found = false;
                        foreach ((array)$tour['tour_type'] as $type) {
                            if (mb_strpos(mb_strtolower($type, 'UTF-8'), $valueLower) !== false) {
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) return false;
                        break;

                    case 'location':
                        if (empty($tour['tour_location'])) return false;
                        $found = false;
                        foreach ((array)$tour['tour_location'] as $loc) {
                            if (mb_strpos(mb_strtolower($loc, 'UTF-8'), $valueLower) !== false) {
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) return false;
                        break;

                    case 'person':
                        $min_person = $tour['tour_min_person'] ?? 1;
                        if ((int)$value < (int)$min_person) return false;
                        break;

                    case 'linked':
                        if (!isset($tour['tour_linked']) || $tour['tour_linked'] !== $value) return false;
                        break;
                }
            }
            return true;
        });
    }

    private function applySorting(array $tours, string $sort, string $order): array
    {
        $valid_sorts = ['name', 'price', 'duration', 'rating', 'date'];
        $sort = in_array($sort, $valid_sorts) ? $sort : 'name';

        usort($tours, function ($a, $b) use ($sort, $order) {
            $a_val = $this->getSortValue($a, $sort);
            $b_val = $this->getSortValue($b, $sort);

            $cmp = ($a_val ?? '') <=> ($b_val ?? '');

            return $order === 'desc' ? -$cmp : $cmp;
        });

        return $tours;
    }

    private function getSortValue(array $tour, string $sort)
    {
        return match ($sort) {
            'name'      => $tour['name'] ?? '',
            'price'     => $tour['tour_price'] ?? 0,
            'duration'  => $tour['tour_duration_days'] ?? 0,
            'rating'    => $tour['tour_rating_level'] ?? 0,
            'date'      => $tour['tour_start_date'] ?? '',
            default     => $tour['name'] ?? '',
        };
    }
}