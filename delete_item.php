<?php
include 'config.php';

	$sales_id = mysqli_real_escape_string($conn,$_POST['sales_id']);
	$pr_id = mysqli_real_escape_string($conn,$_POST['pr_id']);
	$acc_id = mysqli_real_escape_string($conn,$_POST['acc_id']);
	$med_id = mysqli_real_escape_string($conn,$_POST['med_id']);
	$qty = mysqli_real_escape_string($conn,$_POST['qty']);

	$valid = true;


	if($valid){

		$sql00 = "UPDATE products SET qty = qty+'$qty' WHERE pr_id = '$pr_id'";
		$query00 = mysqli_query($conn, $sql00); 

		$sql01 = "UPDATE accessories SET qty = qty+'$qty' WHERE acc_id = '$acc_id'";
		$query01 = mysqli_query($conn, $sql01); 

		$sql02 = "UPDATE medicines SET qty = qty+'$qty' WHERE med_id = '$med_id'";
		$query02 = mysqli_query($conn, $sql02); 


		$sql = "DELETE FROM sales WHERE sales_id = '$sales_id' AND transaction_id = '0'";
		$query = mysqli_query($conn, $sql);

		$data = array("valid"=>false, "msg"=>"Data not inserted.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
