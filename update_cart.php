<?php
session_start();
include "db.php";

if (isset($_POST['cart_item_id']) && isset($_POST['qty']) && isset($_POST['total'])) {
    $cart_item_id = $_POST['cart_item_id'];
    $qty = $_POST['qty'];
    $total = $_POST['total'];

    $sql = "UPDATE cart SET qty = ?, subtotal = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("idi", $qty, $total, $cart_item_id);

    if ($stmt->execute()) {
        echo "Cart updated successfully.";
    } else {
        echo "Error updating cart: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Required parameters are missing.";
}
$con->close();
?>
