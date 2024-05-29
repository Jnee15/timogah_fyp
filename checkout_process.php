<?php
session_start();
include "db.php";
if (isset($_SESSION["uid"])) {
    $f_name = $_POST["firstname"];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardNumber'];
    $expdate = $_POST['expdate'];
    $cvv = $_POST['cvv'];
    $user_id = $_SESSION["uid"];
    $cardnumberstr = (string)$cardnumber;
    $total_count = $_POST['total_count'];
    $prod_total = $_POST['total_price'];
    $voucher_dis = $_POST['voucher_discount'];  
    $voucher_id = $_POST['voucher_id']; 
    
    $sql0 = "SELECT order_id from `orders_info`";
    $runquery = mysqli_query($con, $sql0);
    if (mysqli_num_rows($runquery) == 0) {
        echo(mysqli_error($con));
        $order_id = 1;
    } else if (mysqli_num_rows($runquery) > 0) {
        $sql2 = "SELECT MAX(order_id) AS max_val from `orders_info`";
        $runquery1 = mysqli_query($con, $sql2);
        $row = mysqli_fetch_array($runquery1);
        $order_id = $row["max_val"] + 1;
        echo(mysqli_error($con));
    }

    // Update the total amount after applying voucher discount
    $total_after_discount = $prod_total - $voucher_dis;
    if ($total_after_discount < 0) {
        $total_after_discount = 0;
    }

    $sql = "INSERT INTO `orders_info` 
    (`order_id`, `user_id`, `f_name`, `email`, `address`, `city`, `state`, `zip`, 
    `cardname`, `cardnumber`, `expdate`, `cvv`, `voucher_dis`, `prod_count`, `total_amt`) 
    VALUES ($order_id, '$user_id', '$f_name', '$email', '$address', '$city', '$state', '$zip', 
    '$cardname', '$cardnumberstr', '$expdate', '$cvv', '$voucher_dis', '$total_count', '$total_after_discount')";

    if (mysqli_query($con, $sql)) {
        $i = 1;
        while ($i <= $total_count) {
            $prod_id = $_POST['prod_id_'.$i];
            $prod_price = $_POST['prod_price_'.$i];
            $prod_qty = $_POST['prod_qty_'.$i];
            $sub_total = (int)$prod_price * (int)$prod_qty;
            $sql1 = "INSERT INTO `order_products` 
            (`order_pro_id`, `order_id`, `product_id`, `qty`, `amt`) 
            VALUES (NULL, '$order_id', '$prod_id', '$prod_qty', '$sub_total')";
            if (mysqli_query($con, $sql1)) {
                $i++;
            } else {
                echo(mysqli_error($con));
            }
        }
        
        // Delete the used voucher
        if ($voucher_id != '0') {  // Check if a voucher was used
            $del_voucher_sql = "DELETE FROM user_vouchers WHERE user_id='$user_id' AND voucher_id='$voucher_id'";
            if (!mysqli_query($con, $del_voucher_sql)) {
                echo(mysqli_error($con));
            }
        }

        // Clear the cart
        $del_sql = "DELETE FROM cart WHERE user_id='$user_id'";
        if (mysqli_query($con, $del_sql)) {
            echo "<script>window.location.href='order_successful.php'</script>";
        } else {
            echo(mysqli_error($con));
        }
    } else {
        echo(mysqli_error($con));
    }
} else {
    echo "<script>window.location.href='index.php'</script>";
}
?>
