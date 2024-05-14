<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Timogah</title>

		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<link rel="stylesheet" href="css/font-awesome.min.css">

		<link type="text/css" rel="stylesheet" href="css/style.css"/>
		<link type="text/css" rel="stylesheet" href="css/accountbtn.css"/>

    </head>
        <style>
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
        </style>
    
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
					<img src="img/timogahlogo.png" />
				</a>            
			</div>
            <!-- /LOGO -->

            <!-- SEARCH BAR -->
            <div class="header-search">
                <form onsubmit="return false">
                    <select class="input-select">
                        <option value="0">All Categories</option>
                        <option value="1">Fresh Products</option>
                        <option value="1">Handicrafts</option>
                    </select>
                    <input class="input" id="search" type="text" placeholder="Search here">
                    <button id="search_btn" class="search-btn">Search</button>
                </form>
            </div>
            <div class="header-ctn">
                <!-- Spinwheel -->
                <div class="spinwheelIcon">
                    <script src="script.js"></script>
                    <a href="spinwheel.php">
                        <img src="img/spinwheel.png" />
                        <div>Spinwheel</div>
                    </a>
                </div>
                <!-- ACCOUNT -->
                <div>
                    <?php
                        include "database/dbconnection.php";
                        if(isset($_SESSION["uid"])){
                            $sql = "SELECT first_name FROM user_info WHERE user_id='$_SESSION[uid]'";
                            $query = mysqli_query($con,$sql);
                            $row=mysqli_fetch_array($query);
                            
                            echo '
                            <div class="dropdownn">
                                <a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal" ><i class="fa fa-user-o"></i> HI '.$row["first_name"].'</a>
                                <div class="dropdownn-content">
                                <a href="myorders.php"  ><i class="fa fa-shopping-basket" aria-hidden="true"></i>My Order</a>
                                <a href="" data-toggle="modal" data-target="#profile"><i class="fa fa-user-circle" aria-hidden="true" ></i>My Profile</a>
                                <a href="logout.php"  ><i class="fa fa-sign-in" aria-hidden="true"></i>Log out</a>
                                
                                </div>
                            </div>';

                        }else{ 
                            echo '
                            <div class="dropdownn">
                                <a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal" >
								<div class="icon-container">
									<i class="fa fa-user"></i> 
									<span>My Account</span>
								</div>
								</a>
                                <div class="dropdownn-content">
                                <a href="admin/login.php" ><i class="fa fa-user" aria-hidden="true" ></i>Admin</a>
                                <a href="signin_form.php"><i class="fa fa-sign-in" aria-hidden="true" ></i>Login</a>
                                <a href="signup_form.php"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a>
                                
                                </div>
                            </div>';
                            
                        }
                    ?>
                               
                </div>    

                <!-- Cart -->
                <div class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Your Cart</span>
                        <div class="badge qty">0</div>
                    </a>
                    <div class="cart-dropdown">
                        <div class="cart-list" id="cart_product"></div>
                        <div class="cart-btns">
                            <a href="cart.php" style="width:100%;"><i class="fa fa-edit"></i> edit cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<nav id='navigation'>
		<div class="container">
			<div id="responsive-nav">
				<ul class="main-nav nav navbar-nav">
					<li><a href="stores.php" class="link">Stores</a></li>
					<li><a href="category.php" class="link">Products Category</a></li>					
				</ul>
			</div>
		</div>
	</nav>

</div>

		<!-- NAVIGATION -->
		
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
                        <div class="modal-dialog" style="">

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