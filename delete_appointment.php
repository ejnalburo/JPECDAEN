<?php
include 'config.php';

	$app_id = mysqli_real_escape_string($conn,$_POST['app_id']);

	$valid = true;


	if($valid){

		$sql = "DELETE FROM appointments WHERE app_id = '$app_id'";
		$query = mysqli_query($conn, $sql);

		$data = array("valid"=>false, "msg"=>"Data not inserted.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
