<?php
error_reporting(0);
session_start();
if($_SESSION['username']=="" || $_SESSION['usertype']!="Nurse") {
    header("Location: index.php");
    die();
}
?> 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>JPECDAEN &mdash; Nurse</title>
	<link rel="icon" href="img/logo1.ico">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
</head>
<body style="user-select: none;">	
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
	  <div class="container">
	    <a class="navbar-brand h1 bolder text-success" href="nurse_index.php">
	    	<img src="img/logo.gif" width="90" alt="">
	    	JPECDAEN
	    </a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="offcanvasExample">
	      <span class="navbar-toggler-icon text-success"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
	        <li class="nav-item">
	          <a class="h5 nav-link" aria-current="page" href="nurse_index.php">Dashboard</a>
	        </li>
	        <li class="nav-item">
	          <a class="h5 nav-link active text-success fw-bolder" href="nurse_appointments.php">Appointments</a>
	        </li>
	        <li class="nav-item">
	          <a class="h5 nav-link" href="nurse_inventory.php">Inventory</a>
	        </li>

	        <li class="nav-item dropdown ms-5">
	          <a class="h5 nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            User
	          </a>
	          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
	            <li><a class="dropdown-item text-success" href="nurse_profile.php">Profile</a></li>
	            <li><a class="dropdown-item text-success" href="nurse_settings.php">Settings</a></li>
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
		<h2 class="text-black-50 mb-3">List of All Appointments</h2>
		<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addAppointment"><i class='bx bx-plus-medical me-2'></i>Add Appointment</button>
		<table id="myTable" class="display" style="width:100%">
		    <thead>
		        <tr>
		            <th>Customer Name</th>
		            <th>Phone</th>
		            <th>Email</th>
		            <th>Address</th>
		            <th>Date</th>
		            <th>Time</th>
		            <th>Appointment Details</th>
		            <th>Actions</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php
            include 'config.php';
            $query = mysqli_query($conn, "SELECT * FROM appointments ORDER BY app_date, app_time DESC");

            while($data = mysqli_fetch_assoc($query)){  
          ?>
		        <tr>
		            <td><?php echo $data['name']; ?></td>
		            <td><?php echo $data['phone']; ?></td>
		            <td><?php echo $data['email']; ?></td>
		            <td><?php echo $data['address']; ?></td>
		            <td><?php echo $data['app_date']; ?></td>
		            <td><?php echo $data['app_time']; ?></td>
		            <td><?php echo $data['app_details']; ?></td>
		            <td>
		            	<button class="btn btn-warning" onclick="editApp('<?php echo $data['app_id']; ?>','<?php echo $data['name']; ?>','<?php echo $data['phone']; ?>','<?php echo $data['email']; ?>','<?php echo $data['address']; ?>','<?php echo $data['app_date']; ?>','<?php echo $data['app_time']; ?>','<?php echo $data['app_details']; ?>')"><i class='bx bxs-edit'></i>&nbsp;Edit</button>
		            	<button class="btn btn-danger"onclick="deleteApp('<?php echo $data['app_id']; ?>')"><i class='bx bx-calendar-minus'></i>&nbsp;Cancel</button>
		            </td>
		        </tr>
		      <?php
		      	}
		      ?>
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>Customer Name</th>
		            <th>Phone</th>
		            <th>Email</th>
		            <th>Address</th>
		            <th>Date</th>
		            <th>Time</th>
		            <th>Appointment Details</th>
		            <th>Actions</th>
		        </tr>
		    </tfoot>
		</table>
	</div>
	<!-- End of Tables -->

	<!-- Modal for Add Appointment -->
	<div class="modal fade" id="addAppointment">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add Appointment</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
					  <div class="col-md-6">
					  	<label class="form-label">Customer Name</label><span class="fst-italic text-danger name_err"></span>
					    <input type="text" class="form-control" name="name" id="name" placeholder="Customer Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Address</label><span class="fst-italic text-danger address_err"></span>
					    <input type="text" class="form-control" name="address" id="address" placeholder="Current Address" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Phone #</label><span class="fst-italic text-danger phone_err"></span>
					    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phoner Number" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Email</label><span class="fst-italic text-danger email_err"></span>
					    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Appointment Time</label><span class="fst-italic text-danger app_time_err"></span>
					    <input type="time" class="form-control" name="app_time" id="app_time" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Appointment Date</label><span class="fst-italic text-danger app_date_err"></span>
					    <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="app_date" id="app_date" required>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Appointment details</label><span class="fst-italic text-danger app_details_err"></span>
					    <textarea class="form-control" rows="4" name="app_details" id="app_details" required></textarea>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="addApp" class="btn btn-success"><i class='bx bx-plus me-2'></i>Add Product</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->


	<!-- Modal for Edit Appointment -->
	<div class="modal fade" id="editAppointment">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit Appointment</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
	        	<input type="hidden" name="eapp_id" id="eapp_id">
					  <div class="col-md-6">
					  	<label class="form-label">Customer Name</label><span class="fst-italic text-danger name_err"></span>
					    <input type="text" class="form-control" name="ename" id="ename" placeholder="Customer Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Address</label><span class="fst-italic text-danger address_err"></span>
					    <input type="text" class="form-control" name="eaddress" id="eaddress" placeholder="Current Address" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Phone #</label><span class="fst-italic text-danger phone_err"></span>
					    <input type="text" class="form-control" name="ephone" id="ephone" placeholder="Phoner Number" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Email</label><span class="fst-italic text-danger email_err"></span>
					    <input type="email" class="form-control" name="eemail" id="eemail" placeholder="Email Address" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Appointment Time</label><span class="fst-italic text-danger app_time_err"></span>
					    <input type="time" class="form-control" name="eapp_time" id="eapp_time" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Appointment Date</label><span class="fst-italic text-danger app_date_err"></span>
					    <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="eapp_date" id="eapp_date" required>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Appointment details</label><span class="fst-italic text-danger app_details_err"></span>
					    <textarea class="form-control" rows="4" name="eapp_details" id="eapp_details" required></textarea>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="saveApp" class="btn btn-success"><i class='bx bx-edit me-2'></i>Save Changes</button>
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
        ordering: false
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

  function editApp(app_id, name, phone, email, address, app_date, app_time, app_details){
  	var app_id = app_id;
  	var name = name;
  	var phone = phone;
  	var email = email;
  	var address = address;
  	var app_date = app_date;
  	var app_time = app_time;
  	var app_details = app_details;

  	$('#eapp_id').val(app_id);
  	$('#ename').val(name);
  	$('#ephone').val(phone);
  	$('#eemail').val(email);
  	$('#eaddress').val(address);
  	$('#eapp_date').val(app_date);
  	$('#eapp_time').val(app_time);
  	$('#eapp_details').val(app_details);

  	$('#editAppointment').modal('show');
  }


  function deleteApp(app_id){
		var app_id = app_id;
		Swal.fire({
        title: 'Are you sure to delete appointment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        allowOutsideClick: false
      }).then((result) => {
        if (result.isConfirmed) {
			    var form_data = {
			    	app_id : app_id
	      	}; 
          $.ajax({
        	url : "delete_appointment.php",
        	type : "POST",
        	data: form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              document.location.href = "nurse_appointments.php";
            }else{
            	document.location.href = "nurse_appointments.php";
            }        
          }
        });
        }
      });
	}

  $('#addApp').click(function () {
  	var name = $('#name').val();
  	var phone = $('#phone').val();
  	var email = $('#email').val();
  	var address = $('#address').val();
  	var app_date = $('#app_date').val();
  	var app_time = $('#app_time').val();
  	var app_details = $('#app_details').val();
  	var valid = true;

  	if(name == ""){
  		valid = false;
      $(".name_err").html(" *Required");
  	}else{
  		$(".name_err").html("");
  	}

  	if(phone == ""){
  		valid = false;
      $(".phone_err").html(" *Required");
  	}else{
  		$(".phone_err").html("");
  	}

  	if(email == ""){
  		valid = false;
      $(".email_err").html(" *Required");
  	}else{
  		$(".email_err").html("");
  	}

  	if(address == ""){
  		valid = false;
      $(".address_err").html(" *Required");
  	}else{
  		$(".address_err").html("");
  	}

  	if(app_date == ""){
  		valid = false;
      $(".app_date_err").html(" *Required");
  	}else{
  		$(".app_date_err").html("");
  	}

  	if(app_time == ""){
  		valid = false;
      $(".app_time_err").html(" *Required");
  	}else{
  		$(".app_time_err").html("");
  	}

  	if(app_details == ""){
  		valid = false;
      $(".app_details_err").html(" *Required");
  	}else{
  		$(".app_details_err").html("");
  	}

  	if(valid){
  		Swal.fire({
        title: 'Are you sure to book appointment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        name : name,
	        phone : phone,
	        email : email,
	        address : address,
	        app_date : app_date,
	        app_time : app_time,
	        app_details : app_details
      	};  

    		$.ajax({
        	url : "insert_appointment.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#addApp").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Appointment successfully booked",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="nurse_appointments.php";
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


  $('#saveApp').click(function () {
  	var app_id = $('#eapp_id').val();
  	var name = $('#ename').val();
  	var phone = $('#ephone').val();
  	var email = $('#eemail').val();
  	var address = $('#eaddress').val();
  	var app_date = $('#eapp_date').val();
  	var app_time = $('#eapp_time').val();
  	var app_details = $('#eapp_details').val();
  	var valid = true;

  	if(name == ""){
  		valid = false;
      $(".name_err").html(" *Required");
  	}else{
  		$(".name_err").html("");
  	}

  	if(phone == ""){
  		valid = false;
      $(".phone_err").html(" *Required");
  	}else{
  		$(".phone_err").html("");
  	}

  	if(email == ""){
  		valid = false;
      $(".email_err").html(" *Required");
  	}else{
  		$(".email_err").html("");
  	}

  	if(address == ""){
  		valid = false;
      $(".address_err").html(" *Required");
  	}else{
  		$(".address_err").html("");
  	}

  	if(app_date == ""){
  		valid = false;
      $(".app_date_err").html(" *Required");
  	}else{
  		$(".app_date_err").html("");
  	}

  	if(app_time == ""){
  		valid = false;
      $(".app_time_err").html(" *Required");
  	}else{
  		$(".app_time_err").html("");
  	}

  	if(app_details == ""){
  		valid = false;
      $(".app_details_err").html(" *Required");
  	}else{
  		$(".app_details_err").html("");
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
	      	app_id : app_id,
	        name : name,
	        phone : phone,
	        email : email,
	        address : address,
	        app_time : app_time,
	        app_date : app_date,
	        app_details : app_details
      	};  

    		$.ajax({
        	url : "update_appointment.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#editAppointment").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Appointment successfully updated",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="nurse_appointments.php";
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