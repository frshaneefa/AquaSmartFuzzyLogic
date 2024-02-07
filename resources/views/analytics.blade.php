@extends('layouts.app')

@section('content')
<style>
    .card {
        position: relative !important;
        transform-style: preserve-3d !important;
        transition: transform 0.5s ease, box-shadow 0.5s ease !important;
    }

    .card:hover {
        transform: translateY(-10px) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
    }

    
    .center-card {
        margin-bottom: 1rem;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s, transform 0.5s;
        color: #163020; /* Set the text color */
    }

    .center-container {
        padding: 1rem;
    }

    .card-1 {
        background-color: #D5F0C1 !important;
    }

    .card-2 {
        background-color: #D5F0C1 !important; /* Adjust the color for card 2 */
    }

    .card-3 {
        background-color: #D5F0C1 !important; /* Adjust the color for card 3 */
    }

    .rounded-table {
        border-radius: 10px; /* Adjust the border-radius value as needed */
        overflow: hidden;
        background-color: #e0f7fa !important;
    }

    .rounded-table table {
        background-color: #e0f7fa; /* Set your desired background color */
    }

    .table-container {
        padding-right: 20px; /* Adjust the padding-right value as needed */
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get all elements with the class 'center-card'
        var cards = document.querySelectorAll('.center-card');

        // Loop through each card and add the 'show' class after a delay
        cards.forEach(function(card, index) {
            setTimeout(function() {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 300); // Adjust the delay between each card
        });
    });
</script>

<div class="container center-container">
<h1 class="text-center mb-4 fade-slide-in">AQUASMART DATA LOG HISTORY</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3 w-100 center-card card-1">
                <div class="card-header text-center">WATER LEVEL (cm)</div>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="chart-js1"></canvas>
                    </div>
                    <div class="col-md-4">
                        <table class="table rounded-table">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Date Time</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody1">
                                <!-- Data will be inserted here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mb-3 w-100 center-card card-2">
                <div class="card-header text-center">WATER FLOW (mL/sec)</div>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="chartjs2"></canvas>
                    </div>
                    <div class="col-md-4">
                        <table class="table rounded-table">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Date Time</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody2">
                                <!-- Data will be inserted here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mb-3 w-100 center-card card-3">
                <div class="card-header text-center">VIBRATION (HZ)</div>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="chartjs3"></canvas>
                    </div>
                    <div class="col-md-4">
                        <table class="table rounded-table">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Date Time</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody3">
                                <!-- Data will be inserted here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-3 fade-slide-in">
    <div class="container text-center">
        <p>&copy; 2024 AquaSmart. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

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

                var chart = new Chart(document.getElementById('chart-js1'), {
                    type: 'line',  // Change the chart type to 'line'
                    data: {
                        labels: datasx, // Use the reversed labels obtained from the API
                        datasets: [{
                            label: 'Data from Ultrasonic Sensor',
                            data: datas, // Use the reversed data obtained from the API
                            fill: {
                                target: 'origin', // Use 'origin' to fill below the line
                                above: 'rgba(75, 192, 192, 0.2)', // Color for the area above the line
                                below: 'rgba(255, 181, 52, 1)' // Color for the area below the line
                            },
                            borderColor: 'rgba(48, 77, 48, 1)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date Time',
                                    color: 'rgba(255, 255, 255, 1)' // Set x-axis title text color to white
                                },
                                ticks: {
                                    color: 'rgba(255, 255, 255, 1)' // Set x-axis tick text color to white
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
                            },
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
                
                var chart = new Chart(document.getElementById('chartjs2'), {
                    type: 'line',  // Change the chart type to 'line'
                    data: {
                        labels: datasx, // Use the reversed labels obtained from the API
                        datasets: [{
                            label: 'Data from YF-S401 Sensor',
                            data: datas, // Use the reversed data obtained from the API
                            fill: false,
                            borderColor: 'rgba(48, 77, 48, 1)',
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

                var chart = new Chart(document.getElementById('chartjs3'), {
                type: 'line',  // Change the chart type to 'line'
                    data: {
                        labels: datasx, // Use the reversed labels obtained from the API
                        datasets: [{
                            label: 'Data from Accelerometer Sensor',
                            data: datas, // Use the reversed data obtained from the API
                            fill: false,
                            borderColor: 'rgba(48, 77, 48, 1)',
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

            $.getJSON('/route/alarmstatroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log(datas);

                var datasx = blocksall.blocks2.map(String);
                datasx = datasx.reverse();
                console.log(datasx);

                updateTable4(datas, datasx); 
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

        function updateTable4(values, dateTimes) {
            var tableBody = $('#dataTableBody4');
            tableBody.empty();

            for (var i = 0; i < Math.min(values.length, dateTimes.length); i++) {
                var formattedValue = Number(values[i]).toFixed(2);

                var row = '<tr><td>' + formattedValue + '</td><td>' + dateTimes[i] + '</td></tr>';
                tableBody.append(row);
            }
        }
</script>

@endsection
