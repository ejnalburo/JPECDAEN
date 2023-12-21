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
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
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
	          <a class="h5 nav-link active text-success fw-bolder" aria-current="page" href="nurse_index.php">Dashboard</a>
	        </li>
	        <li class="nav-item">
	          <a class="h5 nav-link" href="nurse_appointments.php">Appointments</a>
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

	<!-- Dashboard -->
	<div class="container my-3">
		<div class="row g-5">
			<div class="col-xl-4 p-3 border shadow rounded">
				<div class="m-1">
					<h5>Select Product/Accessory/Medicine</h5>
					<center>
					<div class="row " style="height:5in; overflow-y: auto;">
						<?php
	            include 'config.php';
	            $query = mysqli_query($conn, "SELECT * FROM products ORDER BY pr_name, unit DESC");

	            while($data = mysqli_fetch_assoc($query)){  
	          ?>
							<button class="btn col-4 m-1 rounded bg-success text-white" onclick="addProduct('<?php echo $data['pr_id']; ?>','<?php echo $data['pr_brand']; ?>','<?php echo $data['pr_name']; ?>','<?php echo $data['unit']; ?>','<?php echo $data['qty']; ?>','<?php echo $data['price']; ?>')"><h6 class="text-break"><?php echo $data['pr_brand']." ".$data['pr_name']." ".$data['unit']; ?></h6></button>
						<?php
							}
						?>
						<?php
	            include 'config.php';
	            $query = mysqli_query($conn, "SELECT * FROM accessories ORDER BY acc_name DESC");

	            while($data = mysqli_fetch_assoc($query)){  
	          ?>
							<button class="btn col-4 m-1 rounded bg-success text-white" onclick="addAccessory('<?php echo $data['acc_id']; ?>','<?php echo $data['acc_brand']; ?>','<?php echo $data['acc_name']; ?>','<?php echo $data['qty']; ?>','<?php echo $data['price']; ?>')"><h6 class="text-break"><?php echo $data['acc_brand']." ".$data['acc_name']; ?></h6></button>
						<?php
							}
						?>
						<?php
	            include 'config.php';
	            $query = mysqli_query($conn, "SELECT * FROM medicines ORDER BY med_name, unit DESC");

	            while($data = mysqli_fetch_assoc($query)){  
	          ?>
							<button class="btn  col-4 m-1 rounded bg-success text-white" onclick="addMedicine('<?php echo $data['med_id']; ?>','<?php echo $data['med_brand']; ?>','<?php echo $data['med_name']; ?>','<?php echo $data['unit']; ?>','<?php echo $data['qty']; ?>','<?php echo $data['price']; ?>')"><h6 class="text-break"><?php echo $data['med_brand']." ".$data['med_name']." ".$data['unit']; ?></h6></button>
						<?php
							}
						?>
					</div>
				</div>
			</div>
			<div class="col-xl-8 p-3 border shadow rounded">
				<div class="row mb-2 overflow-auto">					
					<h3 class="text-black-50 mb-3">Items Purchased</h3>
					<table id="myTable" class="display" style="width:100%">
					    <thead>
					        <tr>
					            <th>Brand</th>
					            <th>Product Name</th>
					            <th>Qty</th>
					            <th>Price</th>
					            <th>Total</th>
					            <th>Actions</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<?php
			            include 'config.php';
			            $query = mysqli_query($conn, "SELECT * FROM sales WHERE transaction_id = '0' ORDER BY sales_id DESC");

			            while($data = mysqli_fetch_assoc($query)){  
			          ?>
					    	<tr>
					    		<td><?php echo $data['brand']; ?></td>
					    		<td><?php echo $data['name']; ?></td>
					    		<td><?php echo $data['qty']; ?></td>
					    		<td><?php echo $data['price']; ?></td>
					    		<td class="fieldcell"><?php echo $data['total']; ?></td>
					    		<td><button onclick="deleteItem('<?php echo $data['sales_id']; ?>','<?php echo $data['pr_id']; ?>','<?php echo $data['acc_id']; ?>','<?php echo $data['med_id']; ?>','<?php echo $data['qty']; ?>')" class="btn btn-danger"><i class='bx bx-checkbox-minus'></i>&nbsp;Delete</button></td>
					    	</tr>
					    	<?php
					    		}
					    	?>
					    </tbody>
					    <tfoot>
					        <tr>
					            <th></th>
					            <th></th>
					            <th></th>
					            <th>Total Amount</th>
					            <th>₱<span id="totam"></span></th>
					            <th></th>
					        </tr>
					    </tfoot>
					</table>
				</div>
				<div class="mt-2">
					<button class="btn btn-success" onclick="checkOut()"><i class='bx bx-cart-download me-2'></i>Check Out</button>
				</div>			
			</div>
		</div>
	</div>				
	<!-- End of Dashboard -->

