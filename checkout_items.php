<?php
include 'config.php';

	$transaction_id = uniqid();

	$valid = true;


	if($valid){

		$sql = "UPDATE sales SET transaction_id = '$transaction_id', transaction_date = CURDATE() WHERE transaction_id = '0'";
		
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
