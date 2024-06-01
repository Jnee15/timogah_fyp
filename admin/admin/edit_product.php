<?php
session_start();
include("../../db.php");

$product_id=$_REQUEST['product_id'];

$result=mysqli_query($con,"SELECT `product_id`, `product_cat`, `product_store`, `product_title`, `product_price`, `product_desc`, `product_image`, `product_keywords` from products  where product_id='$product_id'") or die ("query 1 incorrect.......");

list($product_id,$product_type,$store,$product_title,$price,$details,$pic_name,$tags)=mysqli_fetch_array($result);

if(isset($_POST['btn_save']))
{
$product_title=$_POST['product_title'];
$details=$_POST['details'];
$price=$_POST['price'];
$product_type=$_POST['product_type'];
$store=$_POST['store'];
$tags=$_POST['tags'];

$price=$_POST['price']*73.77000;
//picture coding
$picture_name=$_FILES['picture']['name'];
$picture_type=$_FILES['picture']['type'];
$picture_tmp_name=$_FILES['picture']['tmp_name'];
$picture_size=$_FILES['picture']['size'];

if($picture_type=="image/jpeg" || $picture_type=="image/jpg" || $picture_type=="image/png" || $picture_type=="image/gif")
{
	if($picture_size<=50000000)
	
		$pic_name=time()."_".$picture_name;
        move_uploaded_file($picture_tmp_name,"../../product_images/".$pic_name);
        mysqli_query($con,"UPDATE `products` SET `product_title` = '$product_title', 
        `product_cat`= '$product_type',`product_store`='$store',
        `product_price`='$price',`product_desc`='$details',`product_image`='$pic_name',`product_keywords`='$tags' WHERE `product_id` = '$product_id'") or die("Query 2 is inncorrect..........");
    header("location: products_list.php");
   
}else{
    mysqli_query($con,"UPDATE `products` SET `product_title` = '$product_title', 
        `product_cat`= '$product_type',`product_store`='$store',
        `product_price`='$price',`product_desc`='$details',`product_image`='$pic_name',`product_keywords`='$tags' WHERE `product_id` = '$product_id'") or die("Query 2 is inncorrect..........");
    header("location: products_list.php");
}


mysqli_close($con);
}
include "sidenav.php";
include "topheader.php";
?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <form action="" method="post" type="form" name="form" enctype="multipart/form-data">
          <div class="row">
          
                
         <div class="col-md-7">
            <div class="card">
              <div class="card-header card-header-primary">
                <h5 class="title">Edit Product</h5>
              </div>
              <div class="card-body">
                
                  <div class="row">
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Title</label>
                        <input type="text" id="product_title" required name="product_title" value="<?php echo $product_title; ?>" class="form-control">
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                    <img src='<?php echo "../../product_images/".$pic_name?>' style='width:50px; height:50px; border:groove #000'>
                      <div class="">
                        <label for="">Add Image</label>
                        <input type="file" name="picture"  class="btn btn-fill btn-success" value="<?php echo "../../product_images/".$pic_name?>" id="picture" >
                      </div>
                    </div>
                     <div class="col-md-12">
                      <div class="form-group">
                        <label>Description</label>
                        <textarea rows="4" cols="80" id="details" required name="details"  class="form-control"><?php echo $details;?></textarea>
                      </div>
                    </div>
                  
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Pricing</label>
                        <input type="text" id="price" name="price" value="<?php echo $price ?>" required class="form-control" >
                      </div>
                    </div>
                  </div>
                 
                  
                
              </div>
              
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header card-header-primary">
                <h5 class="title">Categories</h5>
              </div>
              <div class="card-body">
                
                  <div class="row">
                  <div class="col-md-12">
                          <div class="form-group">
                            <label for="">Product Category</label>
                            <select id="product_type" name="product_type"  required class="form-control">
                            <option value="" style="color:black;">select Category</option>
                            <?php 
                                
                                    $result1=mysqli_query($con,"SELECT * FROM `categories` ORDER BY `cat_id` ASC") or die ("query 1 incorrect.....");

                                    while(list($cat_id,$cat_title)=mysqli_fetch_array($result1))
                                    {
                                    
                                        if($cat_id==$product_type){
                                            echo "<option value='$cat_id' style='color:black;' selected>$cat_title</option>";
                                        }else{
                                            echo "<option value='$cat_id' style='color:black;'>$cat_title</option>";
                                        }
                                    }
                                    
                                ?>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="">Product Type</label>
                            <select id="store" name="store" required class="form-control">
                            <option value="" style="color:black;">select Type</option>
                                <?php
                                    $result2=mysqli_query($con,"SELECT * FROM `stores`") or die ("query 1 incorrect.....");

                                    while(list($store_id,$store_title)=mysqli_fetch_array($result2))
                                    {
                                        if($store_id==$store){
                                            echo "<option value='$store_id' style='color:black;' selected>$store_title</option>";
                                        }else{
                                            echo "<option value='$store_id' style='color:black;'>$store_title</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                      </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Keywords</label>
                        <input type="text" id="tags" name="tags" value="<?php echo $tags; ?>" required class="form-control" >
                      </div>
                    </div>
                  </div>
                
              </div>
              <div class="card-footer">
                  <button type="submit" id="btn_save" name="btn_save" required class="btn btn-fill btn-primary">Update Product</button>
              </div>
            </div>
          </div>
          
        </div>
         </form>
          
        </div>
      </div>
      <?php
include "footer.php";
?>