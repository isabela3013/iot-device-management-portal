<?php

/**
 * Plugin Name: IoT Portal
 */

if (!defined('ABSPATH')) {
    exit;
}


/*
LOAD FILES
*/

foreach (glob(plugin_dir_path(__FILE__) . 'includes/*.php') as $file) {
    require_once $file;
}

foreach (glob(plugin_dir_path(__FILE__) . 'api/*.php') as $file) {
    require_once $file;
}

function iot_load_assets() {

    wp_enqueue_style(
        'iot-admin-style',
        plugin_dir_url(__FILE__) . 'css/admin.css'
    );

    wp_enqueue_style(
        'iot-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap'
    );

    wp_enqueue_script(
        'chartjs',
        'https://cdn.jsdelivr.net/npm/chart.js',
        [],
        null,
        true
    );

}

add_action('admin_enqueue_scripts', 'iot_load_assets');

