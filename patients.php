<?php
error_reporting(0);
session_start();
if($_SESSION['username']=="" || $_SESSION['usertype']!="Admin") {
    header("Location: index.php");
    die();
}
?> 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>JPECDAEN &mdash; Admin</title>
	<link rel="icon" href="img/logo1.ico">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
</head>
<body style="user-select: none;">	
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
	  <div class="container">
	    <a class="navbar-brand h1 bolder text-success" href="admin_index.php">
	    	<img src="img/logo.gif" width="90" alt="">
	    	JPECDAEN
	    </a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="offcanvasExample">
	      <span class="navbar-toggler-icon text-success"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
	        <li class="nav-item">
	          <a class="h5 nav-link" aria-current="page" href="admin_index.php">Dashboard</a>
	        </li>
	        <li class="nav-item">
	          <a class="h5 nav-link" href="appointments.php">Appointments</a>
	        </li>
	        <li class="nav-item">
	          <a class="h5 nav-link" href="inventory.php">Inventory</a>
	        </li>
	        <li class="nav-item dropdown">
	          <a class="h5 nav-link dropdown-toggle active text-success fw-bolder" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            Others
	          </a>
	          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
	          	<li><a class="dropdown-item text-white bg-success" href="patients.php">Pet Patients</a></li>
	            <li><a class="dropdown-item text-success" href="users.php">Users</a></li>
	            <li><a class="dropdown-item text-success" href="services.php">Services</a></li>
	            <li><a class="dropdown-item text-success" href="reports.php">Reports</a></li>
	          </ul>
	        </li>

	        <li class="nav-item dropdown ms-5">
	          <a class="h5 nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            User
	          </a>
	          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
	            <li><a class="dropdown-item text-success" href="profile.php">Profile</a></li>
	            <li><a class="dropdown-item text-success" href="settings.php">Settings</a></li>
	            <li><hr class="dropdown-divider"></li>
	            <li><a class="dropdown-item text-success" href="#" onclick="logout()">Log out</a></li>
	          </ul>
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<!-- End of Navbar -->

	<!-- Tables -->
	<div class="container p-4 mb-5 border bg-light shadow p-3 rounded table-responsive">
		<h2 class="text-black-50 mb-3">List of All Pet Patients</h2>
		<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPatient"><i class='bx bx-plus-medical me-2'></i>Add Patient</button>
		<table id="aa" class="display" style="width:100%">
		    <thead>
		        <tr>
		            <th>Pet Name</th>
		            <th>Pet Breed</th>
		            <th>Owner's Name</th>
		            <th>Address</th>
		            <th>Phone #</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php
            include 'config.php';
            $query = mysqli_query($conn, "SELECT * FROM patients ORDER BY patient_id DESC");

            while($data = mysqli_fetch_assoc($query)){  
          ?>
		        <tr>
		            <td><?php echo $data['name']; ?></td>
		            <td><?php echo $data['breed']; ?></td>
		            <td><?php echo $data['owner']; ?></td>
		            <td><?php echo $data['address']; ?></td>
		            <td><?php echo $data['phone']; ?></td>
		            <td>
		            	<button class="btn btn-success" onclick="addDiagnosis('<?php echo $data['patient_id']; ?>')"><i class='bx bx-plus-medical' ></i>&nbsp;Diagnosis</button>
		            	<!-- <button class="btn btn-warning" onclick="viewHistory('<?php echo $data['patient_id']; ?>')"><i class='bx bx-history'></i>&nbsp;History</button> -->
		            </td>
		        </tr>
		      <?php
		      	}
		      ?>
		    </tbody>
		</table>
	</div>
	<!-- End of Tables -->

	<!-- Modal for Add Patient -->
	<div class="modal fade" id="addPatient">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add Patient</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
					  <div class="col-md-6">
					  	<label class="form-label">Name</label><span class="fst-italic text-danger name_err"></span>
					    <input type="text" class="form-control" name="name" id="name" placeholder="Pet Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Breed</label><span class="fst-italic text-danger breed_err"></span>
					    <input type="text" class="form-control" name="breed" id="breed" placeholder="Pet Breed" required>
					  </div>
					  <div class="col-md-8">
					  	<label class="form-label">Owner's Name</label><span class="fst-italic text-danger owner_err"></span>
					    <input type="text" class="form-control" name="owner" id="owner" placeholder="Owner's Full Name" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Phone #</label><span class="fst-italic text-danger phone_err"></span>
					    <input type="text" maxlength="11" class="form-control" name="phone" id="phone" placeholder="Owner's Phone #" required>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Address</label><span class="fst-italic text-danger address_err"></span>
					    <input type="text" class="form-control" name="address" id="address" placeholder="Owner's Full Address" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="addPa" class="btn btn-success"><i class='bx bx-plus me-2'></i>Add Patient</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->


	<!-- Modal for Add Diagnosis -->
	<div class="modal fade" id="openModal">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add Diagnosis</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
	        	<input type="hidden" id="bpatient_id">
					  <div class="col-md-12">
					  	<label class="form-label">Service</label><span class="fst-italic text-danger service_err"></span>
					    <select class="form-select" name="bservice" id="bservice" aria-label="Default select example">
							  <option value="" ><-- Select Service --></option>
							  <?php
				          include 'config.php';
				          $query = mysqli_query($conn, "SELECT * FROM services ORDER BY name ASC");

				          while($data = mysqli_fetch_assoc($query)){  
				        ?>
							  <option value="<?php echo $data['name'];?>"><?php echo $data['name'];?></option>
							  <?php 
						    	}
						    ?>
							</select>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Results</label><span class="fst-italic text-danger result_err"></span>
					    <textarea class="form-control" rows="5" name="bresult" id="bresult" placeholder="Results" required></textarea>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Prescription</label><span class="fst-italic text-danger prescription_err"></span>
					    <textarea class="form-control" rows="5" name="bprescription" id="bprescription" placeholder="Prescription" required></textarea>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="insertDiagnosis" class="btn btn-success"><i class='bx bx-plus me-2'></i>Submit</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->


	<!-- Modal for View History -->
	<div class="modal fade" id="viewHistory">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">History</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <table id="table2" class="" style="width: 100%;">
	        	<thead>
	        		<tr>
	        			<th>Date</th>
		        		<th>Service</th>
		        		<th>Results</th>
		        		<th>Prescriptions</th>
	        		</tr>
	        	</thead>
	        	<tbody>
	        		<?php
		            include 'config.php';
		            $pid = $_SESSION['p_id'];
		            $query = mysqli_query($conn, "SELECT * FROM pethistory WHERE patient_id = '".$pid."' ORDER BY check_date DESC");

		            while($data = mysqli_fetch_assoc($query)){  
		          ?>
	        		<tr>
	        			<td><?php echo $data['check_date']; ?></td>
	        			<td><?php echo $data['service']; ?></td>
	        			<td><?php echo $data['result']; ?></td>
	        			<td><?php echo $data['prescription']; ?></td>
	        		</tr>
	        		<?php
	        			}
	        		?>
	        	</tbody>
	        </table>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->
