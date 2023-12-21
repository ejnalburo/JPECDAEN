<?php
include 'config.php';

	$user_id = $firstname = $lastname = $username =  $usertype =  $email =  $phone = "";
	$valid = true;

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

	if(isset($_POST['username']) && !empty($_POST['username'])){
		$username = mysqli_real_escape_string($conn,$_POST['username']);
	}else{
 		$valid = false;
 		$error .= "* Username is required.\n";
 		$username = '';
	}

	if(isset($_POST['usertype']) && !empty($_POST['usertype'])){
		$usertype = mysqli_real_escape_string($conn,$_POST['usertype']);
	}else{
 		$valid = false;
 		$error .= "* User Type is required.\n";
 		$usertype = '';
	}

	if(isset($_POST['email']) && !empty($_POST['email'])){
		$email = mysqli_real_escape_string($conn,$_POST['email']);
	}else{
 		$valid = false;
 		$error .= "* Email is required.\n";
 		$email = '';
	}

	if(isset($_POST['phone']) && !empty($_POST['phone'])){
		$phone = mysqli_real_escape_string($conn,$_POST['phone']);
	}else{
 		$valid = false;
 		$error .= "* Phone is required.\n";
 		$phone = '';
	}

	$user_id = mysqli_real_escape_string($conn,$_POST['user_id']);


	if($valid){

		$sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', username = '$username', usertype = '$usertype', email = '$email', phone = '$phone' WHERE user_id = '$user_id'";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
