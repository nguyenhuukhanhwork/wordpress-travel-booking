<?php
/**
 * Load all testing file
 */

$test_dir = __DIR__ . "/tests/";
$files = scandir($test_dir);

foreach ($files as $file) {
    if (substr($file, 0, 1) != '.') {
        require_once $test_dir . $file;
    }
}