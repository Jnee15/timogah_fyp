<?php
session_start();

// initializing variables
$name = "";
$username = "";
$usn = "";
$email    = "";
$errors = array();
$reg_date = date("Y/m/d");

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'timogahdb');

// Function to validate email format
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate password (minimum 8 characters, at least one letter and one number)
function isValidPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['admin_name']);
    $email = mysqli_real_escape_string($db, $_POST['admin_email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (!isValidEmail($email)) { array_push($errors, "Invalid email format"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if (!isValidPassword($password_1)) { array_push($errors, "Password must be at least 8 characters long, contain at least 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM admin_info WHERE admin_name='$username' OR admin_email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['admin_name'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['admin_email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    if (count($errors) == 0) {
        $password = md5($password_1);

        $query = "INSERT INTO admin_info (admin_name, admin_email, admin_password)
                  VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['admin_name'] = $username;
        $_SESSION['admin_email'] = $email;

        $_SESSION['success'] = "You are now logged in";
        header('location: ./admin/');
        exit();
    }
}

// LOGIN USER
if (isset($_POST['login_admin'])) {
    $username = mysqli_real_escape_string($db, $_POST['admin_username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM admin_info WHERE admin_email='$username' AND admin_password='$password'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $_SESSION['admin_name'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: ./admin/');
            exit();
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}
?>
