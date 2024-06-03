 <?php
session_start();
include("../../db.php");
include "sidenav.php";
include "topheader.php";
if(isset($_POST['btn_save']))
{
$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$email=$_POST['email'];
$user_password=$_POST['password'];
$mobile=$_POST['phone'];
$address=$_POST['city'];
$city=$_POST['country'];
$state=$_POST['state'];
$zip=$_POST['zip'];

mysqli_query($con,"insert into user_info(first_name, last_name,email,password,mobile,address,city,state,zip) values ('$first_name','$last_name','$email','$user_password','$mobile','$address','$city','$state','$zip')") 
			or die ("Query 1 is inncorrect........"); 
mysqli_close($con);
}


?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Add User</h4>
                  <p class="card-category">profile</p>
                </div>
                <div class="card-body">
                  <form action="" method="post" name="form" enctype="multipart/form-data">
                    <div class="row">
                      
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">First Name</label>
                          <input type="text" id="first_name" name="first_name" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" name="last_name" id="last_name"  class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Email</label>
                          <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Phone number</label>
                          <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Password</label>
                          <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">City</label>
                          <input type="text" name="city" id="city"  class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" name="country" id="country" class="form-control" required>
                        </div>
                      </div>
                        <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">State</label>
                          <input type="text" name="state" id="state" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Zip</label>
                          <input type="text" name="zip" id="zip" class="form-control" required>
                        </div>
                      </div>
                    </div>
                      <button type="submit" name="btn_save" id="btn_save" class="btn btn-primary pull-right">Add User</button>
                  </form>
                </div>
              </div>
            </div>
        </div>
      </div>
       
      <?php
include "footer.php";
?>