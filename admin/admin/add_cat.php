<?php
session_start();
include("../../db.php");

// Handle add category request
if (isset($_POST['btn_save_cat'])) {
    $cat_title = $_POST['cat_title'];
    mysqli_query($con, "INSERT INTO categories(cat_title) VALUES ('$cat_title')") or die("Query 1 is incorrect........");
}

// Handle delete category request
if (isset($_POST['btn_delete_cat'])) {
    $cat_id = $_POST['cat_id'];
    mysqli_query($con, "DELETE FROM categories WHERE cat_id='$cat_id'") or die("Query 2 is incorrect........");
}

mysqli_close($con);
include "sidenav.php";
include "topheader.php";
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <form action="" method="post" type="form" name="form" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h5 class="title">Add Categories</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Product Category</label>
                                <input id="cat_title" name="cat_title" required class="form-control"></input>
                                    <button type="submit" id="btn_save_cat" name="btn_save_cat" required class="btn btn-primary pull-right">Update Categories</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h5 class="title">Existing Categories</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include("../../db.php");
                                    $result = mysqli_query($con, "SELECT * FROM categories");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['cat_id'] . "</td>";
                                        echo "<td>" . $row['cat_title'] . "</td>";
                                        echo "<td>
                                                <form method='post' action=''>
                                                    <input type='hidden' name='cat_id' value='" . $row['cat_id'] . "' />
                                                    <button type='submit' name='btn_delete_cat' class='btn btn-danger btn-sm'>Delete</button>
                                                </form>
                                              </td>";
                                        echo "</tr>";
                                    }
                                    mysqli_close($con);
                                    ?>
                                </tbody>
                            </table>
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
