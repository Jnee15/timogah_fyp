<?php
include 'header.php';

// Check if the user is logged in
if (isset($_SESSION['uid'])) {
    $user_id = $_SESSION['uid'];
    $product_id = $_GET['p'];

    // SQL query to check if the user has bought the product
    $sql = "SELECT COUNT(*) AS count 
            FROM order_products op 
            JOIN orders_info oi ON op.order_id = oi.order_id 
            WHERE oi.user_id = '$user_id' AND op.product_id = '$product_id'";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    // Check if the count is greater than 0, meaning the user bought the product
    if ($row['count'] > 0) {
        $has_purchased = true;
    } else {
        $has_purchased = false;
    }
} else {
    $has_purchased = false; // User is not logged in
}
?>


		<!-- /BREADCRUMB -->
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
</script>
		<script>
    
    (function (global) {
	if(typeof (global) === "undefined")
	{
		throw new Error("window is undefined");
	}
    var _hash = "!";
    var noBackPlease = function () {
        global.location.href += "#";
        global.setTimeout(function () {
            global.location.href += "!";
        }, 50);
    };	
	// Earlier we had setInerval here....
    global.onhashchange = function () {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };
    global.onload = function () {        
		noBackPlease();
		// disables backspace on page except on input fields and textarea..
		document.body.onkeydown = function (e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                e.preventDefault();
            }
            // stopping event bubbling up the DOM tree..
            e.stopPropagation();
        };		
    };
})(window);
</script>

		<!-- SECTION -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
					
					<?php 
								include 'db.php';
								$product_id = $_GET['p'];
								
								$sql = " SELECT * FROM products AS P,categories AS C WHERE P.product_cat = C.cat_id  AND P.product_id = '$product_id'";
								if (!$con) {
									die("Connection failed: " . mysqli_connect_error());
								}
								$result = mysqli_query($con, $sql);
								if (mysqli_num_rows($result) > 0) 
								{
									while($row = mysqli_fetch_assoc($result)) 
									{
									echo '
									
                                    
                                
                                <div class="col-md-5 col-md-push-2">
                                <div id="product-main-img">
                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>
                                </div>
                            </div>
                                
                                <div class="col-md-2  col-md-pull-5">
                                <div id="product-imgs">
                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'g" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>
                                </div>
                            </div>

                                 
									';
                                    
									?>
									<!-- FlexSlider -->
									
									<?php 
									echo '
									
                                    
                                   
							<div class="col-md-5">
								<div class="product-details">
									<h2 class="product-name">'.$row['product_title'].'</h2>
									<div id = "rating_reviews">
										
									</div>
									<div>
										<h3 class="product-price">RM'.$row['product_price'].'</h3>
									</div>
									<div><p>'.$row['product_desc'].'</p></div>

									<div class="add-to-cart">
										<div class="qty-label">
											<div class="btn-group" style="margin-left: 25px; margin-top: 15px">
											<button class="add-to-cart-btn" pid="'.$row['product_id'].'"  id="product" ><i class="fa fa-shopping-cart"></i> add to cart</button>
											</div>
										</div>
										
									</div>

									<ul class="product-btns">
										<li><a href="#" pid="'.$row['product_id'].'"  id="wishlist" ><i class="fa fa-heart-o"></i> add to wishlist</a></li>
									</ul>

									<ul class="product-links">
										<li>Category:</li>
										<li><a href="#">'.$row["cat_title"].'</a></li>
									</ul>

								</div>
							</div>
							';
							$_SESSION['product_id'] = $row['product_id'];
							}
						} 
						?>		
					
					
					<div class="col-md-12">
						<div id="product-tab">
							<!-- product tab nav -->
							<ul class="tab-nav">
								<?php
												include 'db.php';
												$product_id = $_GET['p'];
									
												$product_query = "SELECT COUNT(*) AS count FROM reviews WHERE product_id='$product_id'";
												$run_query = mysqli_query($con,$product_query);
												$row = mysqli_fetch_array($run_query);
												$reviews_count=$row["count"];
												echo '<li><a data-toggle="tab" href="#tab3">Reviews ('.$reviews_count.')</a></li>';
								?>
								
							</ul>
							<!-- /product tab nav -->

							<!-- product tab content -->
							<div class="tab-content">
								<!-- tab  -->
								<div id="tab3" class="tab-pane fade in">
									<div class="row">
										<!-- Rating -->
										<div id="review_action" pid='<?php echo"$product_id"; ?>'></div>
										
										<!-- Review Form -->
