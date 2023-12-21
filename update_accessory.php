<?php
include 'config.php';

	$acc_id = $acc_brand = $acc_name = $acc_supplier =  $qty =  $price =  "";
	$valid = true;

	if(isset($_POST['acc_brand']) && !empty($_POST['acc_brand'])){
		$acc_brand = mysqli_real_escape_string($conn,$_POST['acc_brand']);
	}else{
 		$valid = false;
 		$error .= "* Brand Name is required.\n";
 		$acc_brand = '';
	}


	if(isset($_POST['acc_name']) && !empty($_POST['acc_name'])){
		$acc_name = mysqli_real_escape_string($conn,$_POST['acc_name']);
	}else{
 		$valid = false;
 		$error .= "* Product Name is required.\n";
 		$acc_name = '';
	}

	if(isset($_POST['acc_supplier']) && !empty($_POST['acc_supplier'])){
		$acc_supplier = mysqli_real_escape_string($conn,$_POST['acc_supplier']);
	}else{
 		$valid = false;
 		$error .= "* Supplier Name is required.\n";
 		$acc_supplier = '';
	}

	if(isset($_POST['qty']) && !empty($_POST['qty'])){
		$qty = mysqli_real_escape_string($conn,$_POST['qty']);
	}else{
 		$valid = false;
 		$error .= "* Quantity is required.\n";
 		$qty = '';
	}

	if(isset($_POST['price']) && !empty($_POST['price'])){
		$price = mysqli_real_escape_string($conn,$_POST['price']);
	}else{
 		$valid = false;
 		$error .= "* Price is required.\n";
 		$price = '';
	}

	$acc_id = mysqli_real_escape_string($conn,$_POST['acc_id']);


	if($valid){

		$sql = "UPDATE accessories SET acc_brand = '$acc_brand', acc_name = '$acc_name', acc_supplier = '$acc_supplier', qty = '$qty', price = '$price' WHERE acc_id = '$acc_id'";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
