@extends('layouts.app')

@section('content')
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <!-- Your existing content goes here -->

    <!-- Add the three cards -->
    <div class="card">
        <div class="card-header">
            Water Level
        </div>
        <div class="card-body">
            <canvas id="waterLevelChart" width="400" height="200"></canvas>
            <table class="table">
                <!-- Table headers -->
                <thead>
                    <tr>
                        <th>Value</th>
                        <th>Date Time</th>
                    </tr>
                </thead>
                <!-- Table body will be populated dynamically using JavaScript -->
                <tbody id="dataTableBody1"></tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Water Flow
        </div>
        <div class="card-body">
            <canvas id="waterFlowChart" width="400" height="200"></canvas>
            <table class="table">
                <!-- Table headers -->
                <thead>
                    <tr>
                        <th>Value</th>
                        <th>Date Time</th>
                    </tr>
                </thead>
                <!-- Table body will be populated dynamically using JavaScript -->
                <tbody id="dataTableBody2"></tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Vibration
        </div>
        <div class="card-body">
            <canvas id="vibrationChart" width="400" height="200"></canvas>
            <table class="table">
                <!-- Table headers -->
                <thead>
                    <tr>
                        <th>Value</th>
                        <th>Date Time</th>
                    </tr>
                </thead>
                <!-- Table body will be populated dynamically using JavaScript -->
                <tbody id="dataTableBody3"></tbody>
            </table>
        </div>
    </div>

    <!-- Your existing content goes here -->

    <!-- Add JavaScript to populate charts and tables -->
    <script>
    setInterval(ajaxCall, 5000);
        function ajaxCall() {
            $.getJSON('/route/levelroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log(datas);

                var datasx = blocksall.blocks2.map(String);
                datasx = datasx.reverse();
                console.log(datasx);

                updateTable1(datas, datasx);

                var chart = new Chart(document.getElementById('waterLevelChart'), {
                    type: 'line',  // Change the chart type to 'line'
                    data: {
                        labels: datasx, // Use the reversed labels obtained from the API
                        datasets: [{
                            label: 'Data from Ultrasonic Sensor',
                            data: datas, // Use the reversed data obtained from the API
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date Time',
                                    color: 'rgba(255, 255, 255, 1)' // Set x-axis title text color
                                },
                                ticks: {
                                    color: 'rgba(255, 255, 255, 1)' // Set x-axis tick text color
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Water Level (cm)',
                                    color: 'rgba(255, 255, 255, 1)' // Set y-axis title text color
                                },
                                ticks: {
                                    color: 'rgba(255, 255, 255, 1)' // Set y-axis tick text color
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'rgba(255, 255, 255, 1)' // Set legend text color
                                }
                            }
                        }
                        // Add any other options you need to customize the chart
                    }
                });
            });

            $.getJSON('/route/flowroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log(datas);

                var datasx = blocksall.blocks2.map(String);
                datasx = datasx.reverse();
                console.log(datasx);

                updateTable2(datas, datasx); 
                
                var chart = new Chart(document.getElementById('waterFlowChart'), {
                    type: 'line',  // Change the chart type to 'line'
                    data: {
                        labels: datasx, // Use the reversed labels obtained from the API
                        datasets: [{
                            label: 'Data from YF-S401 Sensor',
                            data: datas, // Use the reversed data obtained from the API
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date Time',
                                    color: 'rgba(255, 255, 255, 1)' // Set x-axis title text color
                                },
                                ticks: {
                                    color: 'rgba(255, 255, 255, 1)' // Set x-axis tick text color
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Water Flow (mL/sec)',
                                    color: 'rgba(255, 255, 255, 1)' // Set y-axis title text color
                                },
                                ticks: {
                                    color: 'rgba(255, 255, 255, 1)' // Set y-axis tick text color
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'rgba(255, 255, 255, 1)' // Set legend text color
                                }
                            }
                        }
                        // Add any other options you need to customize the chart
                    }
                });
            });

            $.getJSON('/route/vibrateroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log(datas);

                var datasx = blocksall.blocks2.map(String);
                datasx = datasx.reverse();
                console.log(datasx);

                updateTable3(datas, datasx); 

                var chart = new Chart(document.getElementById('vibrationChart'), {
                type: 'line',  // Change the chart type to 'line'
                    data: {
                        labels: datasx, // Use the reversed labels obtained from the API
                        datasets: [{
                            label: 'Data from Accelerometer Sensor',
                            data: datas, // Use the reversed data obtained from the API
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date Time',
                                    color: 'rgba(255, 255, 255, 1)' // Set x-axis title text color
                                },
                                ticks: {
                                    color: 'rgba(255, 255, 255, 1)' // Set x-axis tick text color
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Vibration ()',
                                    color: 'rgba(255, 255, 255, 1)' // Set y-axis title text color
                                },
                                ticks: {
                                    color: 'rgba(255, 255, 255, 1)' // Set y-axis tick text color
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'rgba(255, 255, 255, 1)' // Set legend text color
                                }
                            }
                        }
                        // Add any other options you need to customize the chart
                    }
                });
            });
        }

        // Create separate functions for each sensor type
        function updateTable1(values, dateTimes) {
            var tableBody = $('#dataTableBody1');
            tableBody.empty(); // Clear previous data

            for (var i = 0; i < Math.min(values.length, dateTimes.length); i++) {
                // Format value to two decimal points
                var formattedValue = Number(values[i]).toFixed(2);

                var row = '<tr><td>' + formattedValue + '</td><td>' + dateTimes[i] + '</td></tr>';
                tableBody.append(row);
            }
        }

        // Repeat the above function for other sensor types (humidity and water level)
        function updateTable2(values, dateTimes) {
            var tableBody = $('#dataTableBody2');
            tableBody.empty();

            for (var i = 0; i < Math.min(values.length, dateTimes.length); i++) {
                var formattedValue = Number(values[i]).toFixed(2);

                var row = '<tr><td>' + formattedValue + '</td><td>' + dateTimes[i] + '</td></tr>';
                tableBody.append(row);
            }
        }

        function updateTable3(values, dateTimes) {
            var tableBody = $('#dataTableBody3');
            tableBody.empty();

            for (var i = 0; i < Math.min(values.length, dateTimes.length); i++) {
                var formattedValue = Number(values[i]).toFixed(2);

                var row = '<tr><td>' + formattedValue + '</td><td>' + dateTimes[i] + '</td></tr>';
                tableBody.append(row);
            }
        }
    </script>
@endsection
