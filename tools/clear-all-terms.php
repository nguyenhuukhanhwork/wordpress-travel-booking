<?php
/**
 * Xoá toàn bộ term trong nhiều taxonomy.
 *
 * Truy cập: https://your-site.com/?delete_all_terms=1
 */

add_action('init', function () {

    $taxonomies = [
        'tour_type',
        'tour_location',
        'tour_person',
        'tour_linked',
    ];

    echo "<h2>Bắt đầu xoá terms...</h2>";

    foreach ($taxonomies as $taxonomy) {

        echo "<p>Đang xoá taxonomy: <strong>{$taxonomy}</strong></p>";

        if (!taxonomy_exists($taxonomy)) {
            echo "<p style='color:red;'>Taxonomy '{$taxonomy}' không tồn tại!</p>";
            continue;
        }

        $terms = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        ]);

        if (is_wp_error($terms)) {
            echo "<p style='color:red;'>Không thể lấy term của {$taxonomy}.</p>";
            continue;
        }

        foreach ($terms as $term) {
            wp_delete_term($term->term_id, $taxonomy);
        }

        echo "<p style='color:green;'>✔ Đã xoá toàn bộ term trong {$taxonomy}.</p>";
    }

    echo "<h3>Hoàn tất.</h3>";
    exit;
});
