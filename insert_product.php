<?php
include 'config.php';

	$pr_brand = $pr_name = $pr_supplier =  $unit =  $qty =  $price =  $exp_date = "";
	$valid = true;

	if(isset($_POST['pr_brand']) && !empty($_POST['pr_brand'])){
		$pr_brand = mysqli_real_escape_string($conn,$_POST['pr_brand']);
	}else{
 		$valid = false;
 		$error .= "* Brand Name is required.\n";
 		$pr_brand = '';
	}


	if(isset($_POST['pr_name']) && !empty($_POST['pr_name'])){
		$pr_name = mysqli_real_escape_string($conn,$_POST['pr_name']);
	}else{
 		$valid = false;
 		$error .= "* Product Name is required.\n";
 		$pr_name = '';
	}

	if(isset($_POST['pr_supplier']) && !empty($_POST['pr_supplier'])){
		$pr_supplier = mysqli_real_escape_string($conn,$_POST['pr_supplier']);
	}else{
 		$valid = false;
 		$error .= "* Supplier Name is required.\n";
 		$pr_supplier = '';
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

	if($valid){

		$sql = "INSERT INTO products(`pr_id`, `pr_brand`, `pr_name`, `pr_supplier`, `unit`, `qty`, `price`, `exp_date`, `date`) VALUES(NULL, '$pr_brand', '$pr_name', '$pr_supplier', '$unit', '$qty', '$price', '$exp_date', CURDATE(	))";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
