<?php
session_start();
include "db.php";

if (isset($_POST["f_name"])) {
    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    $name = "/^[a-zA-Z ]+$/";
    $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
    $number = "/^[0-9]+$/";
    $passwordValidation = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";
    $zipValidation = "/^[0-9]{5}$/";

    if (empty($f_name) || empty($l_name) || empty($email) || empty($password) || empty($repassword) ||
        empty($mobile) || empty($address) || empty($city)|| empty($state)|| empty($zip)) {
        echo "
            <div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill all fields..!</b>
            </div>
        ";
        exit();
    } else {
        if (!preg_match($name, $f_name)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>This $f_name is not valid..!</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($name, $l_name)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>This $l_name is not valid..!</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($emailValidation, $email)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>This $email is not valid..!</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($passwordValidation, $password)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Password must be at least 8 characters long, contain at least 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.</b>
                </div>
            ";
            exit();
        }
        if ($password != $repassword) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Passwords do not match</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($number, $mobile)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Mobile number $mobile is not valid</b>
                </div>
            ";
            exit();
        }
        if (!(strlen($mobile) == 10)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Mobile number must be 10 digits</b>
                </div>
            ";
            exit();
        }
        //existing email address in our database
        $sql = "SELECT user_id FROM user_info WHERE email = ? LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "
                <div class='alert alert-danger'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Email Address is already available. Try another email address</b>
                </div>
            ";
            $stmt->close();
            exit();
        } else {
            $stmt->close();
            $sql = "INSERT INTO `user_info` 
            (`first_name`, `last_name`, `email`, `password`, `mobile`, `address`, `city`, `state`, `zip`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssssssss", $f_name, $l_name, $email, $password, $mobile, $address, $city, $state, $zip);
            if ($stmt->execute()) {
                $_SESSION["uid"] = $stmt->insert_id;
                $_SESSION["name"] = $f_name;
                $ip_add = getenv("REMOTE_ADDR");
                $sql = "UPDATE cart SET user_id = ? WHERE ip_add = ? AND user_id = -1";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("is", $_SESSION["uid"], $ip_add);
                if ($stmt->execute()) {
                    echo "register_success";
                    echo "<script> location.href='store.php'; </script>";
                    exit();
                }
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>
