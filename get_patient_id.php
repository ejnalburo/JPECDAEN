<?php
session_start();
include 'config.php';

  $patient_id = "";
  $valid = true;

  if(isset($_POST['patient_id']) && !empty($_POST['patient_id'])){
    $patient_id = mysqli_real_escape_string($conn,$_POST['patient_id']);
  }else{
    $valid = false;
    $error .= "* Patient ID is required.\n";
    $patient_id = '';
  }

  if($valid){

    $_SESSION['p_id'] = $patient_id;

    $data = array("valid"=>true, "msg"=>"Data dispensed.");
    echo json_encode($data);

  }else{
    $data = array("valid"=>false, "msg"=>"Data not inserted.");
      echo json_encode($data);
  }
?>
