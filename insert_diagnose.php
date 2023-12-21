<?php
include 'config.php';

	$error = $patient_id = $service = $result = $prescription = "";
	$valid = true;

	if(isset($_POST['patient_id']) && !empty($_POST['patient_id'])){
		$patient_id = mysqli_real_escape_string($conn,$_POST['patient_id']);
	}else{
 		$valid = false;
 		$error .= "* Patient ID is required.\n";
 		$patient_id = '';
	}


	if(isset($_POST['service']) && !empty($_POST['service'])){
		$service = mysqli_real_escape_string($conn,$_POST['service']);
	}else{
 		$valid = false;
 		$error .= "* Service is required.\n";
 		$service = '';
	}

	if(isset($_POST['results']) && !empty($_POST['results'])){
		$result = mysqli_real_escape_string($conn,$_POST['results']);
	}else{
 		$valid = false;
 		$error .= "* Result is required.\n";
 		$result = '';
	}

	if(isset($_POST['prescription']) && !empty($_POST['prescription'])){
		$prescription = mysqli_real_escape_string($conn,$_POST['prescription']);
	}else{
 		$valid = false;
 		$error .= "* Prescription is required.\n";
 		$prescription = '';
	}


	if($valid){

		$sql = "INSERT INTO pethistory(`pethis_id`, `patient_id`, `check_date`,  `service`, `result`, `prescription`) VALUES(NULL, '$patient_id', CURDATE(), '$service', '$result', '$prescription')";
		
		$query = mysqli_query($conn, $sql); 

		$data = array("valid"=>true, "msg"=>"Data dispensed.");
		echo json_encode($data);

	}else{
 		$data = array("valid"=>false, "msg"=>"Data not inserted.");
 	    echo json_encode($data);
	}
?>
