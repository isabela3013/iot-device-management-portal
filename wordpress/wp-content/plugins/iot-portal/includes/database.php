<?php

if (!defined('ABSPATH')) exit;

function iot_create_tables() {

    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $devices_table = $wpdb->prefix . 'iot_devices';
    $signals_table = $wpdb->prefix . 'iot_signals';
    $logs_table = $wpdb->prefix . 'iot_logs';

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta("CREATE TABLE $devices_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        type VARCHAR(50),
        status VARCHAR(20),
        api_key VARCHAR(100),
        last_signal DATETIME
    ) $charset_collate;");

    dbDelta("CREATE TABLE $signals_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        device_id INT,
        temperature FLOAT,
        created_at DATETIME
    ) $charset_collate;");

    dbDelta("CREATE TABLE $logs_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        device_id INT,
        message TEXT,
        status VARCHAR(20),
        created_at DATETIME
    ) $charset_collate;");
}

register_activation_hook(__FILE__, 'iot_create_tables');