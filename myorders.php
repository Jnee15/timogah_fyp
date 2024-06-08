<?php
include "db.php";
include "header.php";
?>

<link href="css/myorders.css" rel="stylesheet"/>					
<section class="section main main-raised">       
	<div class="container-fluid ">
		<div class="wrap cf">
            <h1 class="projTitle">All Your Orders</h1>
            <div class="heading cf">
                <h1>My Orders</h1>
                <h1 style="margin-left:55%">qty</h1>
            </div>
            <div class="cart">
                <ul class="cartWrap">
                <?php
                if (isset($_SESSION["uid"])) {
                    $sql="SELECT c.order_id, a.product_id, a.product_title, a.product_price, a.product_image, b.qty, b.amt, c.total_amt, c.voucher_dis, c.net_total 
                            FROM products a, order_products b, orders_info c 
                            WHERE a.product_id = b.product_id AND c.user_id = '$_SESSION[uid]' AND b.order_id = c.order_id 
                            ORDER BY c.order_id DESC";
                    $query = mysqli_query($con, $sql);

                    if (mysqli_num_rows($query) > 0) {
                        $prev_order_id = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $product_id = $row["product_id"];
                            $product_title = $row["product_title"];
                            $product_price = $row["product_price"];
                            $product_image = $row["product_image"];
                            $qty = $row["qty"];
                            $amt = $row["amt"];
                            $total_amt = $row["total_amt"];
                            $voucher_dis = $row["voucher_dis"];
                            $net_total = $row["net_total"];
                            $order_id = $row["order_id"];

                            if ($prev_order_id != 0 && $prev_order_id != $order_id) {
                                // End the previous order's list
                                echo '</ul></div>
                                      <div class="special"><div class="specialContent">
                                          Thanks for Using our Platform
                                      </div></div>
                                      <div class="subtotal cf">
                                          <ul>
                                              <li class="totalRow"><span class="label">Subtotal</span><span class="value">RM '.$prev_net_total.'</span></li>
                                              <li class="totalRow"><span class="label">Voucher Discount</span><span class="value">- RM '.$prev_voucher_dis.'</span></li>
                                              <li class="totalRow final"><span class="label">Total</span><span class="value">RM'.$prev_total_amt.'</span></li>
                                          </ul>
                                      </div>
                                      <div class="cart"><ul class="cartWrap">';
                            }

                            echo '<li class="items even">
                                    <div class="infoWrap"> 
                                        <div class="cartSection">
                                            <img src="product_images/'.$product_image.'" alt="'.$product_title.'" class="itemImg" />
                                            <p class="itemNumber">#'.$product_id.'</p>
                                            <h3>'.$product_title.'</h3>
                                            <p>'.$qty.' x RM '.$product_price.'</p>
                                            <p class="stockStatus"> Delivered</p>
                                        </div>  
                                        <div class="prodTotal cartSection"><p>'.$qty.'</p></div>
                                        <div class="prodTotal cartSection">
                                            <p>RM '.$amt.'</p>
                                        </div>
                                    </div>
                                </li>';

                            $prev_order_id = $order_id;
                            $prev_voucher_dis = $voucher_dis;
                            $prev_net_total = $net_total;
                            $prev_total_amt = $total_amt;
                        }

                        // Output the final order's totals
                        echo '</ul></div>
                              <div class="special"><div class="specialContent">
                                  Thanks for Using our Platform
                              </div></div>
                              <div class="subtotal cf">
                                  <ul>
                                      <li class="totalRow"><span class="label">Subtotal</span><span class="value">RM '.$prev_net_total.'</span></li>
                                      <li class="totalRow"><span class="label">Voucher Discount</span><span class="value">- RM '.$prev_voucher_dis.'</span></li>
                                      <li class="totalRow final"><span class="label">Total</span><span class="value">RM'.$prev_total_amt.'</span></li>
                                  </ul>
                              </div>';
                    } else {
                        echo "<p>No orders found.</p>";
                    }
                }
                ?>
                </ul>
            </div>             
        </div>
    </div>
</section>

<?php
include "footer.php";
?>
