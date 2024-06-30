<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signal Lights</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .traffic-light {
            width: 100px;
            height: 300px;
            background-color: #333;
            border-radius: 20px;
            padding: 10px;
        }
        .light {
            width: 80px;
            height: 80px;
            background-color: #555;
            border-radius: 50%;
            margin: 10px auto;
        }
        .light.green { background-color: green; }
        .light.yellow { background-color: yellow; }
        .light.red { background-color: red; }
        .light.off { background-color: #555; }
    </style>
</head>
<body>
    <h1>Signal Lights Control</h1>
    <form id="signalForm">
        <label for="sequence">Sequence (e.g., A-B-C-D):</label>
        <input type="text" id="sequence" name="sequence"><br>

        <label for="green_interval">Green Interval (seconds):</label>
        <input type="number" id="green_interval" name="green_interval"><br>

        <label for="yellow_interval">Yellow Interval (seconds):</label>
        <input type="number" id="yellow_interval" name="yellow_interval"><br>

        <button type="button" id="startButton">Start</button>
        <button type="button" id="stopButton">Stop</button>
    </form>

    <div id="message"></div>

    <div class="traffic-light">
        <div id="lightA" class="light off"></div>
        <div id="lightB" class="light off"></div>
        <div id="lightC" class="light off"></div>
        <div id="lightD" class="light off"></div>
    </div>

    <script>
        let interval;
        let sequence;
        let greenInterval;
        let yellowInterval;
        let currentIndex = 0;

        $(document).ready(function() {
            $('#startButton').on('click', function() {
                $.ajax({
                    url: '<?= base_url("start_signal") ?>',
                    type: 'POST',
                    data: $('#signalForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if(response.success) {
                            $('#message').html(response.success);
                            sequence = $('#sequence').val().split('-');
                            greenInterval = parseInt($('#green_interval').val()) * 1000;
                            yellowInterval = parseInt($('#yellow_interval').val()) * 1000;
                            startTrafficLight();
                        } else {
                            $('#message').html(response.error);
                        }
                    }
                });
            });

            $('#stopButton').on('click', function() {
                $.ajax({
                    url: '<?= base_url("stop_signal") ?>',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        $('#message').html(response.success);
                        stopTrafficLight();
                    }
                });
            });
        });

        function startTrafficLight() {
            currentIndex = 0;

            interval = setInterval(function() {
                // Turn off all lights
                $('.light').addClass('off').removeClass('green yellow red');

                // Get the current light ID
                let currentLightId = 'light' + sequence[currentIndex].toUpperCase().trim();

                // Add the correct color class to the current light
                $('#' + currentLightId).removeClass('off').addClass('green');

                setTimeout(function() {
                    $('#' + currentLightId).removeClass('green').addClass('yellow');
                }, greenInterval);

                setTimeout(function() {
                    $('#' + currentLightId).removeClass('yellow').addClass('red');
                }, greenInterval + yellowInterval);

                currentIndex = (currentIndex + 1) % sequence.length;
            }, greenInterval + yellowInterval + greenInterval);
        }

        function stopTrafficLight() {
            clearInterval(interval);
            $('.light').addClass('off').removeClass('green yellow red');
        }
    </script>
</body>
</html>
