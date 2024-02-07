@extends('layouts.app')

@section('content')
<style>
    h1.text-center {
        font-family: 'Lato', sans-serif; /* Change the font family to your desired font */
        /* Add other styling properties if needed */
    }
    
    .fade-slide-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 1.0s ease, transform 1.0s ease;
    }

    .fade-slide-in.show {
        opacity: 1;
        transform: translateY(0);
    }
    /* New class for clock text size */
    .clock-text {
        font-size: 32px; /* Adjust the font size as needed */
    }

    .card {
        position: relative;
        transform-style: preserve-3d;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }

    .card:hover {
        transform: translateY(-10px); /* Adjust the depth of the 3D effect */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Adjust the shadow properties */
    }

    /* Add this to your CSS styles */
    .good {
        color: green;
    }

    .average {
        color: yellow;
    }

    .poor {
        color: red;
    }

    .warning {
        color: red;
        animation: blink 1s infinite; /* Blinking animation */
    }

    @keyframes blink {
        50% {
            opacity: 0;
        }
    }
</style>
    <div id="liveAlertPlaceholder"></div>

    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div id="clock-container" class="mb-4 fade-slide-in">
            <p id="clock" class="clock-date clock-text"></p>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-primary dataButton" style="background-color: #3498db; color: #ffffff; border: 2px solid #2980b9;" onclick="redirectToPage('/mymap')">Choose Water Pump</button>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="card-subtitle mb-2 text-body-secondary">You Are Monitoring</h6>
                    <p id="monitoringStatus">
                        <?php
                            // Retrieve the monitoring status from the URL parameter
                            $status = isset($_GET['status']) ? $_GET['status'] : "No pump selected";
                            echo htmlspecialchars($status);
                        ?>
                    </p>
                </div>
            </div>
        </div>
        
        <script>
            function redirectToPage(map) {
                window.location.href = map;
            }
        </script>

        <h1 class="text-center mb-4 fade-slide-in">SMART WATER PUMP CONTROL AND MONITORING SYSTEMS</h1>

        <div class="row flex-grow-1">
            <div class="col-md-4">        
                <!-- Card 5 Content -->
                <div class="card mx-3 mb-4 fade-slide-in" style="width: 25rem; height: 190px; background-color: #D2E3C8;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Water Pump</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Pump Activation  : <span id="pumpactivationStatus">Loading ...</span></h6>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Manual Status    : <span id="pumpStatus">Loading ...</span></h6>

                        <!-- On/Off Button -->
                        <div class="text-center">
                            <div class="d-flex justify-content-between">
                                <p id="fuzzyPump" style="color: #008450; font-size: 20px;"></p>
                                <form action="/onrel" method="post" onsubmit="return updateStatus('PUMP ON')">
                                    <input type="submit" value="PUMP ON" class="btn btn-success">{{csrf_field()}}
                                </form>
                                <form action="/offrel" method="post" onsubmit="return updateStatus('PUMP OFF')">
                                    <input type="submit" value="PUMP OFF" class="btn btn-danger">{{csrf_field()}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card 6 Content -->
                <div class="card mx-3 mb-4 fade-slide-in" style="width: 25rem; height: 323px; background-color: #D2E3C8;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Alarm Table</h5>
                        <!-- Table for Alert Log History -->
                        <table class="table table-striped" style="border-radius: 10px; overflow: hidden;">
                        <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Date Time</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody4">
                                <!-- Data will be inserted here dynamically -->
                            </tbody>
                        </table>
                    </div> 
                </div>  
            </div>

            <div class="col-md-4">
                <!-- Card 1 Content -->
                <div class="card mx-3 mb-4 fade-slide-in" style="width: 25rem; height: 535px; background-color: #D2E3C8;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Water Level (cm)</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Status    : <span id="statuslevel" class="good">GOOD</span></h6>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Capacity  : <span id="gaugePercentage">0</span></h6>
                        <br>
                        <div style="position: absolute; top: 20%; left: 15%; width: 70%; height: 70%; background-color: #ffffff; border-radius: 30% 30% / 80% 80%; opacity: 1.0;"></div>
                        <!-- Cylinder Gauge Container -->
                        <div class="text-center">
                            <div id="chart-container" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Card 2 Content -->
                <div class="card mx-3 mb-4 fade-slide-in" style="width: 25rem; height: 190px; background-color: #D2E3C8;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Vibration</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Value   : <span id="myText3">Loading ...</span></h6>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Status  : <span id="statusvibration">Loading ...</span></h6>
                    </div>
                </div>

                <!-- Card 3 Content -->
                <div class="card mx-3 mb-4 fade-slide-in" style="width: 25rem; height: 323px; background-color: #D2E3C8;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Water Flow (mL/sec)</h5>
                        <h6 id="flowRateValue" class="card-subtitle mb-2 text-body-secondary">Value   : <span id="myText2">0</span> mL/sec</h6>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Status  : <span id="statusflow" class="good">GOOD</span></h6>
                    </div>

                    <!-- Additional div for the speedometer -->
                    <div id="chartjs2" style="height: 200px;"></div>
                </div>
            </div>
        </div>

        <footer class="footer mt-auto py-3 fade-slide-in">
            <div class="container text-center">
                <p>&copy; 2024 AquaSmart. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Include Raphael library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <!-- Include JustGage library -->
    <script src="https://cdn.jsdelivr.net/gh/toorshia/justgage@1.4.0/dist/justgage.min.js"></script>

    <script>
        const alertPlaceholder = document.getElementById('liveAlertPlaceholder')

        const appendAlert = (message, type) => {
            // Clear any existing alerts
            alertPlaceholder.innerHTML = '';

            // Create a new alert
            const wrapper = document.createElement('div')
            wrapper.innerHTML =[
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertPlaceholder.append(wrapper)
        }

        Echo.channel('FarisChannel').listen('DeviceControl', (e) => {
            console.log(e);
            appendAlert('Attention: Pump activation level is above the threshold.', 'success');
        });

        function updateClock() {
            var currentTime = new Date();
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
            var seconds = currentTime.getSeconds();

            hours = (hours < 10 ? "0" : "") + hours;
            minutes = (minutes < 10 ? "0" : "") + minutes;
            seconds = (seconds < 10 ? "0" : "") + seconds;

            var formattedTime = hours + ":" + minutes + ":" + seconds;

            var formattedDate = currentTime.toDateString();
            var combinedText = formattedTime + " | " + formattedDate;
            
            $('#clock').text(combinedText);
        }

        $(document).ready(function () {
            // Initial update
            updateClock();

            // Update every second (1000 milliseconds)
            setInterval(updateClock, 1000);

            // Add the show class to trigger the animations
            $('.fade-slide-in').addClass('show');
        });
        
        var latestWaterLevel;
        var latestWaterFlow;
        var vibrationDetected; // Move this variable to the outer scope
        var vibrationTimer = 0; // Initialize the vibration timer

        function updateStatus() {
            var statuses = [
                { class: 'good', text: 'GOOD' },
                { class: 'average', text: 'AVERAGE' },
                { class: 'poor', text: 'POOR' },
                { class: 'warning', text: 'WARNING !' }
            ];

            var statusElement = document.getElementById('statuslevel');

            // Update status based on the water level range
            if (latestWaterLevel >= 8 && latestWaterLevel <= 10) {
                statusElement.className = statuses[0].class; // 'good'
                statusElement.innerText = statuses[0].text; // 'GOOD'
            } else if (latestWaterLevel >= 4 && latestWaterLevel <= 7) {
                statusElement.className = statuses[1].class; // 'average'
                statusElement.innerText = statuses[1].text; // 'AVERAGE'
            } else if (latestWaterLevel >= 0 && latestWaterLevel <= 3) {
                statusElement.className = statuses[2].class; // 'poor'
                statusElement.innerText = statuses[2].text; // 'POOR'
            } else {
                // Handle the case when the water level is out of the defined ranges
                statusElement.className = statuses[3].class; // 'warning'
                statusElement.innerText = statuses[3].text; // 'WARNING !'
            }
        }

        function updateWaterFlowStatus() {
            var statuses = [
                { class: 'good', text: 'GOOD' },
                { class: 'average', text: 'AVERAGE' },
                { class: 'poor', text: 'POOR' },
                { class: 'warning', text: 'WARNING !' }
            ];

            var statusElement = document.getElementById('statusflow');

            // Update status based on the water flow range
            if (latestWaterFlow >= 52 && latestWaterFlow <= 60) {
                statusElement.className = statuses[0].class; // 'good'
                statusElement.innerText = statuses[0].text; // 'GOOD'
            } else if (latestWaterFlow >= 35 && latestWaterFlow <= 51) {
                statusElement.className = statuses[1].class; // 'average'
                statusElement.innerText = statuses[1].text; // 'AVERAGE'
            } else if (latestWaterFlow >= 0 && latestWaterFlow <= 34) {
                statusElement.className = statuses[2].class; // 'poor'
                statusElement.innerText = statuses[2].text; // 'POOR'
            } else {
                // Handle the case when the water flow is out of the defined ranges
                statusElement.className = statuses[3].class; // 'warning'
                statusElement.innerText = statuses[3].text; // 'WARNING !'
            }
        }

        function updateVibrationStatus() {
            var statusElement = document.getElementById('statusvibration');

            // Update status based on the vibration value
            if (vibrationDetected == 0) {
                statusElement.className = 'gray'; // 'gray'
                statusElement.innerText = 'NO VIBRATION DETECTED'; // 'NO VIBRATION DETECTED'
            } else if (vibrationDetected == 1) {
                statusElement.className = 'good'; // 'good'
                statusElement.innerText = 'VIBRATION DETECTED'; // 'VIBRATION DETECTED'
            }
        }

        $.getJSON('/route/vibrateroute', function (blocksall) {
            var datas = blocksall.blocks.map(Number);
            datas = datas.reverse();
            console.log(datas);

            // Get the latest vibration value
            vibrationDetected = datas[datas.length - 1];

            // Update the vibration status
            updateVibrationStatus();
        });

        setInterval(function() {
            $.getJSON('/route/vibrateroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log('Vibration Data:', datas);

                // Check the received data
                if (datas.length > 0) {
                    // Get the latest vibration value
                    var latestVibration = datas[datas.length - 1];

                    // Check if the vibration value has changed
                    if (latestVibration !== vibrationDetected) {
                        vibrationDetected = latestVibration;
                        vibrationTimer = 0; // Reset the vibration timer when the value changes
                    } else {
                        vibrationTimer += 1; // Increment the vibration timer if the value remains the same
                    }

                    // Update the vibration status
                    updateVibrationStatus();
                } else {
                    console.warn('No vibration data received.');
                }
            });
        }, 1000); // 60000 milliseconds = 1 minute

        $.getJSON('/route/flowroute', function (blocksall) {
            var datas = blocksall.blocks.map(Number);
            datas = datas.reverse();
            console.log(datas);

            // Get the latest water flow value
            latestWaterFlow = datas[datas.length - 1];

            // Update the water flow status
            updateWaterFlowStatus();
        });

        // Regular updates using data from the server
        setInterval(function() {
            $.getJSON('/route/flowroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log(datas);

                // Get the latest water flow value
                latestWaterFlow = datas[datas.length - 1];

                updateWaterFlowStatus();
            });
        }, 1000);

        $.getJSON('/route/levelroute', function (blocksall) {
            var datas = blocksall.blocks.map(Number);
            datas = datas.reverse();
            console.log(datas);

            // Get the latest water level value
            latestWaterLevel = datas[datas.length - 1];

            // Update the FusionChart with the latest water level
            updateFuelMeterWithData(latestWaterLevel);

            // Update the water level status
            updateStatus();

            // Regular updates using data from the server
            setInterval(function() {
                $.getJSON('/route/levelroute', function (blocksall) {
                    var datas = blocksall.blocks.map(Number);
                    datas = datas.reverse();
                    console.log(datas);

                    // Get the latest water level value
                    latestWaterLevel = datas[datas.length - 1];

                    // Update the FusionChart with the latest water level
                    updateFuelMeterWithData(latestWaterLevel);

                    // Update the water level status
                    updateStatus();
                });
            }, 1000);
        });

        const waterFlowSpeedometer = new JustGage({
            id: "chartjs2",
            value: 0, // Initial value
            min: 0,
            max: 60,
            title: "Flow Rate",
            label: "mL/sec",
            levelColors: ["#ff0000", "#ffa500", "#00ff00"],
            gaugeWidthScale: 0.6,
            counter: true,
            relativeGaugeSize: true,
            valueFontColor: "#333",
            gaugeColor: "#DED0B6",
            titleFontColor: "#333",
            labelFontColor: "#333",
            valueFontColor: "#333",
            valueFontFamily: "Arial, sans-serif",
            titleFontFamily: "Arial, sans-serif",
            labelFontFamily: "Arial, sans-serif",
            pointer: true,
            pointerOptions: {
                toplength: -15,
                bottomlength: 10,
                bottomwidth: 12,
                color: "#333",
            },
        });
        
        FusionCharts.ready(function(){
            var fuelVolume = 10,
                fuelWidget = new FusionCharts({
                type: 'cylinder',
                dataFormat: 'json',
                id: 'fuelMeter',
                renderAt: 'chart-container',
                width: '200',
                height: '350',
                dataSource: {
                    "chart": {
                    "theme": "fusion", // optional design
                    "lowerLimit": "0",
                    "upperLimit": "10",
                    "lowerLimitDisplay": "Empty",
                    "upperLimitDisplay": "Full",
                    "numberSuffix": " cm",
                    "showValue": "1",
                    "chartBottomMargin": "45",
                    "showValue": "0",
                    "cylFillColor": "#3498db", // Set the water color
                    }
                },
                "events": {
                    "rendered": function(evtObj, argObj) {
                        // Initial update with data from the server
                        $.getJSON('/route/levelroute', function (blocksall) {
                            var datas = blocksall.blocks.map(Number);
                            datas = datas.reverse();
                            console.log(datas);

                            // Get the latest water level value
                            var latestWaterLevel = datas[datas.length - 1];

                            // Update the FusionChart with the latest water level
                            updateFuelMeterWithData(latestWaterLevel);
                        
                            // Update the water level status
                            updateStatus();
                        });

                        // Regular updates using data from the server
                        setInterval(function() {
                            $.getJSON('/route/levelroute', function (blocksall) {
                                var datas = blocksall.blocks.map(Number);
                                datas = datas.reverse();
                                console.log(datas);

                                // Get the latest water level value
                                var latestWaterLevel = datas[datas.length - 1];

                                // Update the FusionChart with the latest water level
                                updateFuelMeterWithData(latestWaterLevel);
                                
                                // Update the water level status
                                updateStatus();
                            });
                        }, 1000);
                    },
                    //Using real time update event to update the annotation 
                    //showing available volume of Diesel
                    "realTimeUpdateComplete": function(evt, arg) {
                        var annotations = evt.sender.annotations,
                            dataVal = evt.sender.getData(),
                            colorVal = (dataVal >= 70) ? "#6caa03" : ((dataVal <= 35) ? "#e44b02" : "#f8bd1b");

                        // Updating value in the Capacity status
                        $('#gaugePercentage').text(dataVal);

                        // Updating value in the annotations
                        annotations && annotations.update('rangeText', {
                            "text": dataVal + " %"
                        });

                        // Changing background color as per value
                        annotations && annotations.update('rangeBg', {
                            "fillcolor": colorVal
                        });
                    }
                }
                }).render();
            });

            // Function to update the FusionChart with the latest water level
            function updateFuelMeterWithData(data) {
                var consVolume = parseFloat(data.toFixed(2));

                // Ensure consVolume doesn't go below the lower limit
                consVolume = Math.max(consVolume, 0);
                // Ensure consVolume doesn't exceed the upper limit
                consVolume = Math.min(consVolume, 100);

                FusionCharts("fuelMeter").feedData("&value=" + consVolume);
                fuelVolume = consVolume;
            }

        setInterval(ajaxCall, 1000);
        function ajaxCall() {
            $.getJSON('/route/levelroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log(datas);

                var datasx = blocksall.blocks2.map(String);
                datasx = datasx.reverse();
                console.log(datasx);
            });

            $.getJSON('/route/flowroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log(datas);

                var datasx = blocksall.blocks2.map(String);
                datasx = datasx.reverse();
                console.log(datasx);

                document.getElementById("myText2").innerHTML = datas[datas.length - 1].toFixed(2);
                // Update the value of the JustGage instance
                waterFlowSpeedometer.refresh(datas[datas.length - 1].toFixed(2));
            });

            $.getJSON('/route/vibrateroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log(datas);

                var datasx = blocksall.blocks2.map(String);
                datasx = datasx.reverse();
                console.log(datasx);

                document.getElementById("myText3").innerHTML = datas[datas.length - 1].toFixed(2);
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

            Echo.channel('FarisChannel').listen('DeviceControl',(e) =>{
                console.log(e)
                if(e['status']== 1){
                    document.getElementById("pumpStatus").innerHTML = "PUMP ON";
                    document.getElementById("pumpStatus").style.color = "green";
                }else{
                    document.getElementById("pumpStatus").innerHTML = "PUMP OFF";
                    document.getElementById("pumpStatus").style.color = "red";
                }
            });

            Echo.channel('FarisChannel').listen('DeviceControlAi',(e) =>{
                console.log(e)
                if(e['status1']== 1){
                    document.getElementById("pumpactivationStatus").innerHTML = "PUMP ON";
                    document.getElementById("pumpactivationStatus").style.color = "green";
                }else{
                    document.getElementById("pumpactivationStatus").innerHTML = "PUMP OFF";
                    document.getElementById("pumpactivationStatus").style.color = "red";
                }
            });
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
