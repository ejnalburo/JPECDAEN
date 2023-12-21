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
	          <a class="h5 nav-link" aria-current="page" href="nurse_index.php">Dashboard</a>
	        </li>
	        <li class="nav-item">
	          <a class="h5 nav-link" href="nurse_appointments.php">Appointments</a>
	        </li>
	        <li class="nav-item">
	          <a class="h5 nav-link" href="nurse_inventory.php">Inventory</a>
	        </li>

	        <li class="nav-item dropdown ms-5">
	          <a class="h5 nav-link dropdown-toggle active text-success fw-bolder" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            User
	          </a>
	          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
	            <li><a class="dropdown-item text-white bg-success" href="nurse_profile.php">Profile</a></li>
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

	<!-- Profile -->
	<div class="container p-4 mb-5 border bg-light shadow p-3 rounded table-responsive">
		<div class="row">
			<?php
	      include 'config.php';
	      $user_id = $_SESSION['user_id'];
	      $query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'");

	      while($data = mysqli_fetch_assoc($query)){  
	    ?>
			<div class="col-lg-3 mb-5">
				<div class="card">
					<?php 
            if ($data['profile'] == "") {
            echo '<img src="img/avatar-1.png" class="card-img-top">';
            }else{
            echo '<img src="<?php echo $data["profile"];?>" class="card-img-top">';
            }
          ?>
				  
				  <div class="card-body">
				    <h5 class="card-title text-center text-secondary"><?php echo $data['firstname']; ?></h5>
				    <ul class="list-group list-group-flush">
					    <li class="list-group-item fs-6 fw-bold">Socials</li>
					    <li class="list-group-item fs-6 fw-light"><i class='bx bxs-phone-call text-success' ></i>&nbsp;<?php echo $data['phone']; ?></li>
					</ul>
				  </div>
				</div>
			</div>
			<div class="col-lg-9 bg-light.bg-gradient rounded">
				<h4 class="fw-bolder text-secondary">About Me</h4>
				<hr>
				<form class="row g-3">
				  <div class="col-md-6">
				    <label class="form-label">Username</label>
				    <input type="text" class="form-control" value="<?php echo $data['username']; ?>" placeholder="@janedoe123" readonly>
				  </div>
				  <div class="col-md-6">
				    <label class="form-label">Email</label>
				    <input type="email" class="form-control" value="<?php echo $data['email']; ?>" placeholder="janedoe@mail.net" readonly>
				  </div>
				  <div class="col-md-6">
				    <label class="form-label">First Name</label>
				    <input type="text" class="form-control" value="<?php echo $data['firstname']; ?>" placeholder="Jane" readonly>
				  </div>
				  <div class="col-md-6">
				    <label class="form-label">Last Name</label>
				    <input type="text" class="form-control" value="<?php echo $data['lastname']; ?>" placeholder="Doe" readonly>
				  </div>
				  <div class="col-12">
				    <label for="inputAddress" class="form-label">Address(House/lot No., Street, Barangay, Municipality/City)</label>
				    <input type="text" class="form-control" id="inputAddress" value="<?php echo $data['address']; ?>" placeholder="1234 Main St Prk 1 Magugpo West Tagum City" readonly>
				  </div>
				  <div class="col-md-12">
				  	<label class="form-label">Experiences</label>
  					<textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Write some experiences" rows="8" readonly><?php echo $data['experiences']; ?></textarea>
				  </div>
				  <div class="col-12">
				    <button type="button" class="btn btn-warning ms-auto d-block" onclick="changeProfile('<?php echo $data['user_id']; ?>','<?php echo $data['username']; ?>','<?php echo $data['firstname']; ?>','<?php echo $data['lastname']; ?>','<?php echo $data['email']; ?>','<?php echo $data['phone']; ?>','<?php echo $data['address']; ?>','<?php echo $data['experiences']; ?>')"><i class='bx bx-edit-alt me-2' ></i>Change profile info</button>
				  </div>
				</form>
				
			</div>
			<?php
				}
			?>
		</div>		
	</div>
	<!-- End of Profile -->

	<!-- Modal for Edit Appointment -->
	<div class="modal fade" id="changeProfile">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit Profile Info</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
	        	<input type="hidden" name="cuser_id" id="cuser_id">
					  <div class="col-md-4">
					  	<label class="form-label">User Name</label><span class="fst-italic text-danger username_err"></span>
					    <input type="text" class="form-control" name="cusername" id="cusername" placeholder="User Name" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">First Name</label><span class="fst-italic text-danger firstname_err"></span>
					    <input type="text" class="form-control" name="cfirstname" id="cfirstname" placeholder="First Name" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Last Name</label><span class="fst-italic text-danger lastname_err"></span>
					    <input type="text" class="form-control" name="clastname" id="clastname" placeholder="Last Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Phone #</label><span class="fst-italic text-danger phone_err"></span>
					    <input type="text" class="form-control" name="cphone" id="cphone" placeholder="Phoner Number" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Email</label><span class="fst-italic text-danger email_err"></span>
					    <input type="email" class="form-control" name="cemail" id="cemail" placeholder="Email Address" required>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Address</label><span class="fst-italic text-danger address_err"></span>
					    <input type="text" class="form-control" name="caddress" id="caddress" placeholder="Current Address (ex. '1234 Main St Prk 1 Magugpo West Tagum City')" required>
					  </div>
					  <div class="col-md-12">
					  	<label class="form-label">Experiences</label><span class="fst-italic text-danger experiences_err"></span>
					    <textarea class="form-control" rows="4" name="cexperiences" id="cexperiences" placeholder="Add some experiences" required></textarea>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="saveProfile" class="btn btn-success"><i class='bx bx-edit me-2'></i>Save Changes</button>
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

  function changeProfile(user_id, username, firstname, lastname, email, phone, address, experiences){
  	$("#cuser_id").val(user_id);
  	$("#cusername").val(username);
  	$("#cfirstname").val(firstname);
  	$("#clastname").val(lastname);
  	$("#cemail").val(email);
  	$("#cphone").val(phone);
  	$("#caddress").val(address);
  	$("#cexperiences").val(experiences);

  	$("#changeProfile").modal('show');
  }

  $('#saveProfile').click(function () {
  	var user_id = $('#cuser_id').val();
  	var username = $('#cusername').val();
  	var firstname = $('#cfirstname').val();
  	var lastname = $('#clastname').val();
  	var email = $('#cemail').val();
  	var phone = $('#cphone').val();
  	var address = $('#caddress').val();
  	var experiences = $('#cexperiences').val();
  	var valid = true;

  	if(username == ""){
  		valid = false;
      $(".username_err").html(" *Required");
  	}else{
  		$(".username_err").html("");
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

  	if(experiences == ""){
  		valid = false;
      $(".experiences_err").html(" *Required");
  	}else{
  		$(".experiences_err").html("");
  	}

  	if(valid){
  		Swal.fire({
        title: 'Are you sure to change profile info?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        user_id : user_id,
	        username : username,
	        firstname : firstname,
	        lastname : lastname,
	        email : email,
	        phone : phone,
	        address : address,
	        experiences : experiences
      	};  

    		$.ajax({
        	url : "change_profile.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#saveProfile").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Profile Info successfully changed",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="nurse_profile.php";
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