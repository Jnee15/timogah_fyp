<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_name'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: .././login.php');
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['admin_name']);
    header("location: .././login.php");
    exit();
}

// Get the current page's filename
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" sizes="76x76" href="../../img/timogah.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Timogah Admin
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
</head>

<body class="dark-edition">
    <div class="sidebar" data-color="orange" data-background-color="black">
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item <?php if ($current_page == 'index.php') { echo 'active'; } ?>">
                    <a class="nav-link" href="index.php">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item <?php if ($current_page == 'add_user.php') { echo 'active'; } ?>">
                    <a class="nav-link" href="add_user.php">
                        <i class="material-icons">group_add</i>
                        <p>Add User</p>
                    </a>
                </li>
                <li class="nav-item <?php if ($current_page == 'manageuser.php') { echo 'active'; } ?>">
                    <a class="nav-link" href="manageuser.php">
                        <i class="material-icons">manage_accounts</i>
                        <p>Manage Users</p>
                    </a>
                </li>
                <li class="nav-item <?php if ($current_page == 'add_products.php') { echo 'active'; } ?>">
                    <a class="nav-link" href="add_products.php">
                        <i class="material-icons">add</i>
                        <p>Add Products</p>
                    </a>
                </li>             
                <li class="nav-item <?php if ($current_page == 'products_list.php') { echo 'active'; } ?>">
                    <a class="nav-link" href="products_list.php">
                        <i class="material-icons">list</i>
                        <p>Product List</p>
                    </a>
                </li>
                <li class="nav-item <?php if ($current_page == 'add_cat.php') { echo 'active'; } ?>">
                    <a class="nav-link" href="add_cat.php">
                        <i class="material-icons">category</i>
                        <p>Add Category</p>
                    </a>
                </li>
                <li class="nav-item <?php if ($current_page == 'add_store.php') { echo 'active'; } ?>">
                    <a class="nav-link" href="add_store.php">
                        <i class="material-icons">add_business</i>
                        <p>Add Store</p>
                    </a>
                </li>
                <li class="nav-item <?php if ($current_page == 'profile.php') { echo 'active'; } ?>">
                    <a class="nav-link" href="profile.php">
                        <i class="material-icons">settings</i>
                        <p>Setting</p>
                    </a>
                </li>
                <li class="nav-item <?php if ($current_page == 'salesofday.php') { echo 'active'; } ?>">
                    <a class="nav-link" href="salesofday.php">
                        <i class="material-icons">library_books</i>
                        <p>Sales</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
