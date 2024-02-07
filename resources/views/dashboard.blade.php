@extends('layouts.app')
@section('content')

<style>

    body {
        font-family: 'Nunito', sans-serif;
        background-color: #e0f7fa; /* Light Blue - Background Color */
        color: #37474f; /* Dark Blue - Text Color */
        text-align: center; /* Center-align text */
        overflow: auto; /* Enable both horizontal and vertical scroll */
    }

    .center-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width: 100%; /* Set width to 100% for full-width responsiveness */
    }

    h1 {
        color: #00796b; /* Teal - Header Color */
        margin-bottom: 1rem;
    }

    .grid-container {
        display: grid;
        grid-gap: 10px;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        justify-content: center;
    }

    @media only screen and (max-width: 865px) {
        .grid-container {
            grid-template-columns: 1fr;
        }
    }

    @media only screen and (max-width: 614px) {
        .grid-container {
            grid-template-columns: 100%;
        }

        .grid-item {
            grid-row-start: initial !important;
            grid-row-end: initial !important;
            grid-column-start: initial !important;
            grid-column-end: initial !important;
        }
    }

    .grid-item {
        width: 100%;
        height: 100%;
    }

    .itemChart1{
        grid-row-start: 1;
        grid-row-end: 4;
        grid-column-start: 1;
        grid-column-end: 3;
        text-align: center;
    }

    .itemChart2{
        grid-row-start: 1;
        grid-row-end: 4;
        grid-column-start: 3;
        grid-column-end: 5;
        text-align: center;
    }

    .itemChart3{
        grid-row-start: 1;
        grid-row-end: 4;
        grid-column-start: 5;
        grid-column-end: 7;
        text-align: center;
    }

    .itemButton1{
        grid-row-start: 4;
        grid-row-end: 7;
        grid-column-start: 5;
        grid-column-end: 7;
        text-align: center;
    }

    .card {
        background-color: #ffffff; /* White - Card Background Color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Card Shadow */
        margin: 1rem; /* Adjust margin as needed */
        border-radius: 0.5rem; /* Card Border Radius */
    }

    .card-header {
        background-color: #004d40; /* Dark Teal - Card Header Background Color */
        color: #ffffff; /* White - Card Header Text Color */
        padding: 0.5rem; /* Card Header Padding */
        border-top-left-radius: 0.5rem; /* Adjust as needed */
        border-top-right-radius: 0.5rem; /* Adjust as needed */
    }

    .list-group {
        border: none; /* Remove border from list group inside the card */
    }

</style>

<body>
<div id="liveAlertPlaceholder"></div>

<h3>SMART WATER PUMP CONTROL AND MONITORING SYSTEM</h3>

<div class="container-fluid">
    <div class="dashboard">
        <div class="grid-container">
            <!-- Water Level -->
            <div class="grid-item itemChart1">
                <div class="card">
                    <div class="card-header">
                        Water Level :<span id="myText1"></span>
                    </div>

                    <ul class="list-group list-group-flush">
                        <canvas id="chartjs1" class="chartjs" style="position: relative; height:40vh; width:40vw"></canvas>
                    </ul>

                    <table border="1">
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

            <!-- Water Flow -->
            <div class="grid-item itemChart2">
                <div class="card">
                    <div class="card-header">
                        Water Flow :<span id="myText2"></span>
                    </div>

                    <ul class="list-group list-group-flush">
                        <canvas id="chartjs2" class="chartjs" style="position: relative; height:40vh; width:40vw"></canvas>
                    </ul>

                    <table border="1">
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

            <!-- Vibration -->
            <div class="grid-item itemChart3">
                <div class="card">
                    <div class="card-header">
                        Vibration :<span id="myText3"></span>
                    </div>

                    <ul class="list-group list-group-flush">
                        <canvas id="chartjs3" class="chartjs" style="position: relative; height:40vh; width:40vw"></canvas>
                    </ul>

                    <table border="1">
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

            <!-- Alarm Stat -->
            <div class="grid-item itemChart5">
                <div class="card">
                    <div class="card-header">
                        Alarm Status
                    </div>
                    <table border="1">
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

            <!-- Button -->
            <div class="grid-item itemButton1">
                <div class="card">
                    <div class="card-header">
                        Water Pump
                    </div>
                    <div class="d-flex justify-content-between">
                        <p id="alarmStatus">Status:</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p id="fuzzyPump" style="color: #008450; font-size: 20px;"></p>
                        <form action="/onrel" method="post">
                                <input type="submit" value="PUMP ON" class="btn btn-success">{{csrf_field()}}</form>
                        <form action="/offrel" method="post">
                                <input type="submit" value="PUMP OFF" class="btn btn-danger">{{csrf_field()}}</form>
                    </div>
                

                <script>
                    function updateStatus(status) {
                        document.getElementById("statusDisplay").innerText = "Status: " + status;
                    }
                </script>
            </div>
        </div>
    </div>
