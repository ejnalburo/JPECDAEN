<?php
include 'config.php';

	$user_id = "";
	$valid = true;

	if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
		$user_id = mysqli_real_escape_string($conn,$_POST['user_id']);
	}else{
 		$valid = false;
 		$error .= "* User ID is required.\n";
 		$user_id = '';
	}


	if($valid){

		$sql = "DELETE FROM users WHERE user_id = '$user_id'";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
