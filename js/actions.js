$(document).ready(function(){
	cat();
    cathome();
	store();
	product();
    producthome();
    reviewData();
    
	//cat() is a funtion fetching category record from database whenever page is load
	function cat(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{category:1},
			success	:	function(data){
				$("#get_category").html(data);
				
			}
		})
	}
    function cathome(){
		$.ajax({
			url	:	"item_page.php",
			method:	"POST",
			data	:	{categoryhome:1},
			success	:	function(data){
				$("#get_category_home").html(data);
				
			}
		})
	}
	//store() is a funtion fetching store record from database whenever page is load
	function store(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{store:1},
			success	:	function(data){
				$("#get_brand").html(data);
			}
		})
	}
	//product() is a funtion fetching product record from database whenever page is load
	function product(){
		var cid = $("#get_product").attr("cid");
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{getProduct:1,cat_id:cid},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	}
	function launch_toast() {
		var x = document.getElementById("toast")
		x.className = "show";
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
	}
	function reviewData(){
		var pid = $("#review_action").attr("pid");
		$("#review_action").html("<h3>Loading...</h3>");
		$(".overlay").show();
		$.ajax({
			url : "review_action.php",
			method : "POST",
			data : {review_action:1,proId:pid},
			success : function(data){
				console.log("reviewData");
				$(".overlay").hide();
				$("#review_action").html(data);
				ratingReviews();
			}
		})
	}
	function ratingReviews(){
		var pid = $("#review_action").attr("pid");
		$(".overlay").show();
		$.ajax({
			url : "review_action.php",
			method : "POST",
			data : {rating_reviews:1,proId:pid},
			success : function(data){
				console.log("ratingReviews");
				$(".overlay").hide();
				$("#rating_reviews").html(data);
			}
		})
	}

    gethomeproduts();
    function gethomeproduts(){
		$.ajax({
			url	:	"item_page.php",
			method:	"POST",
			data	:	{gethomeProduct:1},
			success	:	function(data){
				$("#get_home_product").html(data);
			}
		})
	}
    function producthome(){
		$.ajax({
			url	:	"item_page.php",
			method:	"POST",
			data	:	{getProducthome:1},
			success	:	function(data){
				$("#get_product_home").html(data);
			}
		})
	}
   
    
	/*	when page is load successfully then there is a list of categories when user click on category we will get category id and 
		according to id we will show products
	*/
	$("body").delegate(".category","click",function(event){
		event.preventDefault();
		$("#get_product").html("<h3>Loading...</h3>");
		
		var cid = $(this).attr('cid');
		
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{get_seleted_Category:1,cat_id:cid},
			success	:	function(data){
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
	
	})
    

	/*	when page is load successfully then there is a list of stores when user click on store we will get store id and 
		according to store id we will show products
	*/
	$("body").delegate(".selectStore","click",function(event){
		event.preventDefault();
		$("#get_product").html("<h3>Loading...</h3>");
		var bid = $(this).attr('bid');
		
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{selectStore:1,store_id:bid},
			success	:	function(data){
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
	
	})
	/*
		At the top of page there is a search box with search button when user put name of product then we will take the user 
		given string and with the help of sql query we will match user given string to our database keywords column then matched product 
		we will show 
	*/
	$("body").delegate("#search-btn","click",function(event){
		$("#get_product").html("<h3>Loading...</h3>");
		var keyword = $("#search").val();
		if(keyword != ""){
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{search:1,keyword:keyword},
			success	:	function(data){ 
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
		}
	})
	//end


	/*
		Here #login is login form id and this form is available in index.php page
		from here input data is sent to login.php page
		if you get login_success string from login.php page means user is logged in successfully and window.location is 
		used to redirect user from home page to profile.php page
	*/
	$("#login").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url	:	"login.php",
			method:	"POST",
			data	:$("#login").serialize(),
			success	:function(data){
				if(data == "login_success"){
					
					window.location.href = "index.php";
					$("#desc").html("Logged in successfully");
					launch_toast();
				}else if(data == "cart_login"){
					window.location.href = "cart.php";
					$("#desc").html("Logged in successfully");
					launch_toast();
				}else{
					$("#desc").html(data);
					launch_toast();
					$("#e_msg").html(data);
					$(".overlay").hide();
				}
			}
		})
	})
	//end
	
	//Get User Information before checkout
	$("#signup_form").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "register.php",
			method : "POST",
			data : $("#signup_form").serialize(),
			success : function(data){
				$(".overlay").hide();
				if (data == "register_success") {
					window.location.href = "cart.php";
					$("#desc").html("Registered successfully");
					launch_toast();
				}else{
					$("#signup_msg").html(data);
				}
				
			}
		})
	})

	$("#review_form").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "review.php",
			method : "POST",
			data : $("#review_form").serialize(),
			success : function(data){
				$(".overlay").hide();
				$("#review_msg").html(data);
				$('#review_form')[0].reset();
				reviewData();
				$("#desc").html("review added successfully");
				launch_toast();
			}
		})
	})

	//Get User Information before checkout end here

	//Add Product into Cart
	$("body").delegate("#product","click",function(event){
		var pid = $(this).attr("pid");
		
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {addToCart:1,proId:pid},
			success : function(data){
				$("#desc").html("Added to Cart");
				launch_toast();
				count_item();
				count_wishlist_item();
				getCartItem();
				WishlistDetails();
				$('#product_msg').html(data);
				$('.overlay').hide();
			}
		})
	})

	$("body").delegate("#clickwishlist","click",function(event){
		var pid = $(this).attr("pid");
		
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {addToWishlist:1,proId:pid},
			success : function(data){
				$("#desc").html("Added to Wishlist");
				launch_toast();
				count_wishlist_item();
				count_item();
				checkOutDetails();
				$('#product_msg').html(data);
				$('.overlay').hide();
			}
		})
	})
	
	//Add Product into Cart End Here
	//Count user cart items funtion
	count_item();
	function count_item(){
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {count_item:1},
			success : function(data){
				$(".badge").html(data);
			}
		})
	}
	count_wishlist_item();
	function count_wishlist_item(){
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {count_Wishlist_item:1},
		})
	}
	//Count user cart items funtion end

	//Fetch Cart item from Database to dropdown menu
	getCartItem();
	function getCartItem(){
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {Common:1,getCartItem:1},
			success : function(data){
				$("#cart_product").html(data);
                net_total();
                
			}
		})
	}

	//Fetch Cart item from Database to dropdown menu

	/*
		Whenever user change qty we will immediate update their total amount by using keyup funtion
		but whenever user put something(such as ?''"",.()''etc) other than number then we will make qty=1
		if user put qty 0 or less than 0 then we will again make it 1 qty=1
		('.total').each() this is loop funtion repeat for class .total and in every repetation we will perform sum operation of class .total value 
		and then show the result into class .net_total
	*/
	function updateSubtotal() {
		var row = $(this).closest("tr");
		var price = parseFloat(row.find('.price').val());
		var qty = parseFloat(row.find('.qty').val());
		var cart_item_id = row.find('input[name="cart_item_id[]"]').val();

		if (isNaN(qty) || qty < 1) {
			qty = 1;
			row.find('.qty').val(qty);
			row.find('.qty-notice').text('Quantity must be a positive number. Defaulting to 1.');
		} else {
			row.find('.qty-notice').text('');
		}

		var total = price * qty;
		row.find('.total').val(total.toFixed(2));

		var net_total = 0;
		$('.total').each(function () {
			net_total += parseFloat($(this).val());
		});
		$('.net_total').html("Total : RM " + net_total.toFixed(2));

		// AJAX call to update quantity and subtotal in the database
		$.ajax({
			url: 'update_cart.php',
			method: 'POST',
			data: {
				cart_item_id: cart_item_id,
				qty: qty,
				total: total
			},
			success: function (response) {
				console.log(response);
			}
		});
	}

	$("body").on("keyup change", ".qty", updateSubtotal);
	/*
		whenever user click on .remove class we will take product id of that row 
		and send it to action.php to perform product removal operation
	*/

	   
    $("body").delegate(".remove","click",function(event){
        var remove = $(this).parent().parent().parent();
		var remove_id = remove.find(".remove").attr("remove_id");
		
        $.ajax({
            url	:	"action.php",
            method	:	"POST",
            data	:	{removeItemFromCart:1,rid:remove_id},
            success	:	function(data){
				$("#desc").html("Removed From Cart");
				launch_toast();
                $("#cart_msg").html(data);
				checkOutDetails();
				count_item();
                }
            })
	})
	
	$("body").delegate(".wishlist-remove","click",function(event){
        var remove = $(this).parent().parent().parent();
		var remove_id = remove.find(".wishlist-remove").attr("remove_id");
        $.ajax({
            url	:	"action.php",
            method	:	"POST",
            data	:	{removeItemFromwishList:1,rid:remove_id},
            success	:	function(data){
				$("#desc").html("Removed From WishList");
				launch_toast();
                $("#cart_msg").html(data);
                WishlistDetails();
                }
            })
    })
    
	checkOutDetails();
	WishlistDetails();
	net_total();
	/*
		checkOutDetails() function work for two purposes
		First it will enable php isset($_POST["Common"]) in action.php page and inside that
		there is two isset funtion which is isset($_POST["getCartItem"]) and another one is isset($_POST["checkOutDetials"])
		getCartItem is used to show the cart item into dropdown menu 
		checkOutDetails is used to show cart item into Cart.php page
	*/
	function checkOutDetails(){
	 $('.overlay').show();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {Common:1,checkOutDetails:1},
			success : function(data){
				$('.overlay').hide();
				$("#cart_checkout").html(data);
					net_total();
			}
		})
	}

	function WishlistDetails(){
		$('.overlay').show();
		   $.ajax({
			   url : "action.php",
			   method : "POST",
			   data : {wishListCommon:1, wishlistDetails:1},
			   success : function(data){
				   $('.overlay').hide();
				   $("#wishlist_data").html(data);
					   net_total();
			   }
		   })
	   }
	/*
		net_total function is used to calcuate total amount of cart item
	*/
	function net_total(){
		var net_total = 0;
		$('.qty').each(function(){
			var row = $(this).parent().parent();
			var price  = row.find('.price').val();
			var total = price * $(this).val()-0;
			row.find('.total').val(total);
		})
		$('.total').each(function(){
			net_total += ($(this).val()-0);
		})
		$('.net_total').html("Total : RM " +net_total);
	}

	//remove product from cart

	page();
	function page(){
		var cat_id = $('#pageno').attr("cid");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{page:1,cid:cat_id},
			success	:	function(data){
				$("#pageno").html(data);
			}
		})
	}
	$("body").delegate("#page","click",function(){
		var pn = $(this).attr("page");
		var cat_id = $(this).attr("cid");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{getProduct:1,setPage:1,pageNumber:pn,cid:cat_id},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	})
})






















