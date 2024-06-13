<?php include("./server/server.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>

    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<style>
div.back {
  padding-top: 20px;
  padding-inline: 50px;
}
.error p {
    color: red;
}
</style>

<body>

    <div class="main" style="padding-top: 90px;">

        <section class="sign-in">
            <div class="container">
                <div class="back">
                    <a href="../index.php" style="text-decoration: none; font-size:30px; color:black;">&#11013;</a>
                </div>
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="./assets/images/signin-image.jpg" alt="sign up image"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">ADMIN LOGIN</h2>
                        <form  class="register-form" id="login-form" action="login.php" method="post">
                            <?php include('./server/errors.php'); ?>
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="admin_username" id="your_name" placeholder="Admin Email"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="your_pass" placeholder="Password"/>
                            </div>
                           
                            <div class="form-group form-button">
                                <input type="submit" name="login_admin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>

    </div>

</body>
</html>
