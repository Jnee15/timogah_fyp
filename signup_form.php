<?php
if(isset($_SESSION["uid"])){
    header('Location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Register Page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" sizes="76x76" href="img/timogahlogo.png">

<!-- Google font -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet"/>

<!-- Bootstrap -->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

<!-- Font Awesome Icon -->
<link rel="stylesheet" href="css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="css/login_reg.css">
<link rel="stylesheet" type="text/css" href="css/utils.css">

<style>
.text-danger {
    color: red;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}
</style>

</head>
<body style="background-color: #999999;">
    <div class="limiter">
        <div class="container-login100">
            <div class="login100-more" style="background-image: url('img/timogahlogo.png');-webkit-transform: scaleX(-1); transform: scaleX(-1);"></div>
            <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
                <form id="signup_form" onsubmit="return false" class="login100-form validate-form">
                    <span class="login100-form-title p-b-59">
                        Sign Up
                    </span>

                    <div class="col-md-8" id="signup_msg"></div>

                    <div class="wrap-input100 validate-input" data-validate="Name is required">
                        <span class="label-input100">First Name</span>
                        <input class="input100" type="text" name="f_name" id="f_name" placeholder="First Name">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Name is required">
                        <span class="label-input100">Last Name</span>
                        <input class="input100" type="text" name="l_name" id="l_name" placeholder="Last Name">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <span class="label-input100">Email</span>
                        <input class="input100" type="email" name="email" id="email" placeholder="Email address...">
                        <span class="focus-input100"></span>
                        <span id="email-error" class="text-danger"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Mobile no is required">
                        <span class="label-input100">Mobile</span>
                        <input class="input100" type="text" name="mobile" id="mobile" placeholder="mobile....">
                        <span class="focus-input100"></span>
                        <span id="mobile-error" class="text-danger"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <span class="label-input100">Password</span>
                        <input class="input100" type="password" name="password" id="password" placeholder="*************">
                        <span class="focus-input100"></span>
                        <span id="password-error" class="text-danger"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Repeat Password is required">
                        <span class="label-input100">Repeat Password</span>
                        <input class="input100" type="password" name="repassword" id="repassword" placeholder="*************">
                        <span class="focus-input100"></span>
                        <span id="repassword-error" class="text-danger"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Address is required">
                        <span class="label-input100">Address</span>
                        <input class="input100" type="text" name="address" id="address" placeholder="Address">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="City is required">
                        <span class="label-input100">City</span>
                        <input class="input100" type="text" name="city" id="city" placeholder="City">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="State is required">
                        <span class="label-input100">State</span>
                        <input class="input100" type="text" name="state" id="state" placeholder="State">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Postcode is required">
                        <span class="label-input100">Postcode</span>
                        <input class="input100" type="text" name="zip" id="zip" placeholder="Postcode">
                        <span class="focus-input100"></span>
                        <span id="zip-error" class="text-danger"></span>
                    </div>
                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" type="submit">
                                Sign Up
                            </button>
                        </div>
                        <a href="signin_form.php" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30">
                            Sign in
                            <i class="fa fa-long-arrow-right m-l-5"></i>
                        </a>
                        <a href="index.php" class="dis-block txt3 hov1 p-r-30 p-t-40 p-b-10 p-l-180">
                            Skip SignUp 
                            <i class="fa fa-long-arrow-right m-l-5"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/login_reg.js"></script>
    <script src="js/actions.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const repasswordInput = document.getElementById('repassword');
        const emailInput = document.getElementById('email');
        const mobileInput = document.getElementById('mobile');
        const zipInput = document.getElementById('zip');
        const passwordError = document.getElementById('password-error');
        const repasswordError = document.getElementById('repassword-error');
        const emailError = document.getElementById('email-error');
        const mobileError = document.getElementById('mobile-error');
        const zipError = document.getElementById('zip-error');
        
        passwordInput.addEventListener('input', validatePassword);
        repasswordInput.addEventListener('input', validatePasswordMatch);
        emailInput.addEventListener('input', validateEmail);
        mobileInput.addEventListener('input', validateMobile);
        zipInput.addEventListener('input', validateZip);

        function validatePassword() {
            const password = passwordInput.value;
            const passwordValidation = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (!passwordValidation.test(password)) {
                passwordError.textContent = 'Password must be at least 8 characters long, contain at least 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.';
            } else {
                passwordError.textContent = '';
            }
        }
        
        function validatePasswordMatch() {
            const password = passwordInput.value;
            const repassword = repasswordInput.value;
            if (password !== repassword) {
                repasswordError.textContent = 'Passwords do not match';
            } else {
                repasswordError.textContent = '';
            }
        }

        function validateEmail() {
            const email = emailInput.value;
            const emailValidation = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailValidation.test(email)) {
                emailError.textContent = 'Invalid email address';
            } else {
                emailError.textContent = '';
            }
        }

        function validateMobile() {
            const mobile = mobileInput.value;
            const mobileValidation = /^[0-9]{10}$/;
            if (!mobileValidation.test(mobile)) {
                mobileError.textContent = 'Mobile number must be 10 digits';
            } else {
                mobileError.textContent = '';
            }
        }

        function validateZip() {
            const zip = zipInput.value;
            const zipValidation = /^[0-9]{5}$/;
            if (!zipValidation.test(zip)) {
                zipError.textContent = 'Postcode number must be 5 digits';
            } else {
                zipError.textContent = '';
            }
        }
    });
    </script>
</body>
</html>
