<?php
include 'db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: signin_form.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION['uid'];
$sql = "SELECT points FROM user_info WHERE user_id = $user_id";
$result = mysqli_query($con, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $current_points = $row['points'];
    $_SESSION['points'] = $current_points;
} else {
    echo "Error fetching user points: " . mysqli_error($con);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spin Wheel App</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=sap" rel="stylesheet" />
    <link rel="stylesheet" href="css/spinwheel.css" />
</head>
<body>
    <div class="wrapper">
        <div id="final-value">
            <p>Points Earn: <?php echo $_SESSION['points']; ?></p>
        </div>
        <div class="container">
            <canvas id="wheel"></canvas>
            <button id="spin-button">Spin</button>
            <img src="img/arrow.png" alt="spinner arrow" />
        </div>
        <div id="result">
            <p>Click On The Spin Button To Start</p>
        </div>
        <div class="redeem-section">
            <h2>Redeem Voucher</h2>
            <form id="redeem-form">
                <select id="voucher-select" name="voucher">
                    <option value="100">RM1.00 Discount (100 points)</option>
                    <option value="200">RM2.00 Discount (200 points)</option>
                    <option value="500">RM5.00 Discount (500 points)</option>
                </select>
                <button type="button" id="redeem-button">Redeem</button>
            </form>
            <div id="redeem-message"></div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js"></script>
    <script src="js/spinwheel.js"></script>
</body>
</html>


