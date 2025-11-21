<?php

namespace TravelBooking\Presentation\Shortcodes;

class TourSearch
{
    public function __construct() {
        add_action('init', [$this, 'init']);
        add_shortcode('tour_search', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function init() {
        // Đảm bảo REST API đã sẵn sàng
    }

    public function enqueue_assets() {
        if (!is_admin() && has_shortcode(get_post()->post_content, 'tour_search')) {
            wp_enqueue_style('tour-search-css', TB_PRESENTATION_LAYER_URL . 'Assets/css/style.css', [], '1.0');
            wp_enqueue_script('tour-search-js', TB_PRESENTATION_LAYER_URL . 'Assets/js/script.js', [], '1.0', true);
            wp_localize_script('tour-search-js', 'tourSearch', [
                'apiUrl' => rest_url('travel-booking/v1/search-tours'),
                'nonce'  => wp_create_nonce('wp_rest')
            ]);
        }
    }

    public function render($atts) {
        ob_start();
        ?>
        <div class="tour-search-container">
            <div class="tour-search-form">
                <div class="form-group">
                    <label>Loại tour</label>
                    <input type="text" id="tour-type" placeholder="Quốc Tế, Trong Nước..." />
                </div>
                <div class="form-group">
                    <label>Địa điểm</label>
                    <input type="text" id="tour-location" placeholder="Mỹ, Phú Quốc..." />
                </div>
                <div class="form-group">
                    <label>Số người</label>
                    <input type="number" id="tour-person" min="1" placeholder="2" />
                </div>
                <div class="form-group">
                    <label>Từ khóa</label>
                    <input type="text" id="tour-keyword" placeholder="visa, cao cấp..." />
                </div>
            </div>

            <div id="tour-loading" class="loading" style="display:none;">Đang tìm tour...</div>
            <div id="tour-results" class="tour-results"></div>
            <div id="tour-pagination" class="pagination"></div>
        </div>
        <?php
        return ob_get_clean();
    }
}