</body>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.12.1/api/sum().js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	$(document).ready( function () {
  	$('#myTable').DataTable({
  			"lengthMenu": [ 5, 10 ],
      	"searching": false,
      	"ordering": false,
      	"bInfo": false,
      	drawCallback: function () {
      var api = this.api();
      $("#totam").html(
        api.column(4).data().sum()
      );
    }
  		});
	});

	function deleteItem(sales_id, pr_id, acc_id, med_id, qty){
		var sales_id = sales_id;
		var pr_id = pr_id;
  	var acc_id = acc_id;
  	var med_id = med_id;
  	var qty = qty;
		Swal.fire({
        title: 'Are you sure to delete item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        allowOutsideClick: false
      }).then((result) => {
        if (result.isConfirmed) {
			    var form_data = {
			    	sales_id : sales_id,
			    	pr_id : pr_id,
		        acc_id : acc_id,
		        med_id : med_id,
		        qty : qty
	      	}; 
          $.ajax({
        	url : "delete_item.php",
        	type : "POST",
        	data: form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              document.location.href = "nurse_index.php";
            }else{
            	document.location.href = "nurse_index.php";
            }        
          }
        });
        }
      });
	}

	function checkOut(){
		Swal.fire({
        title: 'Are you sure to check out?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        allowOutsideClick: false
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
        	url : "checkout_items.php",
        	type : "POST",
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
            	window.location.reload();
            }        
          }
        });
        }
      });
	}


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

  function addProduct(pr_id,pr_brand,pr_name,unit,qty,price){
  	var pr_id = pr_id;
  	var brand = pr_brand;
  	var name = pr_name;
  	var unit = unit;
  	var qty = qty;
  	var price = price;
  	var qty1 = "";

  	Swal.fire({
		  title: 'Enter Quantity',
		  input: 'number',
		  inputAttributes: {
		    autocapitalize: 'off',
		    min: 1,
		    max: qty
		  },
		  showCancelButton: true,
		  confirmButtonText: 'Add',
		}).then((result) => {
		  if (result.isConfirmed) {
		    var form_data = {
		    	pr_id : pr_id,
	        brand : brand,
	        name : name,
	        unit : unit,
	        qty : result.value,
	        price : price
      	}; 
      $.ajax({
        	url : "purchase_product.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
            	window.location.reload();
            }        
          }
        });
		  }
		});
  }

  function addAccessory(acc_id,acc_brand,acc_name,qty,price){
   	var pr_id = acc_id;
  	var brand = acc_brand;
  	var name = acc_name;
  	var qty = qty;
  	var price = price;
  	var qty1 = "";


  	Swal.fire({
		  title: 'Enter Quantity',
		  input: 'number',
		  inputAttributes: {
		    autocapitalize: 'off',
		    min: 1,
		    max: qty
		  },
		  showCancelButton: true,
		  confirmButtonText: 'Add',
		}).then((result) => {
		  if (result.isConfirmed) {
		    var form_data = {
		    	pr_id : pr_id,
	        brand : brand,
	        name : name,
	        qty : result.value,
	        price : price
      	}; 
      $.ajax({
        	url : "purchase_accessory.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
            	window.location.reload();
            }        
          }
        });
		  }
		});
  }

  function addMedicine(med_id,med_brand,med_name,unit,qty,price){
   	var pr_id = med_id;
  	var brand = med_brand;
  	var name = med_name;
  	var unit = unit;
  	var qty = qty;
  	var price = price;
  	var qty1 = "";


  	Swal.fire({
		  title: 'Enter Quantity',
		  input: 'number',
		  inputAttributes: {
		    autocapitalize: 'off',
		    min: 1,
		    max: qty
		  },
		  showCancelButton: true,
		  confirmButtonText: 'Add',
		}).then((result) => {
		  if (result.isConfirmed) {
		    var form_data = {
		    	pr_id : pr_id,
	        brand : brand,
	        name : name,
	        unit : unit,
	        qty : result.value,
	        price : price
      	}; 
      $.ajax({
        	url : "purchase_medicine.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
            	window.location.reload();
            }        
          }
        });
		  }
		});
  }

</script>				
</html>