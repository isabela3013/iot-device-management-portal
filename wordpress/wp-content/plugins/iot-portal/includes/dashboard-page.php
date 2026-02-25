<?php

function iot_dashboard_page() {

    global $wpdb;

    $devices_table = $wpdb->prefix.'iot_devices';
    $signals_table = $wpdb->prefix.'iot_signals';

    $devices = $wpdb->get_results("
        SELECT d.id,
            d.name,
            d.status,
            d.last_signal,
            s.temperature,
            s.created_at
        FROM $devices_table d
        LEFT JOIN $signals_table s
        ON d.id = s.device_id
        AND s.id = (
        SELECT MAX(id)
        FROM $signals_table
        WHERE device_id=d.id)
    ");

    echo "<div class='iot-container'>";

    
    echo "<div class='iot-card'>
        <div class='iot-header'>
            IoT Device Dashboard
        </div>
    </div>";


    echo "<div class='iot-grid'>";


        /* Device List Card */

        echo "<div class='iot-card'>";

            echo "<div class='iot-card-title'>
                Devices
            </div>";

            echo "<table class='iot-table'>";

                echo "<tr>
                    <th>Device</th>
                    <th>Status</th>
                    <th>Temp</th>
                </tr>";

                foreach($devices as $device) {
                    $statusClass =
                        $device->status == "Online"
                            ? "iot-online"
                            : "iot-offline";

                    echo "<tr>";

                        echo "<td>$device->name</td>";

                        echo "<td class='$statusClass'>
                            $device->status
                        </td>";

                        echo "<td>
                            $device->temperature °C
                        </td>";

                    echo "</tr>";

                }

            echo "</table>";

        echo "</div>";



        /* Chart Card */

        echo "<div class='iot-card'>";

            echo "<div class='iot-card-title'>
                Temperature History
            </div>";

            echo "<div class='iot-label'>
                Select Device
            </div>";

            echo "<select id='deviceSelect' class='iot-select'>";

                foreach($devices as $device){
                    echo "<option value='$device->id'>
                        $device->name
                    </option>";
                }

            echo "</select>";

            echo "<canvas id='tempChart'></canvas>";

        echo "</div>";

    echo "</div>";

    ?>

    <script>

    let tempChart = null;

    async function loadChart() {

        const deviceId = document.getElementById('deviceSelect').value;
        const response = await fetch('/wp-json/iot/v1/signals/' + deviceId);
        const data = await response.json();
        const ctx = document.getElementById('tempChart');

        if(tempChart) {
            tempChart.destroy();
        }

        tempChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels:data.labels,
                datasets: [{
                    label: 'Temperature °C',
                    data: data.values,
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color:'white'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks:{color:'white'}
                    },
                    y: {
                        ticks:{color:'white'}
                    }
                }
            }
        });

    }

    document
        .getElementById('deviceSelect')
        .addEventListener('change',loadChart);

    loadChart();

    setInterval(loadChart,5000);

    </script>

    <?php

}