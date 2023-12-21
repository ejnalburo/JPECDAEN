<?php
include 'config.php';

	$app_id = $name = $phone = $email =  $address =  $app_date =  $app_time =  $app_details = "";
	$valid = true;

	if(isset($_POST['name']) && !empty($_POST['name'])){
		$name = mysqli_real_escape_string($conn,$_POST['name']);
	}else{
 		$valid = false;
 		$error .= "* Customer Name is required.\n";
 		$name = '';
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

	if(isset($_POST['app_date']) && !empty($_POST['app_date'])){
		$app_date = mysqli_real_escape_string($conn,$_POST['app_date']);
	}else{
 		$valid = false;
 		$error .= "* Appointment Date is required.\n";
 		$app_date = '';
	}

	if(isset($_POST['app_time']) && !empty($_POST['app_time'])){
		$app_time = mysqli_real_escape_string($conn,$_POST['app_time']);
	}else{
 		$valid = false;
 		$error .= "* Appointment Time is required.\n";
 		$app_time = '';
	}

	if(isset($_POST['app_details']) && !empty($_POST['app_details'])){
		$app_details = mysqli_real_escape_string($conn,$_POST['app_details']);
	}else{
 		$valid = false;
 		$error .= "* Appointment Details is required.\n";
 		$app_details = '';
	}

	$app_id = mysqli_real_escape_string($conn,$_POST['app_id']);


	if($valid){

		$sql = "UPDATE appointments SET name = '$name', phone = '$phone', email = '$email', address = '$address', app_date = '$app_date', app_time = '$app_time', app_details = '$app_details' WHERE app_id = '$app_id'";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
