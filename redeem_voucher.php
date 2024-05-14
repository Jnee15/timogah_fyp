<?php
include 'db.php';
session_start();

if (!isset($_SESSION['uid'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['uid'];
$current_points = $_SESSION['points'];
$voucher_points = intval($_POST['voucher']);

if ($current_points >= $voucher_points) {
    $new_points = $current_points - $voucher_points;
    $sql_points = "UPDATE user_info SET points = $new_points WHERE user_id = $user_id";
    $sql_voucher = "INSERT INTO user_vouchers (user_id, voucher_value) VALUES ($user_id, $voucher_points)";

    if (mysqli_query($con, $sql_points) && mysqli_query($con, $sql_voucher)) {
        $_SESSION['points'] = $new_points;
        echo json_encode(['success' => true, 'message' => 'Voucher redeemed successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating points or redeeming voucher: ' . mysqli_error($con)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Insufficient points']);
}
?>
