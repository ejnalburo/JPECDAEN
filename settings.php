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
	          <a class="h5 nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            Others
	          </a>
	          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
	          	<li><a class="dropdown-item text-success" href="patients.php">Pet Patients</a></li>
	            <li><a class="dropdown-item text-success" href="users.php">Users</a></li>
	            <li><a class="dropdown-item text-success" href="services.php">Services</a></li>
	            <li><a class="dropdown-item text-success" href="reports.php">Reports</a></li>
	          </ul>
	        </li>

	        <li class="nav-item dropdown ms-5">
	          <a class="h5 nav-link dropdown-toggle active text-success fw-bolder" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            User
	          </a>
	          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
	            <li><a class="dropdown-item text-success" href="profile.php">Profile</a></li>
	            <li><a class="dropdown-item text-white bg-success" href="settings.php">Settings</a></li>
	            <li><hr class="dropdown-divider"></li>
	            <li><a class="dropdown-item text-success" href="#" onclick="logout()">Log out</a></li>
	          </ul>
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<!-- End of Navbar -->

	<!-- Jumbotron -->
	<div class="container p-4 mb-5 border bg-light shadow p-3 rounded table-responsive">
		<h4 class="text-black-50 mb-3">Account Settings</h4>
		<button class="btn btn-success mb-3"  data-bs-toggle="modal" data-bs-target="#changePassword"><i class='bx bxs-lock me-2' ></i>Change Account Password</button>
		
	</div>
	<!-- End of Jumbotron -->

	<!-- Modal for Edit Appointment -->
	<div class="modal fade" id="changePassword">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Change Password</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
					  <div class="col-md-12">
					  	<label class="form-label">Enter Current Password</label><span class="fst-italic text-danger cpassword_err"></span>
					    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Current Password" required>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Enter New Password</label><span class="fst-italic text-danger npassword_err"></span>
					    <input type="password" class="form-control" minlength="8" name="npassword" id="npassword" placeholder="New Password" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="changePass" class="btn btn-success"><i class='bx bx-edit me-2'></i>Change Password</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->
</body>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.md5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
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

  $('#changePass').click(function () {
  	var user_id = '<?php echo $_SESSION['user_id'];?>';
  	var password = '<?php echo $_SESSION['password'];?>';
  	var cpassword = $("#cpassword").val();
  	
  	var npassword = $('#npassword').val();
  	var valid = true;



  	if(cpassword == ""){
  		valid = false;
      $(".cpassword_err").html(" *Required");
  	}else{
  		$(".cpassword_err").html("");
  		var cpassword1 = CryptoJS.MD5(cpassword);
  	}

  	if(npassword == ""){
  		valid = false;
      $(".npassword_err").html(" *Required");
  	}else{
  		$(".npassword_err").html("");
  	}

  	if(valid){
  	if (password != cpassword1) {
  		Swal.fire({
        title: 'Current password is incorrect!',
        icon: 'error',
        confirmButtonText: 'Ok'
      }).then((result) => {
      	if (result.isConfirmed) {
      		document.location.href="settings.php";
      	}
      });

  	}else{

  		Swal.fire({
        title: 'Are you sure to change password?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        user_id : user_id,
	        password : npassword
      	};  

    		$.ajax({
        	url : "change_password.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#changePass").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Password successfully changed. Please log in to continue",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="logout.php";
                }
              });
              asb();
            }        
          }
        });
      }
    });	
  	}
  	}else{
    	return false;
  	}
  });
</script>				
</html>