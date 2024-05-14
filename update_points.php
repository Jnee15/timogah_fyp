<?php
include 'db.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);
$new_points = $data['points'];
$user_id = $_SESSION['uid'];

$sql = "UPDATE user_info SET points = $new_points WHERE user_id = $user_id";

if (mysqli_query($con, $sql)) {
    $_SESSION['points'] = $new_points;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating points: ' . mysqli_error($con)]);
}
?>
