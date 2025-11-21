<?php

namespace TravelBooking\Config\Integration;

// Tắt gửi Email Contact Form 7
add_filter('wpcf7_skip_mail', '__return_true');