<div class="col-md-3 mainn">
    <div id="review-form">
        <?php if ($has_purchased) : ?>
            <form class="review-form" onsubmit="return false" id="review_form" required>
                <input class="input" type="text" name="name" placeholder="Your Name" required>
                <input class="input" type="email" name="email" placeholder="Your Email" required>
                <?php 
                    $product_id = $_GET['p'];
                    echo '<input name="product_id" value="'.$product_id.'" hidden required>';
                ?>
                <textarea class="input" name="review" placeholder="Your Review"></textarea>
                <div class="input-rating">
                    <span>Your Rating: </span>
                    <div class="stars">
                        <input id="star5" name="rating" value="5" type="radio" required><label for="star5"></label>
                        <input id="star4" name="rating" value="4" type="radio" required><label for="star4"></label>
                        <input id="star3" name="rating" value="3" type="radio" required><label for="star3"></label>
                        <input id="star2" name="rating" value="2" type="radio" required><label for="star2"></label>
                        <input id="star1" name="rating" value="1" type="radio" required><label for="star1"></label>
                    </div>
                </div>
                <button class="primary-btn" name="review_submit">Submit</button>
            </form>
        <?php else : ?>
            <p>You need to purchase this product to leave a review.</p>
        <?php endif; ?>
    </div>
</div>
<!-- /Review Form -->
									</div>
								</div>
								<!-- /tab  -->
							</div>
							<!-- /product tab content  -->
						</div>
					</div>
					<!-- /product tab -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
                    
					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="title">Related Products</h3>
							
						</div>
					</div>
                    
								<?php
                    include 'db.php';
								$product_id = $_GET['p'];
                    
					$product_query = "SELECT * FROM products,categories WHERE product_cat=cat_id AND product_id BETWEEN $product_id AND $product_id+3";
                $run_query = mysqli_query($con,$product_query);
                if(mysqli_num_rows($run_query) > 0){

                    while($row = mysqli_fetch_array($run_query)){
                        $pro_id    = $row['product_id'];
                        $pro_cat   = $row['product_cat'];
                        $pro_store = $row['product_store'];
                        $pro_title = $row['product_title'];
                        $pro_price = $row['product_price'];
                        $pro_image = $row['product_image'];

                        $cat_name = $row["cat_title"];

                        echo "
				
                        
                                <div class='col-md-3 col-xs-6'>
								<a href='product.php?p=$pro_id'><div class='product'>
									<div class='product-img'>
										<img src='product_images/$pro_image' style='max-height: 170px;' alt=''>
									</div></a>
									<div class='product-body'>
										<p class='product-category'>$cat_name</p>
										<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 class='product-price header-cart-item-info'>RM$pro_price</h4>
										<div class='product-rating'>";
										$rating_query = "SELECT ROUND(AVG(rating),1) AS avg_rating  FROM reviews WHERE product_id='$pro_id '";
										$run_review_query = mysqli_query($con,$rating_query);
										$review_row = mysqli_fetch_array($run_review_query);
										
										if($review_row > 0){
											$avg_count=$review_row["avg_rating"];
												$i=1;
												while($i <= round($avg_count)){
													$i++;
													echo'
													<i class="fa fa-star"></i>';
												}
												$i=1;
												while($i <= 5-round($avg_count)){
													$i++;
													echo'
													<i class="fa fa-star-o empty"></i>';
												}
											
										}
										echo "</div>
										<div class='product-btns'>
											<button pid='$pro_id' id='clickwishlist' class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
										</div>
									</div>
									<div class='add-to-cart'>
										<button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
									</div>
								</div>
                                </div>
							
                        
			";
		}
        ;
      
}
?>
					<!-- product -->
					
					<!-- /product -->

				</div>
				<!-- /row -->
                
			</div>
			<!-- /container -->
		</div>
<?php
include "footer.php";

?>
