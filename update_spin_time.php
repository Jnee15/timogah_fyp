<?php
include "db.php";
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['uid'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['uid'];

// Decode the JSON payload from the POST request
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);
$pointsEarned = $data['points'];

if ($pointsEarned === null) {
    echo json_encode(['success' => false, 'error' => 'Invalid points value']);
    exit();
}

// Use prepared statements to prevent SQL injection
$sql = "SELECT last_spin, points FROM user_info WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $last_spin = $row['last_spin'];
        $current_points = $row['points'];
        $current_date = new DateTime();

        if ($last_spin) {
            $last_spin_date = new DateTime($last_spin);
            if ($last_spin_date->format('Y-m-d') == $current_date->format('Y-m-d')) {
                echo json_encode(['success' => false, 'error' => 'You have already spun the wheel today. Come back tomorrow!']);
                $stmt->close();
                $con->close();
                exit();
            }
        }

        // Update the last_spin time and points using a prepared statement
        $new_points = $current_points + $pointsEarned;
        $sql_update = "UPDATE user_info SET last_spin = NOW(), points = ? WHERE user_id = ?";
        $stmt_update = $con->prepare($sql_update);
        $stmt_update->bind_param('ii', $new_points, $user_id);

        if ($stmt_update->execute()) {
            echo json_encode(['success' => true, 'points' => $new_points]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error updating spin time and points.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Error fetching last spin time.']);
}

$stmt->close();
if (isset($stmt_update)) {
    $stmt_update->close();
}
$con->close();
?>
