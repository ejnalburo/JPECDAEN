<?php
include 'config.php';

	$name = $breed = $owner =  $phone =  $address =  "";
	$valid = true;

	if(isset($_POST['name']) && !empty($_POST['name'])){
		$name = mysqli_real_escape_string($conn,$_POST['name']);
	}else{
 		$valid = false;
 		$error .= "* Pet Name is required.\n";
 		$name = '';
	}


	if(isset($_POST['breed']) && !empty($_POST['breed'])){
		$breed = mysqli_real_escape_string($conn,$_POST['breed']);
	}else{
 		$valid = false;
 		$error .= "* Pet Breed is required.\n";
 		$breed = '';
	}

	if(isset($_POST['owner']) && !empty($_POST['owner'])){
		$owner = mysqli_real_escape_string($conn,$_POST['owner']);
	}else{
 		$valid = false;
 		$error .= "* Owner's Name is required.\n";
 		$owner = '';
	}

	if(isset($_POST['phone']) && !empty($_POST['phone'])){
		$phone = mysqli_real_escape_string($conn,$_POST['phone']);
	}else{
 		$valid = false;
 		$error .= "* Owner's Phone # is required.\n";
 		$phone = '';
	}

	if(isset($_POST['address']) && !empty($_POST['address'])){
		$address = mysqli_real_escape_string($conn,$_POST['address']);
	}else{
 		$valid = false;
 		$error .= "* Owner's Address is required.\n";
 		$address = '';
	}


	if($valid){

		$sql = "INSERT INTO patients(`patient_id`, `name`, `breed`, `owner`, `phone`, `address`) VALUES(NULL, '$name', '$breed', '$owner', '$phone', '$address')";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
