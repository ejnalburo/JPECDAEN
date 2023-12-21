<?php
include 'config.php';

	$srvc_id = "";
	$valid = true;

	if(isset($_POST['srvc_id']) && !empty($_POST['srvc_id'])){
		$srvc_id = mysqli_real_escape_string($conn,$_POST['srvc_id']);
	}else{
 		$valid = false;
 		$error .= "* Service ID is required.\n";
 		$srvc_id = '';
	}


	if($valid){

		$sql = "DELETE FROM services WHERE srvc_id = '$srvc_id'";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
