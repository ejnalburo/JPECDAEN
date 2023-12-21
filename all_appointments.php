<?php
	include 'config.php';

	$sql = "SELECT * FROM appointments";
		
	$query = mysqli_query($conn, $sql); 

	$data = mysqli_fetch_assoc($query);

	json_encode($data);
?>