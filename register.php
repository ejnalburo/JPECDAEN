<?php
error_reporting(0);
session_start();
if($_SESSION['usertype']=="Admin") {
    header("Location: admin_index.php");
}

elseif ($_SESSION['usertype']=="Nurse") {
    header("Location: nurse_index.php");
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<title>JPECDAEN &mdash; Sign Up</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="img/logo1.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<img src="img/logo.gif" class="w-50 mx-auto d-block" alt="">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-10" method="post">

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter firstname">
						<input class="input100" type="text" name="firstname" placeholder="First name" maxlength="50">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate = "Please enter lastname">
						<input class="input100" type="text" name="lastname" placeholder="Last name" maxlength="50">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate = "Please enter username">
						<input class="input100" type="text" name="username" placeholder="Username" maxlength="20">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate = "Please enter password">
						<input class="input100" type="password" name="password1" placeholder="Password" minlength="8">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate = "Please confirm password">
						<input class="input100" type="password" name="password2" placeholder="Confirm password" minlength="8">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate = "Please enter email">
						<input class="input100" type="email" name="email" placeholder="Email address">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" name="signup" class="login100-form-btn">
							Sign up
						</button>
					</div>

					<div class="flex-col-c p-t-20 p-b-40">
						<span class="txt1 p-b-9">
							Already have an account?
						</span>

						<a href="index.php" class="txt3">
							Sign in now
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
<?php
    session_start();
    if (isset($_POST['signup'])){
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if($password1 != $password2){
        ?>

            Swal.fire({
                title: 'Error!',
                text: 'Password not matched! Please try again',
                icon: 'warning'
            }).then(function() {
                window.location = "register.php";
            });

        <?php

        }else if($password1 == $password2){
            
            $username = addslashes(trim($_POST['username']));
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $password = md5($_POST['password1']);
            
            include 'config.php';

            $query1 = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
            $rows = mysqli_num_rows($query1);
            
            if($rows <= 0){

            	$query = mysqli_query($conn, "INSERT INTO `users` (user_id, email, username, password, firstname, lastname) VALUES (NULL, '".$email."', '".$username."', '".$password."', '".$firstname."', '".$lastname."')");

            	if(!$query){
            ?>
                	Swal.fire({
                		title: 'Error!',
                		text: 'Account not registered! Please try again',
                		icon: 'warning'
            		}).then(function() {
                		window.location = "register.php";
            		});
            <?php
            	}else{
            ?>
            		Swal.fire({
               	 		title: 'Success!',
                		text: 'Account Registered! Please login to continue',
                		icon: 'success'
            		}).then(function() {
                		window.location = "index.php";
            		});
        	<?php
            	}
        	}else{
        	 ?>
            		Swal.fire({
               	 		title: 'Error!',
                		text: 'Username Exists! Please try another username',
                		icon: 'danger'
            		}).then(function() {
                		window.location = "register.php";
            		});
        	<?php
        	}
    	}
    }
  ?>      
</script>
</script>
</body>
</html>