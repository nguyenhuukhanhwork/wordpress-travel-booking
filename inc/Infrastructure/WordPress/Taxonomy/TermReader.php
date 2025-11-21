<?php

namespace TravelBooking\Infrastructure\WordPress\Taxonomy;

use TravelBooking\Config\Enum\TaxonomyName;
use TravelBooking\Domain\Service\TourTaxonomyReader;
use TravelBooking\Infrastructure\Cache\CacheManager;

class TermReader implements TourTaxonomyReader
{
    private const CACHE_PREFIX = 'tour_terms_v1_';
    private const CACHE_TTL = HOUR_IN_SECONDS * 12;
    private array $memoryCache = [];
    public function getName(string $taxonomy, ?string $slug): ?string
    {
        if ($slug === null) {
            return null;
        }

        $terms = $this->all($taxonomy);
        return $terms[$slug] ?? null;
    }

    public function exists(string $taxonomy, ?string $slug): bool
    {
        if ($slug === null) {
            return true;
        }

        return isset($this->all($taxonomy)[$slug]);
    }

    /**
     * Get All Term of Taxonomy
     * @param string $taxonomy
     * @param string|null $slug
     * @return array
     */
    public function all(string $taxonomy, ?string $slug = null): array
    {
        // 1. In-memory cache (nhanh nhất)
        if (array_key_exists($taxonomy, $this->memoryCache)) {
            return $this->memoryCache[$taxonomy];
        }

        // 2. Kiểm tra WordPress đã sẵn sàng chưa (tránh lỗi "Invalid taxonomy")
        if (!did_action('init')) {
            return $this->memoryCache[$taxonomy] = [];
        }

        // 3. Kiểm tra taxonomy có tồn tại không
        if (!taxonomy_exists($taxonomy)) {
            return $this->memoryCache[$taxonomy] = [];
        }

        // Try get Cache
        $cacheKey = self::CACHE_PREFIX .  $taxonomy;

        $cached = CacheManager::get($cacheKey);

        // Nếu có Cache thì ghi thẳng vào Cache Memory của Class
        if ($cached) {
            return $this->memoryCache[$taxonomy] = $cached;
        }

        // Query Cache Database
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
            'fields' => 'all',
        ]);

        // 7. Xử lý lỗi an toàn
        if (is_wp_error($terms) || !is_array($terms)) {
            $map = [];
        } else {
            $map = wp_list_pluck($terms, 'name', 'slug'); // [slug => name]
        }

        // 8. Lưu cache
        CacheManager::set($cacheKey, $map, self::CACHE_TTL);

        return $map;
    }

    // Get all Taxonomy
    private function allTaxonomies(): array
    {
        $tour_taxonomies = TaxonomyName::cases();
        return wp_list_pluck($tour_taxonomies, 'value');
    }


    // Clear Cache
    public static function invalidateCache(): void
    {
        $instance    = new self();
        $taxonomies  = $instance->allTaxonomies();

        foreach ($taxonomies as $tax) {
            CacheManager::delete(self::CACHE_PREFIX . $tax);
        }
    }
}