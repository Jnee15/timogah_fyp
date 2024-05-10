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

		<link type="text/css" rel="stylesheet" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="styles.css">
    </head>
	<body>
		<header>
			<div>
				<div class="container">
					<div class="notice">
                        <div class="left">Hyperlocal & Nationwide delivery available.</div>
                        <div class="right">
								<div>
                                    <a href="" class="link">Order Tracking</a>
                                    |
                                    <a href="wishlist.php" class="link">My Wishlist</a>
								</div>
                        </div>
                    </div>
					<div class="top-bar">
						<div>
                            <a class="logo" href="index.php">
                                <img src="img/timogahlogo.png" />
                            </a>
                        </div>

                        <div class="search-bar">
								<form onsubmit="return false">
									<select>
										<option value="0">All Categories</option>
										<option value="1">Vegetables</option>
										<option value="1">Fruits</option>
									</select>
									<input type="text" placeholder="Search here">
									<button>Search</button>
								</form>
						</div>

                        <div></div>

                        <div class="spinwheelIcon">
							<script src="script.js"></script>
                            <a href="spinwheel.php">
                                <img src="img/spinwheel.png" />
                                <div>Spinwheel</div>
                            </a>
                        </div>

                        <div>
                            <div class="icon">
                            <?php
								include "database/dbconnection.php";
								if(isset($_SESSION["uid"])){
									$sql = "SELECT first_name FROM user_info WHERE user_id='$_SESSION[uid]'";
									$query = mysqli_query($con,$sql);
									$row=mysqli_fetch_array($query);
									
									echo '
								<div class="dropdownn">
									<a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal" ><img src="img/profile.jpg"/> HI '.$row["first_name"].'</a>
									<div class="dropdownn-content">
										<a href="myorders.php">My Order</a>
										<a href="" data-toggle="modal" data-target="#profile">My Profile</a>
										<a href="logout.php">Log out</a>
										
									</div>
								</div>';
								}
									else
									{ 
										echo '
										<div class="dropdownn">
										<a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal" ><img src="img/profile.jpg"/></a>
										<div class="dropdownn-content">
											<a href="admin/login.php">Admin</a>
											<a href="signin_form.php">Login</a>
											<a href="signup_form.php">Register</a>
										</div>
										</div>';
									}
                            ?>
					        </div>
                        </div>

                        <div>
							<div class="dropdown">
								<a href="cart.php"><img src="img/cart.png" style="max-width: 40px;"/></a>
							</div>
                        </div>
						<div></div>
					</div>
				</div>
			</div>

			<div class="nav">
				<a href="stores.php" class="link">Stores</a>
				<div class="divider">|</div>
				<a href="category.php" class="link">Products Category</a>
				<div class="divider">|</div>
			</div>
		</header>
	</body>	
