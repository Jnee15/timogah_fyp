<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spin Wheel App</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=sap" rel="stylesheet" />
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/spinwheel.css" />
</head>
<body>
    <div class="wrapper">
        <div id="final-value">
            <p>Points : 0</p>
        </div>
        <div class="container">
            <canvas id="wheel"></canvas>
            <button id="spin-button">Spin</button>
            <img src="img/arrow.png" alt="spinner arrow" />
        </div>
        <div id="final-value">
            <p>Click On The Spin Button To Start</p>
        </div>
        
    </div>
    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <!-- Chart JS Plugin for displaying text over chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js"></script>
    <!-- Script -->
    <script src="js/spinwheel.js"></script>
</body>
</html>
