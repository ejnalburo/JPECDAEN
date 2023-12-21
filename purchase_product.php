<?php
include 'config.php';

	$brand = $name =  $unit =  $qty =  $price = $error = "";
	$pr_id = $total = 0;

	$valid = true;

	if(isset($_POST['pr_id']) && !empty($_POST['pr_id'])){
		$pr_id = mysqli_real_escape_string($conn,$_POST['pr_id']);
	}else{
 		$valid = false;
 		$error .= "* Brand Name is required.\n";
 		$pr_id = '';
	}

	if(isset($_POST['brand']) && !empty($_POST['brand'])){
		$brand = mysqli_real_escape_string($conn,$_POST['brand']);
	}else{
 		$valid = false;
 		$error .= "* Brand Name is required.\n";
 		$brand = '';
	}


	if(isset($_POST['name']) && !empty($_POST['name'])){
		$name = mysqli_real_escape_string($conn,$_POST['name']);
	}else{
 		$valid = false;
 		$error .= "* Name is required.\n";
 		$name = '';
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

	$total = (int)$qty*(float)$price;


	if($valid){

		$sql0 = "UPDATE products SET qty = qty-'$qty' WHERE pr_id = '$pr_id'";
		
		$query0 = mysqli_query($conn, $sql0); 


		$sql = "INSERT INTO sales(`sales_id`, `transaction_id`, `pr_id`, `brand`, `name`, `unit`, `qty`, `price`, `total`) VALUES(NULL, '0', '$pr_id', '$brand', '$name',  '$unit', '$qty', '$price', '$total')";
		
		$query = mysqli_query($conn, $sql); 

		if($query){
			$sql5 = "SELECT *  FROM sales WHERE sales_id = (SELECT MAX(sales_id) FROM sales)";
			$query5 = mysqli_query($conn, $sql5);

			if($query5){
				$data = mysqli_fetch_assoc($query5);
	 			echo json_encode($data);
			}
		}else{
			$data = array("valid"=>false, "msg"=>"Data not inserted.");
			echo json_encode($data);
		}

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
