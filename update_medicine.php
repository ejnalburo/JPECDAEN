<?php
include 'config.php';

	$med_id = $med_brand = $med_name = $med_supplier =  $unit =  $qty =  $price =  $exp_date = "";
	$valid = true;

	if(isset($_POST['med_brand']) && !empty($_POST['med_brand'])){
		$med_brand = mysqli_real_escape_string($conn,$_POST['med_brand']);
	}else{
 		$valid = false;
 		$error .= "* Brand Name is required.\n";
 		$med_brand = '';
	}


	if(isset($_POST['med_name']) && !empty($_POST['med_name'])){
		$med_name = mysqli_real_escape_string($conn,$_POST['med_name']);
	}else{
 		$valid = false;
 		$error .= "* Product Name is required.\n";
 		$med_name = '';
	}

	if(isset($_POST['med_supplier']) && !empty($_POST['med_supplier'])){
		$med_supplier = mysqli_real_escape_string($conn,$_POST['med_supplier']);
	}else{
 		$valid = false;
 		$error .= "* Supplier Name is required.\n";
 		$med_supplier = '';
	}

	if(isset($_POST['unit']) && !empty($_POST['unit'])){
		$unit = mysqli_real_escape_string($conn,$_POST['unit']);
	}else{
 		$valid = false;
 		$error .= "* Unit is required.\n";
 		$unit = '';
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

	if(isset($_POST['exp_date']) && !empty($_POST['exp_date'])){
		$exp_date = mysqli_real_escape_string($conn,$_POST['exp_date']);
	}else{
 		$valid = false;
 		$error .= "* Expiration Date is required.\n";
 		$exp_date = '';
	}

	$med_id = mysqli_real_escape_string($conn,$_POST['med_id']);


	if($valid){

		$sql = "UPDATE medicines SET med_brand = '$med_brand', med_name = '$med_name', med_supplier = '$med_supplier', unit = '$unit', qty = '$qty', price = '$price', exp_date = '$exp_date' WHERE med_id = '$med_id'";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
