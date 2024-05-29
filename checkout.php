<?php
include "db.php";

include "header.php";


                         
?>

<style>

.row-checkout {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container-checkout {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.checkout-btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.checkout-btn:hover {
  background-color: #45a049;
}



hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row-checkout {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>

					
<section class="section">       
    <div class="container-fluid">
        <div class="row-checkout">
        <?php
        if (isset($_SESSION["uid"])) {
            $user_id = $_SESSION['uid'];
            $sql = "SELECT * FROM user_info WHERE user_id='$user_id'";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);

            $sql_vouchers = "SELECT voucher_id, voucher_discount FROM user_vouchers WHERE user_id='$user_id'";
            $voucher_query = mysqli_query($con, $sql_vouchers);
            $vouchers = mysqli_fetch_all($voucher_query, MYSQLI_ASSOC);

            echo '
            <div class="col-75">
                <div class="container-checkout">
                  <form id="checkout_form" action="checkout_process.php" method="POST" class="was-validated">
                    <div class="row-checkout">
                    <div class="col-50">
                        <h3>Billing Address</h3>
                        <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                        <input type="text" id="fname" class="form-control" name="firstname" pattern="^[a-zA-Z ]+$" value="'.$row["first_name"].' '.$row["last_name"].'">
                        <label for="email"><i class="fa fa-envelope"></i> Email</label>
                        <input type="text" id="email" name="email" class="form-control" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$" value="'.$row["email"].'" required>
                        <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                        <input type="text" id="adr" name="address" class="form-control" value="'.$row["address"].'" required>
                        <label for="city"><i class="fa fa-institution"></i> City</label>
                        <input type="text" id="city" name="city" class="form-control" value="'.$row["city"].'" pattern="^[a-zA-Z ]+$" required>
                        
                        <div class="row">
                        <div class="col-50">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" class="form-control" value="'.$row["state"].'" pattern="^[a-zA-Z ]+$" required>
                        </div>
                        <div class="col-50">
                            <label for="zip">Zip</label>
                            <input type="text" id="zip" name="zip" class="form-control" value="'.$row["zip"].'" pattern="^[0-9]{5}+$" required>
                        </div>
                        </div>


                    </div>
                    
                    <div class="col-50" id="payment-section">
                      <h3>Payment</h3>
                      <label for="fname">Accepted Cards</label>
                      <div class="icon-container">
                          <i class="fa fa-cc-visa" style="color:navy;"></i>
                          <i class="fa fa-cc-amex" style="color:blue;"></i>
                          <i class="fa fa-cc-mastercard" style="color:red;"></i>
                          <i class="fa fa-cc-discover" style="color:orange;"></i>
                      </div>
                      <label for="cname">Name on Card</label>
                          <input type="text" id="cname" name="cardname" class="form-control" pattern="^[a-zA-Z ]+$">                      
                          <div class="form-group" id="card-number-field">
                          <label for="cardNumber">Card Number</label>
                          <input type="text" class="form-control" id="cardNumber" name="cardNumber" pattern="^[0-9]{16}$">
                      </div>
                      <label for="expdate">Exp Date</label>
                      <input type="text" id="expdate" name="expdate" class="form-control" pattern="^(0[1-9]|1[0-2])\/\d{2}$" placeholder="MM/YY">
                      <div class="row">
                          <div class="col-50">
                              <div class="form-group CVV">
                                  <label for="cvv">CVV</label>
                                  <input type="text" class="form-control" name="cvv" id="cvv" pattern="^[0-9]{3,4}$">
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

                    <label for="vouchers">Apply Voucher</label>
                    <select id="vouchers" name="voucher_id" class="form-control">
                        <option value="0">Select Voucher</option>';
                        foreach ($vouchers as $voucher) {
                            echo '<option value="'.$voucher['voucher_id'].'" data-discount="'.$voucher['voucher_discount'].'">RM'.$voucher['voucher_discount'].' Discount</option>';
                        }
                    echo '  </select>

                    <label for="pay_with_voucher">
                      <input type="checkbox" id="pay_with_voucher" name="pay_with_voucher"> Pay Only using voucher
                    </label>
                    <p id="voucher-error" style="color: red; display: none;">Voucher discount is not enough to cover the total amount.</p>
                    <p id="payment-error" style="color: red; display: none;">Please fill in the payment details.</p>';

                    $i = 1;
                    $total = 0;
                    $total_count = $_POST['total_count'];
                    while ($i <= $total_count) {
                        $item_name_ = $_POST['item_name_' . $i];
                        $amount_ = $_POST['amount_' . $i];
                        $quantity_ = $_POST['quantity_' . $i];
                        $total += $amount_;
                        $sql = "SELECT product_id FROM products WHERE product_title='$item_name_'";
                        $query = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($query);
                        $product_id = $row["product_id"];
                        echo "
                        <input type='hidden' name='prod_id_$i' value='$product_id'>
                        <input type='hidden' name='prod_price_$i' value='$amount_'>
                        <input type='hidden' name='prod_qty_$i' value='$quantity_'>
                        ";
                        $i++;
                    }

                    echo '
                    <input type="hidden" name="total_count" value="'.$total_count.'">
                    <input type="hidden" name="total_price" value="'.$total.'">
                    
                    <input type="submit" id="submit" value="Continue to checkout" class="checkout-btn">
                    </form>
                </div>
            </div>';
        } else {
            echo "<script>window.location.href = 'cart.php'</script>";
        }
        ?>

        <div class="col-25">
            <div class="container-checkout">
                <?php
                if (isset($_POST["cmd"])) {
                    $user_id = $_POST['custom'];
                    $voucher_discount = isset($_POST['voucher']);

                    $i = 1;
                    echo "
                    <h4>Cart 
                    <span class='price' style='color:black'>
                    <i class='fa fa-shopping-cart'></i> 
                    <b>$total_count</b>
                    </span>
                    </h4>

                    <table class='table table-condensed'>
                    <thead><tr>
                    <th>no</th>
                    <th>product title</th>
                    <th>qty</th>
                    <th>amount</th></tr>
                    </thead>
                    <tbody>
                    ";
                    $total = 0;
                    while ($i <= $total_count) {
                        $item_name_ = $_POST['item_name_' . $i];
                        $item_number_ = $_POST['item_number_' . $i];
                        $amount_ = $_POST['amount_' . $i];
                        $quantity_ = $_POST['quantity_' . $i];
                        $total += $amount_;
                        $sql = "SELECT product_id FROM products WHERE product_title='$item_name_'";
                        $query = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($query);
                        $product_id = $row["product_id"];

                        echo "
                        <tr><td><p>$item_number_</p></td><td><p>$item_name_</p></td><td><p>$quantity_</p></td><td><p>RM$amount_</p></td></tr>";
                        
                        $i++;
                    }

                    // Calculate discount
                    $total_after_discount = $total - $voucher_discount;

                    echo "
                    </tbody>
                    </table>
                    <hr>
                    <h3>Subtotal<span class='price' style='color:black'><b>RM$total</b></span></h3>";
                    
                    echo "<h3 id='discount'>Discount<span class='price' style='color:black'><b>RM-$voucher_discount</b></span></h3>";
                    
                    echo "<h3>Total<span class='price' style='color:black'><b id='total_after_discount'>RM$total_after_discount</b></span></h3>";
                }
                ?>
            </div>
        </div>
        </div>
    </div>
</section>      
<?php
include "footer.php";
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var payWithVoucherCheckbox = document.getElementById('pay_with_voucher');
    var paymentSection = document.getElementById('payment-section');
    var voucherSelect = document.getElementById('vouchers');
    var total = <?php echo $total; ?>;
    var voucherError = document.getElementById('voucher-error');
    var paymentError = document.getElementById('payment-error');

    payWithVoucherCheckbox.addEventListener('change', function() {
        var selectedVoucher = voucherSelect.options[voucherSelect.selectedIndex];
        var voucherDiscount = parseFloat(selectedVoucher.getAttribute('data-discount')) || 0;

        if (voucherDiscount < total) {
            payWithVoucherCheckbox.checked = false;
            voucherError.style.display = 'block';
        } else {
            voucherError.style.display = 'none';
            paymentSection.style.display = this.checked ? 'none' : 'block';
        }
    });

    voucherSelect.addEventListener('change', function() {
        var selectedVoucher = voucherSelect.options[voucherSelect.selectedIndex];
        var discount = parseFloat(selectedVoucher.getAttribute('data-discount')) || 0;
        var totalAfterDiscountElement = document.getElementById('total_after_discount');
        var discountElement = document.getElementById('discount');

        var totalAfterDiscount = total - discount;

        discountElement.textContent = 'Discount: RM -' + discount.toFixed(2);
        totalAfterDiscountElement.textContent = 'RM' + totalAfterDiscount.toFixed(2);

        if (payWithVoucherCheckbox.checked && discount < total) {
            payWithVoucherCheckbox.checked = false;
            voucherError.style.display = 'block';
            paymentSection.style.display = 'block';
        } else {
            voucherError.style.display = 'none';
        }
    });

    document.getElementById('checkout_form').addEventListener('submit', function(event) {
        var selectedVoucher = voucherSelect.options[voucherSelect.selectedIndex];
        var voucherDiscount = parseFloat(selectedVoucher.getAttribute('data-discount')) || 0;

        var cardname = document.getElementById('cname').value.trim();
        var cardnumber = document.getElementById('cardNumber').value.trim();
        var cvv = document.getElementById('cvv').value.trim();
        var expdate = document.getElementById('expdate').value.trim();

        if (voucherDiscount < total && (!cardname || !cardnumber || !cvv || !expdate)) {
            paymentError.style.display = 'block';
            event.preventDefault();
        } else {
            paymentError.style.display = 'none';
        }

        var cardnameInput = document.getElementById('cname');
        var cardnumberInput = document.getElementById('cardNumber');
        var cvvInput = document.getElementById('cvv');
        var expdateInput = document.getElementById('expdate');

        var cardnameError = document.getElementById('cardname-error');
        var cardnumberError = document.getElementById('cardnumber-error');
        var cvvError = document.getElementById('cvv-error');
        var expdateError = document.getElementById('expdate-error');

        // Check card name pattern
        if (!cardnameInput.checkValidity()) {
            cardnameError.textContent = 'Invalid card name';
            event.preventDefault();
        } else {
            cardnameError.textContent = '';
        }

        // Check card number pattern
        if (!cardnumberInput.checkValidity()) {
            cardnumberError.textContent = 'Invalid card number';
            event.preventDefault();
        } else {
            cardnumberError.textContent = '';
        }

        // Check CVV pattern
        if (!cvvInput.checkValidity()) {
            cvvError.textContent = 'Invalid CVV';
            event.preventDefault();
        } else {
            cvvError.textContent = '';
        }

        // Check expiry date pattern
        if (!expdateInput.checkValidity()) {
            expdateError.textContent = 'Invalid expiry date';
            event.preventDefault();
        } else {
            expdateError.textContent = '';
        }
    });
});
</script>
