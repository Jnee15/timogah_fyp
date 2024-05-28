<?php
include 'db.php';
session_start();

if (!isset($_SESSION['uid'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['uid'];
$sql_user_vouchers = "SELECT voucher_discount FROM user_vouchers WHERE user_id = $user_id";
$result_user_vouchers = mysqli_query($con, $sql_user_vouchers);
$vouchers = [];

if ($result_user_vouchers && mysqli_num_rows($result_user_vouchers) > 0) {
    while ($row_user_vouchers = mysqli_fetch_assoc($result_user_vouchers)) {
        $vouchers[] = ['discount' => $row_user_vouchers['voucher_discount']];
    }
}

echo json_encode(['success' => true, 'vouchers' => $vouchers]);
?>
