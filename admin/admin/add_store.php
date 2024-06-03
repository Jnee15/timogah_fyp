<?php
session_start();
include("../../db.php");

// Handle add store request
if (isset($_POST['btn_save'])) {
    $store_title = $_POST['store_title'];
    mysqli_query($con, "INSERT INTO stores(store_title) VALUES ('$store_title')") or die("Query 1 is incorrect........");
}

// Handle delete store request
if (isset($_POST['btn_delete_store'])) {
    $store_id = $_POST['store_id'];
    mysqli_query($con, "DELETE FROM stores WHERE store_id='$store_id'") or die("Query 2 is incorrect........");
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
                            <h5 class="title">Add Stores</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Product Store</label>
                                <input id="store_title" name="store_title" required class="form-control"></input>
                                    <button type="submit" id="btn_save" name="btn_save" required class="btn btn-primary pull-right">Update Stores</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h5 class="title">Existing Stores</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Store Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include("../../db.php");
                                    $result = mysqli_query($con, "SELECT * FROM stores");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['store_id'] . "</td>";
                                        echo "<td>" . $row['store_title'] . "</td>";
                                        echo "<td>
                                                <form method='post' action=''>
                                                    <input type='hidden' name='store_id' value='" . $row['store_id'] . "' />
                                                    <button type='submit' name='btn_delete_store' class='btn btn-danger btn-sm'>Delete</button>
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