</body>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	$(document).ready( function () {
    	$('#aa').DataTable({
    		lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, 'All'],
        ],
        ordering: false
    	});

    	$('#table2').DataTable({
    		lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, 'All'],
        ],
        ordering: false
    	});
	});
	
	function logout() {
      Swal.fire({
        title: 'Are you sure you want to log out?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        allowOutsideClick: false
      }).then((result) => {
        if (result.isConfirmed) {
          document.location.href = "logout.php";
        }
      });
    }

    function viewHistory(patient_id){
    	var patient_id = patient_id;
    	var form_data = {
	        patient_id : patient_id
	    }

    		$.ajax({
        	url : "get_patient_id.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#viewHistory").modal('show');    
            }   
             
          }
        });
    }


    function addDiagnosis(patient_id){
    	var patient_id = patient_id; 
      $('#bpatient_id').val(patient_id);
      
      $("#openModal").modal('show');   
    }


    $('#addPa').click(function () {
  	var name = $('#name').val();
  	var breed = $('#breed').val();
  	var owner = $('#owner').val();
  	var phone = $('#phone').val();
  	var address = $('#address').val();
  	var valid = true;

  	if(name == ""){
  		valid = false;
      $(".name_err").html(" *Required");
  	}else{
  		$(".name_err").html("");
  	}

  	if(breed == ""){
  		valid = false;
      $(".breed_err").html(" *Required");
  	}else{
  		$(".breed_err").html("");
  	}

  	if(owner == ""){
  		valid = false;
      $(".owner_err").html(" *Required");
  	}else{
  		$(".owner_err").html("");
  	}

  	if(phone == ""){
  		valid = false;
      $(".phone_err").html(" *Required");
  	}else{
  		$(".phone_err").html("");
  	}

  	if(address == ""){
  		valid = false;
      $(".address_err").html(" *Required");
  	}else{
  		$(".address_err").html("");
  	}


  	if(valid){
  		Swal.fire({
        title: 'Are you sure to add patient?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        name : name,
	        breed : breed,
	        owner : owner,
	        phone : phone,
	        address : address
      	};  

    		$.ajax({
        	url : "insert_patient.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#addPatient").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Patient successfully added",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="patients.php";
                }
              });
              asb();
            }        
          }
        });
      }
    });
  	}else{
    	return false;
  	}
  });
</script>		
<script>
  $('#insertDiagnosis').click(function () {
  	var patient_id = $('#bpatient_id').val();
  	var service = $('#bservice').val();
  	var results = $('#bresult').val();
  	var prescription = $('#bprescription').val();
  	var valid = true;

  	if(service == ""){
  		valid = false;
      $(".service_err").html(" *Required");
  	}else{
  		$(".service_err").html("");
  	}

  	if(results == ""){
  		valid = false;
      $(".result_err").html(" *Required");
  	}else{
  		$(".result_err").html("");
  	}

  	if(prescription == ""){
  		valid = false;
      $(".prescription_err").html(" *Required");
  	}else{
  		$(".prescription_err").html("");
  	}

  	if(valid){
  		Swal.fire({
        title: 'Are you sure to add diagnosis?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        patient_id : patient_id,
	        service : service,
	        results : results,
	        prescription : prescription
      	};  

    		$.ajax({
        	url : "insert_diagnose.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#openModal").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Diagnosis added",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="patients.php";
                }
              });
            }        
          }
        });
      }
    });
  	}else{
    	return false;
  	}
  });
</script>		
</html>