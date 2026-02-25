<?php

/*
CUSTOM ADMIN FOOTER
*/

add_filter('admin_footer_text', 'iot_custom_footer');

function iot_custom_footer() {

    return '
        <span class="iot-footer">
            IoT Portal • Real-time Device Monitoring • © '.date('Y').'
        </span>
    ';

}


add_filter('update_footer', 'iot_custom_footer_version', 11);

function iot_custom_footer_version() {

    return '
        v1.0 | IoT Monitoring System
    ';

}