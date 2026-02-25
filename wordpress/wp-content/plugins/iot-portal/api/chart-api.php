<?php

add_action('rest_api_init', 'iot_register_chart_routes');

function iot_register_chart_routes() {

    register_rest_route('iot/v1', '/signals/(?P<device_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'iot_get_device_signals',
        'permission_callback' => '__return_true'
    ));

}


function iot_get_device_signals($request) {

    global $wpdb;

    $signals_table = $wpdb->prefix . 'iot_signals';

    $device_id = intval($request['device_id']);

    $results = $wpdb->get_results(
        $wpdb->prepare("
            SELECT temperature, created_at
            FROM $signals_table
            WHERE device_id = %d
            ORDER BY created_at ASC
            LIMIT 50
        ", $device_id)
    );

    $labels = [];
    $values = [];

    foreach ($results as $row) {
        $labels[] = $row->created_at;
        $values[] = floatval($row->temperature);
    }

    return array(
        "labels" => $labels,
        "values" => $values
    );
}