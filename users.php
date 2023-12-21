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
	            <li><a class="dropdown-item text-white bg-success" href="users.php">Users</a></li>
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
		<h2 class="text-black-50 mb-3">List of All Users</h2>
		<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUser"><i class='bx bx-plus-medical me-2'></i>Add User</button>
		<table id="myTable" class="display" style="width:100%">
		    <thead>
		        <tr>
		            <th>First Name</th>
		            <th>Last Name</th>
		        		<th>Username</th>
		            <th>Role</th>
		            <th>Email</th>
		            <th>Phone #</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php
            include 'config.php';
            $query = mysqli_query($conn, "SELECT * FROM users WHERE usertype != 'Admin' ORDER BY user_id DESC");

            while($data = mysqli_fetch_assoc($query)){  
          ?>
		        <tr>
		            <td><?php echo $data['firstname']; ?></td>
		            <td><?php echo $data['lastname']; ?></td>
		            <td><?php echo $data['username']; ?></td>
		            <td><?php echo $data['usertype']; ?></td>
		            <td><?php echo $data['email']; ?></td>
		            <td><?php echo $data['phone']; ?></td>
		            <td>
		            	<button class="btn btn-warning" onclick="editUser('<?php echo $data['user_id']; ?>','<?php echo $data['firstname']; ?>','<?php echo $data['lastname']; ?>','<?php echo $data['username']; ?>','<?php echo $data['usertype']; ?>','<?php echo $data['email']; ?>','<?php echo $data['phone']; ?>')"><i class='bx bxs-edit'></i>&nbsp;Edit</button>
		            	<button class="btn btn-danger" onclick="deleteUser('<?php echo $data['user_id']; ?>')"><i class='bx bxs-edit'></i>&nbsp;Delete</button>
		            </td>
		        </tr>
		      <?php
		      	}
		      ?>
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>First Name</th>
		            <th>Last Name</th>
		        		<th>Username</th>
		            <th>Role</th>
		            <th>Email</th>
		            <th>Phone #</th>
		            <th>Action</th>
		        </tr>
		    </tfoot>
		</table>
	</div>
	<!-- End of Tables -->


	<!-- Modal for Add User -->
	<div class="modal fade" id="addUser">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add User</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
					  <div class="col-md-6">
					  	<label class="form-label">First Name</label><span class="fst-italic text-danger firstname_err"></span>
					    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Last Name</label><span class="fst-italic text-danger lastname_err"></span>
					    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Username</label><span class="fst-italic text-danger username_err"></span>
					    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Phone #</label><span class="fst-italic text-danger phone_err"></span>
					    <input type="number" class="form-control" maxlength="11" name="phone" id="phone" placeholder="Phone #" required>
					  </div>
					  <div class="col-md-8">
					  	<label class="form-label">Email Address</label><span class="fst-italic text-danger email_err"></span>
					    <input type="text" class="form-control" name="email" id="email" placeholder="mail@example.com" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Role</label><span class="fst-italic text-danger role_err"></span>
					  	<select class="form-select" name="usertype" id="usertype" required>
					  		<option value=""><-- Please Select --></option>
					  		<option value="Admin">Admin</option>
					  		<option value="Nurse">Nurse</option>
					  	</select>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="insertUser" class="btn btn-warning"><i class='bx bx-edit me-2'></i>Add user</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->


	<!-- Modal for Edit User -->
	<div class="modal fade" id="editUser">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit User</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
	        	<input type="hidden" id="euser_id">
					  <div class="col-md-6">
					  	<label class="form-label">First Name</label><span class="fst-italic text-danger firstname_err"></span>
					    <input type="text" class="form-control" name="efirstname" id="efirstname" placeholder="First Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Last Name</label><span class="fst-italic text-danger lastname_err"></span>
					    <input type="text" class="form-control" name="elastname" id="elastname" placeholder="Last Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Username</label><span class="fst-italic text-danger username_err"></span>
					    <input type="text" class="form-control" name="eusername" id="eusername" placeholder="Username" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Phone #</label><span class="fst-italic text-danger phone_err"></span>
					    <input type="number" class="form-control" maxlength="11" name="ephone" id="ephone" placeholder="Phone #" required>
					  </div>
					  <div class="col-md-8">
					  	<label class="form-label">Email Address</label><span class="fst-italic text-danger email_err"></span>
					    <input type="text" class="form-control" name="eemail" id="eemail" placeholder="mail@example.com" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Role</label><span class="fst-italic text-danger role_err"></span>
					  	<select class="form-select" name="eusertype" id="eusertype" required>
					  		<option value=""><-- Please Select --></option>
					  		<option value="Admin">Admin</option>
					  		<option value="Nurse">Nurse</option>
					  	</select>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="saveUser" class="btn btn-warning"><i class='bx bx-edit me-2'></i>Save Changes</button>
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


  function editUser(user_id,firstname,lastname,username,usertype,email,phone){
  	var user_id = user_id;
  	var firstname = firstname;
  	var lastname = lastname;
  	var username = username;
  	var usertype = usertype;
  	var email = email;
  	var phone = phone;


  	$('#euser_id').val(user_id);
  	$('#efirstname').val(firstname);
  	$('#elastname').val(lastname);
  	$('#eusername').val(username);
  	$('#eusertype').val(usertype);
  	$('#eemail').val(email);
  	$('#ephone').val(phone);

  	$('#editUser').modal('show');
  }


  function deleteUser(user_id){
  	var user_id = user_id;

  	Swal.fire({
        title: 'Are you sure to delete user?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        user_id : user_id
      	};  

    		$.ajax({
        	url : "delete_user.php",
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
                document.location.href="users.php";
                }
              });
              asb();
            }        
          }
        });
      }
    });

  }


  $('#insertUser').click(function () {
  	var user_id = $('#user_id').val();
  	var firstname = $('#firstname').val();
  	var lastname = $('#lastname').val();
  	var username = $('#username').val();
  	var usertype = $('#usertype').val();
  	var email = $('#email').val();
  	var phone = $('#phone').val();
  	var valid = true;

  	if(firstname == ""){
  		valid = false;
      $(".firstname_err").html(" *Required");
  	}else{
  		$(".firstname_err").html("");
  	}

  	if(lastname == ""){
  		valid = false;
      $(".lastname_err").html(" *Required");
  	}else{
  		$(".lastname_err").html("");
  	}

  	if(username == ""){
  		valid = false;
      $(".username_err").html(" *Required");
  	}else{
  		$(".username_err").html("");
  	}

  	if(usertype == ""){
  		valid = false;
      $(".role_err").html(" *Required");
  	}else{
  		$(".role_err").html("");
  	}

  	if(email == ""){
  		valid = false;
      $(".email_err").html(" *Required");
  	}else{
  		$(".email_err").html("");
  	}

  	if(phone == ""){
  		valid = false;
      $(".phone_err").html(" *Required");
  	}else{
  		$(".phone_err").html("");
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
	        firstname : firstname,
	        lastname : lastname,
	        username : username,
	        usertype : usertype,
	        email : email,
	        phone : phone
      	};  

    		$.ajax({
        	url : "insert_user.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#addUser").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "User successfully added",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="users.php";
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


  $('#saveUser').click(function () {
  	var user_id = $('#euser_id').val();
  	var firstname = $('#efirstname').val();
  	var lastname = $('#elastname').val();
  	var username = $('#eusername').val();
  	var usertype = $('#eusertype').val();
  	var email = $('#eemail').val();
  	var phone = $('#ephone').val();
  	var valid = true;

  	if(firstname == ""){
  		valid = false;
      $(".firstname_err").html(" *Required");
  	}else{
  		$(".firstname_err").html("");
  	}

  	if(lastname == ""){
  		valid = false;
      $(".lastname_err").html(" *Required");
  	}else{
  		$(".lastname_err").html("");
  	}

  	if(username == ""){
  		valid = false;
      $(".username_err").html(" *Required");
  	}else{
  		$(".username_err").html("");
  	}

  	if(usertype == ""){
  		valid = false;
      $(".role_err").html(" *Required");
  	}else{
  		$(".role_err").html("");
  	}

  	if(email == ""){
  		valid = false;
      $(".email_err").html(" *Required");
  	}else{
  		$(".email_err").html("");
  	}

  	if(phone == ""){
  		valid = false;
      $(".phone_err").html(" *Required");
  	}else{
  		$(".phone_err").html("");
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
	      	user_id : user_id,
	        firstname : firstname,
	        lastname : lastname,
	        username : username,
	        usertype : usertype,
	        email : email,
	        phone : phone
      	};  

    		$.ajax({
        	url : "update_user.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#editUser").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "User successfully updated",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="users.php";
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