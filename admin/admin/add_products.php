<?php
session_start();
include("../../db.php");

$storesQuery = "SELECT * FROM `stores`";
$storesResult = mysqli_query($con, $storesQuery);
$categoriesQuery = "SELECT * FROM `categories`";
$categoriesResult = mysqli_query($con, $categoriesQuery);

if(isset($_POST['btn_save']))
{
    $product_title = $_POST['product_title'];
    $details = $_POST['details'];
    $price = $_POST['price'];
    $product_type = $_POST['product_type'];
    $store = $_POST['store'];
    $tags = $_POST['tags'];

    $picture_name = $_FILES['picture']['name'];
    $picture_type = $_FILES['picture']['type'];
    $picture_tmp_name = $_FILES['picture']['tmp_name'];
    $picture_size = $_FILES['picture']['size'];

    if ($picture_type == "image/jpeg" || $picture_type == "image/jpg" || $picture_type == "image/png" || $picture_type == "image/gif") {
        if ($picture_size <= 50000000) {
            $pic_name = time() . "_" . $picture_name;
            $destination = "../../product_images/" . $pic_name;

            if (move_uploaded_file($picture_tmp_name, $destination)) {
                $query = "INSERT INTO products (product_cat, product_store, product_title, product_price, product_desc, product_image, product_keywords) VALUES ('$product_type', '$store', '$product_title', '$price', '$details', '$pic_name', '$tags')";
                mysqli_query($con, $query) or die("Query incorrect: " . mysqli_error($con));
                header("Location: submit_form.php?success=1");
            } else {
                echo "Failed to upload file. Check the directory permissions.";
            }
        } else {
            echo "File size exceeds the limit.";
        }
    } else {
        echo "Invalid file type.";
    }

    mysqli_close($con);
}

include "sidenav.php";
include "topheader.php";
?>
<style>
  #product_type, #store {
    color: #fff;
    background: #00003f;
  }
</style>
<div class="content">
  <div class="container-fluid">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-7">
          <div class="card">
            <div class="card-header card-header-primary">
              <h5 class="title">Add Product</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Product Title</label>
                    <input type="text" id="product_title" required name="product_title" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="">
                    <label for="">Add Image</label>
                    <input type="file" name="picture" required class="btn btn-fill btn-success" id="picture">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Description</label>
                    <textarea rows="4" cols="80" id="details" required name="details" class="form-control"></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Pricing</label>
                    <input type="number" id="price" name="price" required class="form-control" min="0" step="0.01">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="card">
            <div class="card-header card-header-primary">
              <h5 class="title">Product Category</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Product Category</label>
                    <select id="product_type" name="product_type" required class="form-control">
                      <?php
                      while ($row = mysqli_fetch_assoc($categoriesResult)) {
                          echo "<option value='" . $row['cat_id'] . "'>" . $row['cat_title'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Product Store</label>
                    <select id="store" name="store" required class="form-control">
                      <option value="" disabled selected>Select...</option>
                      <?php
                      while ($row = mysqli_fetch_assoc($storesResult)) {
                          echo "<option value='" . $row['store_id'] . "'>" . $row['store_title'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Product Keywords</label>
                    <input type="text" id="tags" name="tags" required class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <button type="submit" id="btn_save" name="btn_save" required class="btn btn-primary pull-right">Update Product</button>
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
