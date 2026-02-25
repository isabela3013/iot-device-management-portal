<?php

if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'iot_register_admin_menu');

function iot_register_admin_menu() {

    add_menu_page(
        'IoT Portal',
        'Device Portal',
        'manage_options',
        'iot-dashboard',
        'iot_dashboard_page',
        'dashicons-chart-line',
        2
    );

    add_submenu_page(
        'iot-dashboard',
        'Dashboard',
        'Dashboard',
        'manage_options',
        'iot-dashboard',
        'iot_dashboard_page'
    );

    add_submenu_page(
        'iot-dashboard',
        'Devices',
        'Devices',
        'manage_options',
        'iot-devices',
        'iot_devices_page'
    );
}