<?php
session_start();
include 'db.php';

$sql = "SELECT * FROM categories";
$result = mysqli_query($con, $sql);

$options = ""; // Initialize an empty string to store the options

while($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='".$row['cat_id']."'>".$row['cat_title']."</option>";
}

// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" sizes="76x76" alt="Timogah Icon" href="img/timogahlogo.png">
		<title>Timogah</title>

		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet"/>

		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<link rel="stylesheet" href="css/font-awesome.min.css">

		<link type="text/css" rel="stylesheet" href="css/style.css"/>
		<link type="text/css" rel="stylesheet" href="css/accountbtn.css"/>
		

         
    <style>
        #navigation {
          background: #FF4E50;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #F9D423, #FF4E50);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #F9D423, #FF4E50); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

          
        }
        .mainn-raised {
            
            margin: -7px 0px 0px;
            border-radius: 6px;
            box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);

        }
       
        .glyphicon{
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    }
    .glyphicon-chevron-left:before{
        content:"\f053"
    }
    .glyphicon-chevron-right:before{
        content:"\f054"
    }
        
 .dropdownn {
        position: relative;
        display: inline-block;
        width: 150px; 
    }

    .dropdownn-toggle {
        display: block;
        width: 100%;
        padding: 10px;
        text-align: left;
        cursor: pointer;
    }

    .userdropdown {
        display: none;
        position: absolute;
        min-width: 150px; 
        z-index: 1;
    }

    .userdropdown a {
        color: white;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdownn:hover .userdropdown {
        display: block;
    }
        </style>

    </head>
	<body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li class="left">Hyperlocal & Nationwide delivery available.</li>
					</ul>
					<ul class="header-links pull-right">
						<li>
							<div>
								<a href="wishlist.php">
									<span>My Wishlist</span>
								</a>
							</div>
						</li>
					</ul>
					
				</div>
			</div>
			<!-- /TOP HEADER -->

<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class="header-logo">
				<a class="logo" href="index.php">
					<img alt="Timogah Logo" src="img/timogah.png" />
				</a>            
			</div>
            <!-- /LOGO -->

            <!-- SEARCH BAR -->
            <?php if ($current_page == 'products.php'): ?>
            <div class="header-search">
                <form id="search-form" onsubmit="return false">
                    <input class="input" id="search" type="text" placeholder=" Search here ...">
                    <button id="search-btn" class="search-btn">Search</button>
                </form>
            </div>
            <?php endif; ?>
            <!-- /SEARCH BAR -->

            <div class="header-ctn">
                <!-- Spinwheel -->
                <div class="spinwheelIcon">
                    <a href="spinwheel.php">
                        <img src="img/spinwheel.png" />
                        <div>Spinwheel</div>
                    </a>
                </div>
                <!-- ACCOUNT -->
                <div>
                    <?php
                    include "db.php";
                    if(isset($_SESSION["uid"])){
                        $sql = "SELECT first_name FROM user_info WHERE user_id='$_SESSION[uid]'";
                        $query = mysqli_query($con,$sql);
                        $row=mysqli_fetch_array($query);

                        echo '
                        <div class="dropdownn">
                            <a href="#" class="dropdownn-toggle" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-user-o"></i> HI '.$row["first_name"].'
                            </a>
                            <div class="userdropdown">
                                <a href="myorders.php"><i class="fa fa-shopping-basket" aria-hidden="true"></i>My Order</a>
                                <a href="edit_profile.php"><i class="fa fa-user-circle" aria-hidden="true"></i>My Profile</a>
                                <a href="logout.php"><i class="fa fa-sign-in" aria-hidden="true"></i>Log out</a>
                            </div>
                        </div>';

                    } else {
                        echo '
                        <div class="dropdownn">
                            <a href="#" class="dropdownn-toggle" data-toggle="modal" data-target="#myModal">
                                <div class="icon-container">
                                    <i class="fa fa-user"></i>
                                    <span>My Account</span>
                                </div>
                            </a>
                            <div class="userdropdown">
                                <a href="signin_form.php"><i class="fa fa-sign-in" aria-hidden="true"></i>Login</a>
                                <a href="signup_form.php"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a>
                                <a href="admin/login.php"><i class="fa fa-user" aria-hidden="true"></i>Admin</a>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
                <!-- Cart -->
                <div class="dropdown">
                    <a href="cart.php" style="width:100%;">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Cart</span>
                        <div class="badge qty">0</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

		</header>
		<nav id='navigation'>
			<div class="container" id="get_category_home">
			</div>
		</nav>
            
		<div class="modal fade" id="Modal_login" role="dialog">
                        <div class="modal-dialog">
													
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              
                            </div>
                            <div class="modal-body">
                            <?php
                                include "login_form.php";
    
                            ?>
          
                            </div>
                            
                          </div>
													
                        </div>
                      </div>
                <div class="modal fade" id="Modal_register" role="dialog">
                        <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              
                            </div>
                            <div class="modal-body">
                            <?php
                                include "register_form.php";
    
                            ?>
          
                            </div>
                            
                          </div>

                        </div>
                      </div>