</div>

<script>
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

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

    setInterval(ajaxCall, 5000);
        function ajaxCall() {
            $.getJSON('/route/levelroute', function (blocksall) {
                var datas = blocksall.blocks.map(Number);
                datas = datas.reverse();
                console.log(datas);

                var datasx = blocksall.blocks2.map(String);
                datasx = datasx.reverse();
                console.log(datasx);

                document.getElementById("myText1").innerHTML = datas[datas.length -1].toFixed(2);
                updateTable1(datas, datasx);

                if (datas[datas.length - 1] >= 70) {
                document.getElementById("myText1").innerHTML = datas[datas.length - 1];
                document.getElementById("myText1").style.color = "green";
                } else {
                    document.getElementById("myText1").innerHTML = "offline";
                    document.getElementById("myText1").style.color = "red";
                }

                var chart = new Chart(document.getElementById('chartjs1'), {
                    type:'gauge',
                    data: {
                        datasets: [{
                        value: datas[datas.length - 1].toFixed(2),
                        minValue: 0,
                        data: [300, 700, 1000],
                        backgroundColor: ['red', 'yellow', 'green'],
                        }]
                    },
                    options: {
                        needle: {
                        radiusPercentage: 2,
                        widthPercentage: 3.2,
                        lengthPercentage: 80,
                        color: 'rgba(0, 0, 0, 1)'
                        },
                        animation:{
                        duration:10,
                        easing: 'easeOutBounce'
                        },
                        valueLabel: {
                        display: true,
                        formatter: (value) => {
                            return 'value:' + Math.round(value);
                        },
                        color: 'rgba(255, 255, 255, 1)',
                        backgroundColor: 'rgba(0, 0, 0, 1)',
                        borderRadius: 5,
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                        }
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

                document.getElementById("myText2").innerHTML = datas[datas.length -1].toFixed(2);
                updateTable2(datas, datasx); 

                if (datas[datas.length - 1] !== 0) {
                    document.getElementById("myText2").innerHTML = datas[datas.length - 1];
                    document.getElementById("myText2").style.color = "green";
                } else {
                    document.getElementById("myText2").innerHTML = "offline";
                    document.getElementById("myText2").style.color = "red";
                }
                
                var chart = new Chart(document.getElementById('chartjs2'), {
                    type: 'gauge',
                    data: {
                        datasets: [{
                        value: datas[datas.length - 1].toFixed(2),
                        minValue: 0,
                        data: [30, 70, 100],
                        backgroundColor: ['red', 'yellow', 'green'],
                        }]
                    },
                    options: {
                        needle: {
                        radiusPercentage: 2,
                        widthPercentage: 3.2,
                        lengthPercentage: 80,
                        color: 'rgba(0, 0, 0, 1)'
                        },
                        animation:{
                        duration:10,
                        easing: 'easeOutBounce'
                        },
                        valueLabel: {
                        display: true,
                        formatter: (value) => {
                            return 'value:' + Math.round(value);
                        },
                        color: 'rgba(255, 255, 255, 1)',
                        backgroundColor: 'rgba(0, 0, 0, 1)',
                        borderRadius: 5,
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                        }
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

                document.getElementById("myText3").innerHTML = datas[datas.length -1].toFixed(2);
                updateTable3(datas, datasx); 

                first = new Date(datasx[datasx.length - 1]); // Get the first date epoch object
                // document. write( (first. getTime())/1000); // get the actual epoch values
                second = new Date(); // Get the first date epoch object
                // document. write((second getTime))/1000); // get the actual epoch values
                diff = second.getTime() - first.getTime() ;
                console.log(diff);

                if (diff < 5000) {
                    document.getElementById ("myText3").innerHTML = datas[datas.length -1];
                    document.getElementById("myText3").style. color="green";
                }else{
                    document .getElementById("myText3"). innerHTML="offline";
                    document.getElementById ("myText3").style.color="red";
                }
                var chart = new Chart(document.getElementById('chartjs3'), {
                type: 'gauge',
                data: {
                    datasets: [{
                    value: datas[datas.length - 1].toFixed(2),
                    minValue: 0,
                    data: [3.0, 7.0, 10.0],
                    backgroundColor: ['red', 'yellow', 'green'],
                    }]
                },
                options: {
                    needle: {
                    radiusPercentage: 2,
                    widthPercentage: 3.2,
                    lengthPercentage: 80,
                    color: 'rgba(0, 0, 0, 1)'
                    },
                    animation:{
                    duration:10,
                    easing: 'easeOutBounce'
                    },
                    valueLabel: {
                    display: true,
                    formatter: (value) => {
                        return 'value:' + Math.round(value);
                    },
                    color: 'rgba(255, 255, 255, 1)',
                    backgroundColor: 'rgba(0, 0, 0, 1)',
                    borderRadius: 5,
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                    }
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