<?php
include "db.php";
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: signin_form.php");
    exit();
}

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
    <title>Spinwheel</title>
    <link rel="icon" sizes="76x76" href="img/spinwheel.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=sap" rel="stylesheet" />
    <link rel="stylesheet" href="css/spinwheel.css" />
</head>

<body>
    <div class="page-wrapper">
        <div class="spinwheel-container">
            <a href="index.php" style="text-align: left; vertical-align: top; text-decoration: none; font-size:30px;">&#11013;</a>
            <div id="final-value">
                <p>Points Earn: <?php echo $_SESSION['points']; ?></p>
            </div>
            <br>
            <div id="result" style="text-align: center;">
                <p>Click On The Spin Button To Start</p>
            </div>
            <br>
            <div class="container">
                <canvas id="wheel"></canvas>
                <button id="spin-button">Spin</button>
                <img src="img/arrow.png" alt="spinner arrow" />
            </div>
        </div>

        <div class="voucher-container">
            <div id="store">
                <p>Voucher Store</p>
            </div>
            <br>
                <div class="container">
                    <div class="redeem-section">
                        <h3>Redeem Voucher</h3>
                        <form id="redeem-form">
                            <select id="voucher-select" name="voucher">
                                <option value="100">RM1.00 Discount (100 points)</option>
                                <option value="200">RM2.00 Discount (200 points)</option>
                                <option value="300">RM3.00 Discount (300 points)</option>
                            </select>
                            <button type="button" id="redeem-button">Redeem</button>
                        </form>
                        <div id="redeem-message"></div>
                        <br>
                    </div>
                    <h3>Your Vouchers</h3>
                        <ul id="voucher-list">
                            <?php
                            $sql_user_vouchers = "SELECT voucher_discount FROM user_vouchers WHERE user_id = $user_id";
                            $result_user_vouchers = mysqli_query($con, $sql_user_vouchers);
                            if ($result_user_vouchers && mysqli_num_rows($result_user_vouchers) > 0) {
                                while ($row_user_vouchers = mysqli_fetch_assoc($result_user_vouchers)) {
                                    $voucher_discount = $row_user_vouchers['voucher_discount'];
                                    echo "<li>RM" . ($voucher_discount) . " Discount</li>";
                                }
                            } else {
                                echo "<li>No vouchers redeemed yet.</li>";
                            }
                            ?>
                        </ul>
                    <a id="back-to-home" href="index.php">Continue Shopping</a>
                </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js"></script>
    <script src="js/spinwheel.js"></script>
</body>
</html>
