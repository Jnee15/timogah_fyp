<?php include("./server/server.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Register</title>

    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        .error p {
            color: red;
        }
    </style>
</head>
<body>

    <div class="main" style="padding-top: 90px;">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <a href="admin/index.php" style="margin-left:-30px; text-decoration: none; font-size:30px; color:black;">&#11013;</a>
                        <h2 class="form-title">Admin Register</h2>

                        <form method="post" class="register-form" id="register-form" action="reg.php">
                            <?php if (count($errors) > 0) : ?>
                                <div class="error">
                                    <?php foreach ($errors as $error) : ?>
                                        <p><?php echo $error ?></p>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="admin_name" id="name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="admin_email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password_1" id="pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="password_2" id="re_pass" placeholder="Repeat your password"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="reg_user" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="./assets/images/signup-image.jpg" alt="sign up image"></figure>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>
</html>
