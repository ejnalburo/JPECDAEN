<?php
include 'config.php';

	$username = $phone = $email =  $address =  $firstname =  $lastname =  $experiences = "";
	$user_id;
	$valid = true;

	if(isset($_POST['username']) && !empty($_POST['username'])){
		$username = mysqli_real_escape_string($conn,$_POST['username']);
	}else{
 		$valid = false;
 		$error .= "* User Name is required.\n";
 		$username = '';
	}

	if(isset($_POST['firstname']) && !empty($_POST['firstname'])){
		$firstname = mysqli_real_escape_string($conn,$_POST['firstname']);
	}else{
 		$valid = false;
 		$error .= "* First Name is required.\n";
 		$firstname = '';
	}

	if(isset($_POST['lastname']) && !empty($_POST['lastname'])){
		$lastname = mysqli_real_escape_string($conn,$_POST['lastname']);
	}else{
 		$valid = false;
 		$error .= "* Last Name is required.\n";
 		$lastname = '';
	}


	if(isset($_POST['phone']) && !empty($_POST['phone'])){
		$phone = mysqli_real_escape_string($conn,$_POST['phone']);
	}else{
 		$valid = false;
 		$error .= "* Phone Number is required.\n";
 		$phone = '';
	}

	if(isset($_POST['email']) && !empty($_POST['email'])){
		$email = mysqli_real_escape_string($conn,$_POST['email']);
	}else{
 		$valid = false;
 		$error .= "* Email Address is required.\n";
 		$email = '';
	}

	if(isset($_POST['address']) && !empty($_POST['address'])){
		$address = mysqli_real_escape_string($conn,$_POST['address']);
	}else{
 		$valid = false;
 		$error .= "* Current Address is required.\n";
 		$address = '';
	}

	if(isset($_POST['experiences']) && !empty($_POST['experiences'])){
		$experiences = mysqli_real_escape_string($conn,$_POST['experiences']);
	}else{
 		$valid = false;
 		$error .= "* Experiences is required.\n";
 		$experiences = '';
	}


	$user_id = mysqli_real_escape_string($conn,$_POST['user_id']);


	if($valid){

		$sql = "UPDATE users SET username = '$username', phone = '$phone', email = '$email', address = '$address', firstname = '$firstname', lastname = '$lastname', experiences = '$experiences' WHERE user_id = '$user_id'";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
