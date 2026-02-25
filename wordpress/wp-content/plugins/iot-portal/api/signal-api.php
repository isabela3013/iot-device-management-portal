<?php

add_action('rest_api_init', 'iot_register_api_routes');

function iot_register_api_routes() {

    register_rest_route('iot/v1', '/signal', array(
        'methods'  => 'POST',
        'callback' => 'iot_receive_signal',
        'permission_callback' => '__return_true'
    ));

}

function iot_receive_signal($request) {

    global $wpdb;

    $devices_table = $wpdb->prefix . 'iot_devices';
    $signals_table = $wpdb->prefix . 'iot_signals';

    /*
    READ AUTH HEADER
    */

    $authHeader = $request->get_header('authorization');

    if (!$authHeader) {

        return array(
            'status' => 'error',
            'message' => 'Missing API key'
        );

    }

    /*
    EXTRACT API KEY
    */

    if (!str_starts_with($authHeader, 'Bearer ')) {

        return array(
            'status' => 'error',
            'message' => 'Invalid Authorization format'
        );

    }

    $apiKey = str_replace('Bearer ', '', $authHeader);


    /*
    VALIDATE DEVICE
    */

    $device = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $devices_table WHERE api_key = %s",
            $apiKey
        )
    );


    if (!$device) {

        return array(
            'status' => 'error',
            'message' => 'Invalid API key'
        );

    }


    /*
    GET JSON DATA
    */

    $data = $request->get_json_params();

    if (!isset($data['temperature'])) {

        return array(
            'status' => 'error',
            'message' => 'temperature required'
        );

    }


    /*
    STORE SIGNAL
    */

    $wpdb->insert($signals_table, array(

        'device_id' => $device->id,
        'temperature' => floatval($data['temperature']),
        'created_at' => current_time('mysql')

    ));

    $wpdb->update($devices_table,
        array(
            'last_signal' => current_time('mysql'),
            'status' => 'Online'
        ),
        array(
            'id' => $device->id
        )
    );


    return array(
        'status' => 'success',
        'device' => $device->name
    );

}