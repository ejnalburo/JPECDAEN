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
	          	<li><a class="dropdown-item text-success" href="patients.php">Pet Patients</a></li>
	            <li><a class="dropdown-item text-success" href="users.php">Users</a></li>
	            <li><a class="dropdown-item text-white bg-success" href="services.php">Services</a></li>
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
		<h2 class="text-black-50 mb-3">List of All Services</h2>
		<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addService"><i class='bx bx-plus-medical me-2'></i>Add Service</button>
		<table id="myTable" class="display" style="width:100%">
		    <thead>
		        <tr>
		            <th>Service</th>
		            <th>Description</th>
		            <th>Fee</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php
            include 'config.php';
            $query = mysqli_query($conn, "SELECT * FROM services ORDER BY name ASC");

            while($data = mysqli_fetch_assoc($query)){  
          ?>
		        <tr>
		            <td><?php echo $data['name']; ?></td>
		            <td><?php echo $data['description']; ?></td>
		            <td>₱<?php echo $data['fee']; ?></td>
		            <td>
		            	<button class="btn btn-warning" onclick="editService('<?php echo $data['srvc_id']; ?>','<?php echo $data['name']; ?>','<?php echo $data['description']; ?>','<?php echo $data['fee']; ?>')"><i class='bx bxs-edit'></i>&nbsp;Edit</button>
		            	<button class="btn btn-danger" onclick="deleteService('<?php echo $data['srvc_id']; ?>')"><i class='bx bxs-edit'></i>&nbsp;Delete</button>
		            </td>
		        </tr>
		      <?php
		      	}
		      ?>
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>Service</th>
		            <th>Description</th>
		            <th>Fee</th>
		            <th>Action</th>
		        </tr>
		    </tfoot>
		</table>
	</div>
	<!-- End of Tables -->

	<!-- Modal for Add Service -->
	<div class="modal fade" id="addService">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add Service</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
					  <div class="col-md-12">
					  	<label class="form-label">Service</label><span class="fst-italic text-danger name_err"></span>
					    <input type="text" class="form-control" name="name" id="name" placeholder="Service" required>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Description</label><span class="fst-italic text-danger description_err"></span>
					    <textarea class="form-control" rows="7" name="description" id="description" placeholder="Description" required></textarea>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Fee</label><span class="fst-italic text-danger fee_err"></span>
					    <input type="text" class="form-control" name="fee" id="fee" placeholder="Fee" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="insertService" class="btn btn-warning"><i class='bx bx-edit me-2'></i>Add user</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->


	<!-- Modal for Edit Service -->
	<div class="modal fade" id="editService">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit Service</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
	        	<input type="hidden" id="esrvc_id">
					  <div class="col-md-12">
					  	<label class="form-label">Service</label><span class="fst-italic text-danger name_err"></span>
					    <input type="text" class="form-control" name="ename" id="ename" placeholder="Service" required>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Description</label><span class="fst-italic text-danger description_err"></span>
					    <textarea class="form-control" rows="7" name="edescription" id="edescription" placeholder="Description" required></textarea>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Fee</label><span class="fst-italic text-danger fee_err"></span>
					    <input type="text" class="form-control" name="efee" id="efee" placeholder="Fee" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="saveService" class="btn btn-warning"><i class='bx bx-edit me-2'></i>Save Changes</button>
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
    	$('#myTable').DataTable({
    		lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, 'All'],
        ],
    	});
	} );
	
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


  function editService(srvc_id,name,description,fee){
  	var srvc_id = srvc_id;
  	var name = name;
  	var description = description;
  	var fee = fee;


  	$('#esrvc_id').val(srvc_id);
  	$('#ename').val(name);
  	$('#edescription').val(description);
  	$('#efee').val(fee);

  	$('#editService').modal('show');
  }


  function deleteService(srvc_id){
  	var srvc_id = srvc_id;

  	Swal.fire({
        title: 'Are you sure to delete service?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        srvc_id : srvc_id
      	};  

    		$.ajax({
        	url : "delete_service.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              Swal.fire({
                title: 'Success!',
                text: "User successfully deleted",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="services.php";
                }
              });
              asb();
            }        
          }
        });
      }
    });

  }


  $('#insertService').click(function () {
  	var name = $('#name').val();
  	var description = $('#description').val();
  	var fee = $('#fee').val();
  	var valid = true;

  	if(name == ""){
  		valid = false;
      $(".name_err").html(" *Required");
  	}else{
  		$(".name_err").html("");
  	}

  	if(description == ""){
  		valid = false;
      $(".description_err").html(" *Required");
  	}else{
  		$(".description_err").html("");
  	}

  	if(fee == ""){
  		valid = false;
      $(".fee_err").html(" *Required");
  	}else{
  		$(".fee_err").html("");
  	}

  	if(valid){
  		Swal.fire({
        title: 'Are you sure to add user?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        name : name,
	        description : description,
	        fee : fee
      	};  

    		$.ajax({
        	url : "insert_service.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#addService").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Service successfully added",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="services.php";
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


  $('#saveService').click(function () {
  	var srvc_id = $('#esrvc_id').val();
  	var name = $('#ename').val();
  	var description = $('#edescription').val();
  	var fee = $('#efee').val();
  	var valid = true;

  	if(name == ""){
  		valid = false;
      $(".name_err").html(" *Required");
  	}else{
  		$(".name_err").html("");
  	}

  	if(description == ""){
  		valid = false;
      $(".description_err").html(" *Required");
  	}else{
  		$(".description_err").html("");
  	}

  	if(fee == ""){
  		valid = false;
      $(".fee_err").html(" *Required");
  	}else{
  		$(".fee_err").html("");
  	}

  	if(valid){
  		Swal.fire({
        title: 'Are you sure to save changes?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	      	srvc_id : srvc_id,
	        name : name,
	        description : description,
	        fee : fee
      	};  

    		$.ajax({
        	url : "update_service.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#editService").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Service successfully updated",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="services.php";
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
</html>