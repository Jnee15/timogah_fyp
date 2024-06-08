<?php

session_start();
if(!isset($_SESSION["uid"])){
	header("location:index.php");
}

if (isset($_GET["st"])) {

    # code...
    $p_st = $_GET["st"];
    $cm_user_id = $_GET["cm"];
    
    if ($p_st == "Completed") {
        
        include_once("db.php");
        
        // Fetching the user's cart items
        $sql = "SELECT p_id, qty FROM cart WHERE user_id = '$cm_user_id'";
        $query = mysqli_query($con, $sql);
        
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $product_id[] = $row["p_id"];
                $qty[] = $row["qty"];
            }

            // Deleting the user's cart items
            $sql = "DELETE FROM cart WHERE user_id = '$cm_user_id'";
            if (mysqli_query($con, $sql)) {

			?>
					<!DOCTYPE html>
					<html>
						<head>
							<meta charset="UTF-8">
							<title>Timogah</title>
							<link rel="stylesheet" href="css/bootstrap.min.css"/>
							<script src="js/bootstrap.min.js"></script>
							<script src="main.js"></script>
							<style>
								table tr td {padding:10px;}
							</style>
						</head>
					<body>
						<div class="navbar navbar-inverse navbar-fixed-top">
							<div class="container-fluid">	
								<div class="navbar-header">
									<a href="#" class="navbar-store">Timogah</a>
								</div>
								<ul class="nav navbar-nav">
									<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
									<li><a href="profile.php"><span class="glyphicon glyphicon-modal-window"></span>Product</a></li>
								</ul>
							</div>
						</div>
						<p><br/></p>
						<p><br/></p>
						<p><br/></p>
						<div class="container-fluid">
						
							<div class="row">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<div class="panel panel-default">
										<div class="panel-heading"></div>
										<div class="panel-body">
											<h1>Thankyou </h1>
											<hr/>
											<p>Hello <?php echo "<b>".$_SESSION["name"]."</b>"; ?>,Your payment process is 
											successfully completed and your Transaction id is <b><?php echo $trx_id; ?></b><br/>
											you can continue your Shopping <br/></p>
										</div>
										<div class="panel-footer"></div>
									</div>
								</div>
								<div class="col-md-2"></div>
							</div>
						</div>
					</body>
					</html>

				<?php
			}
		}else{
			header("location:index.php");
		}
		
	}
}

?>

















































