<?php

function iot_devices_page() {

    global $wpdb;

    $table = $wpdb->prefix . 'iot_devices';

    /*
    HANDLE DELETE
    */

    if (isset($_POST['delete_id'])) {

        $wpdb->delete($table, [
            'id' => intval($_POST['delete_id'])
        ]);

        echo "<div class='iot-success'>Device Deleted</div>";
    }

    /*
    HANDLE INSERT
    */

    if (isset($_POST['name'])) {

        $wpdb->insert($table, [

            'name' => sanitize_text_field($_POST['name']),
            'type' => sanitize_text_field($_POST['type']),
            'status' => sanitize_text_field($_POST['status']),
            'api_key' => wp_generate_password(20, false)

        ]);

        echo "<div class='iot-success'>Device Added</div>";
    }

    $devices = $wpdb->get_results("SELECT * FROM $table");

    echo "<div class='iot-container'>";

    echo "<div class='iot-card'>
        <div class='iot-header'>
            IoT Devices
        </div>
    </div>";

    /*
    ADD DEVICE FORM
    */

    echo "<div class='iot-card'>";

        echo "<div class='iot-card-title'>
            Add Device
        </div>";

        echo "<form method='post' class='iot-form'>";

            echo "
                <input
                    class='iot-input'
                    name='name'
                    placeholder='Device Name'
                    required
                >
            ";

            echo "
                <input
                    class='iot-input'
                    name='type'
                    placeholder='Device Type'
                    required
                >
            ";

            echo "
                <select class='iot-select' name='status'>
                    <option value='Online'>Online</option>
                    <option value='Offline'>Offline</option>
                </select>
            ";

            echo "
                <button
                    type='submit'
                    class='iot-button-primary'
                >
                    Add Device
                </button>
            ";

        echo "</form>";

    echo "</div>";

    /*
    DEVICES TABLE
    */

    echo "<div class='iot-card'>";

        echo "<table class='iot-table'>";

            echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>API Key</th>
                    <th>Actions</th>
                </tr>
            </thead>";

            echo "<tbody>";

                foreach ($devices as $device) {

                    $statusClass =
                        $device->status == 'Online'
                        ? 'iot-status-online'
                        : 'iot-status-offline';

                    echo "<tr>";

                    echo "<td>{$device->id}</td>";
                    echo "<td>{$device->name}</td>";
                    echo "<td>{$device->type}</td>";

                    echo "<td>
                            <span class='iot-status $statusClass'>
                            {$device->status}
                            </span>
                        </td>";

                    echo "<td class='iot-api'>{$device->api_key}</td>";

                    echo "<td>

                    <form method='post'>

                    <input
                        type='hidden'
                        name='delete_id'
                        value='{$device->id}'
                    >

                    <button class='iot-button-delete'>
                        Delete
                    </button>

                    </form>

                    </td>";

                    echo "</tr>";

                }

            echo "</tbody>";

        echo "</table>";

    echo "</div>";

    echo "</div>";

}