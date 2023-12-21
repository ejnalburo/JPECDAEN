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
	<title>JPECDAEN &mdash; Log In</title>
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

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Please enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>

					<div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							Forgot
						</span>

						<a href="#" class="txt2">
							Username / Password?
						</a>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn" id="login" name="login">
							Sign in
						</button>
					</div>

					<div class="flex-col-c p-t-20 p-b-40">
						<span class="txt1 p-b-9">
							Don’t have an account?
						</span>

						<a href="register.php" class="txt3">
							Sign up now
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
    include 'config.php';

    if (isset($_POST['login'])){
      
      $username = addslashes(trim($_POST['username']));
      $password = md5($_POST['password']);

      $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
      
        if (mysqli_num_rows($query) == 0) {
  ?>
          Swal.fire({
            title: 'Error!',
            text: 'No user found in this account! Please try again!',
            icon: 'warning',
            footer: '<h5>Please fill in all fields!</h5>'
          }).then(function() {
            window.location = "index.php";
          });
    
  <?php
        }else{
          $row = mysqli_fetch_assoc($query);
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['profile'] = $row['profile'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['usertype']  = $row['usertype'];
          $_SESSION['firstname']  = $row['firstname'];
          $_SESSION['lastname']  = $row['lastname'];

          if($row['usertype'] == "Admin"){ 
  ?>
            Swal.fire({
              title: 'Login Successful!',
              text: 'You will be redirected to Admin Panel',
              icon: 'success',
            }).then(function() {
              window.location = "admin_index.php";
            });  
  <?php
          }else if($row['usertype'] =="Nurse"){
  ?>
            Swal.fire({
              icon: 'success',
              title: 'Login Successful!',
              text: 'You will be redirected to Nurse Panel'
            }).then(function(){
              window.location = "nurse_index.php";
            });
<?php
          }else{
  ?>
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: ''
            }).then(function(){
              window.location = "index.php";
            });
  <?php
          }
        }
      }else{
    }
  ?>		
</script>
</body>
</html>