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
	          <a class="h5 nav-link" href="nurse_appointments.php">Appointments</a>
	        </li>
	        <li class="nav-item">
	          <a class="h5 nav-link active text-success fw-bolder" href="nurse_inventory.php">Inventory</a>
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
		<h2 class="text-black-50 mb-3">List of All Food Products</h2>
		<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProduct"><i class='bx bx-plus-medical me-2'></i>Add Product</button>
		<table id="myTable" class="display" style="width:100%">
		    <thead>
		        <tr>
		            <th>Brand</th>
		            <th>Product Name</th>
		            <th>Supplier</th>
		            <th>Unit</th>
		            <th>Qty</th>
		            <th>Price</th>
		            <th>Expiration Date</th>
		            <th>Actions</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php
            include 'config.php';
            $query = mysqli_query($conn, "SELECT * FROM products ORDER BY pr_id DESC");

            while($data = mysqli_fetch_assoc($query)){  
          ?>
		        <tr>
		            <td><?php echo $data['pr_brand']; ?></td>
		            <td><?php echo $data['pr_name']; ?></td>
		            <td><?php echo $data['pr_supplier']; ?></td>
		            <td><?php echo $data['unit']; ?></td>
		            <td><?php echo $data['qty']; ?></td>
		            <td>₱<?php echo $data['price']; ?></td>
		            <td><?php echo $data['exp_date']; ?></td>
		            <td>
		            	<button class="btn btn-warning" onclick="editPr('<?php echo $data['pr_id']; ?>','<?php echo $data['pr_brand']; ?>','<?php echo $data['pr_name']; ?>','<?php echo $data['pr_supplier']; ?>','<?php echo $data['unit']; ?>','<?php echo $data['qty']; ?>','<?php echo $data['price']; ?>','<?php echo $data['exp_date']; ?>')"><i class='bx bxs-edit'></i>&nbsp;Edit</button>
		            </td>
		        </tr>
		      <?php
		      	}
		      ?>
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>Brand</th>
		            <th>Product Name</th>
		            <th>Supplier</th>
		            <th>Unit</th>
		            <th>Qty</th>
		            <th>Price</th>
		            <th>Expiration Date</th>
		            <th>Actions</th>
		        </tr>
		    </tfoot>
		</table>
	</div>

	<div class="container p-4 mb-5 border bg-light shadow p-3 rounded table-responsive">
		<h2 class="text-black-50 mb-3">List of All Accessories</h2>
		<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addAccessory"><i class='bx bx-plus-medical me-2'></i>Add Accessory</button>
		<table id="myTable1" class="display" style="width:100%">
		    <thead>
		        <tr>
		            <th>Brand</th>
		            <th>Accessory Name</th>
		            <th>Supplier</th>
		            <th>Qty</th>
		            <th>Price</th>
		            <th>Actions</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php
            include 'config.php';
            $query = mysqli_query($conn, "SELECT * FROM accessories ORDER BY acc_id DESC");

            while($data = mysqli_fetch_assoc($query)){  
          ?>
		        <tr>
		            <td><?php echo $data['acc_brand']; ?></td>
		            <td><?php echo $data['acc_name']; ?></td>
		            <td><?php echo $data['acc_supplier']; ?></td>
		            <td><?php echo $data['qty']; ?></td>
		            <td>₱<?php echo $data['price']; ?></td>
		            <td>
		            	<button class="btn btn-warning" onclick="editAcc('<?php echo $data['acc_id']; ?>','<?php echo $data['acc_brand']; ?>','<?php echo $data['acc_name']; ?>','<?php echo $data['acc_supplier']; ?>','<?php echo $data['qty']; ?>','<?php echo $data['price']; ?>')"><i class='bx bxs-edit'></i>&nbsp;Edit</button>
		            </td>
		        </tr>
		      <?php
		      	}
		      ?>
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>Brand</th>
		            <th>Accessory Name</th>
		            <th>Supplier</th>
		            <th>Qty</th>
		            <th>Price</th>
		            <th>Actions</th>
		        </tr>
		    </tfoot>
		</table>
	</div>

	<div class="container p-4 mb-5 border bg-light shadow p-3 rounded table-responsive">
		<h2 class="text-black-50 mb-3">List of All Medicines</h2>
		<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addMedicine"><i class='bx bx-plus-medical me-2'></i>Add Medicine</button>
		<table id="myTable2" class="display" style="width:100%">
		    <thead>
		        <tr>
		            <th>Brand</th>
		            <th>Medicine Name</th>
		            <th>Supplier</th>
		            <th>Unit</th>
		            <th>Qty</th>
		            <th>Price</th>
		            <th>Expiration Date</th>
		            <th>Actions</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php
            include 'config.php';
            $query = mysqli_query($conn, "SELECT * FROM medicines ORDER BY med_id DESC");

            while($data = mysqli_fetch_assoc($query)){  
          ?>
		        <tr>
		            <td><?php echo $data['med_brand']; ?></td>
		            <td><?php echo $data['med_name']; ?></td>
		            <td><?php echo $data['med_supplier']; ?></td>
		            <td><?php echo $data['unit']; ?></td>
		            <td><?php echo $data['qty']; ?></td>
		            <td>₱<?php echo $data['price']; ?></td>
		            <td><?php echo $data['exp_date']; ?></td>
		            <td>
		            	<button class="btn btn-warning" onclick="editMed('<?php echo $data['med_id']; ?>','<?php echo $data['med_brand']; ?>','<?php echo $data['med_name']; ?>','<?php echo $data['med_supplier']; ?>','<?php echo $data['unit']; ?>','<?php echo $data['qty']; ?>','<?php echo $data['price']; ?>','<?php echo $data['exp_date']; ?>')"><i class='bx bxs-edit'></i>&nbsp;Edit</button>
		            </td>
		        </tr>
		      <?php
		      	}
		      ?>
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>Brand</th>
		            <th>Medicine Name</th>
		            <th>Supplier</th>
		            <th>Unit</th>
		            <th>Qty</th>
		            <th>Price</th>
		            <th>Expiration Date</th>
		            <th>Actions</th>
		        </tr>
		    </tfoot>
		</table>
	</div>
	<!-- End of Tables -->

	<!-- Modal for Add Product -->
	<div class="modal fade" id="addProduct">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add Product</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
					  <div class="col-md-6">
					  	<label class="form-label">Brand Name</label><span class="fst-italic text-danger pr_brand_err"></span>
					    <input type="text" class="form-control" name="pr_brand" id="pr_brand" placeholder="Brand Name (Type 'None' if no brand)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Product Name</label><span class="fst-italic text-danger pr_name_err"></span>
					    <input type="text" class="form-control" name="pr_name" id="pr_name" placeholder="Food Product Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Supplier Name</label><span class="fst-italic text-danger pr_supplier_err"></span>
					    <input type="text" class="form-control" name="pr_supplier" id="pr_supplier" placeholder="Supplier Name (Type 'None' if no supplier)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Unit</label><span class="fst-italic text-danger pr_unit_err"></span>
					    <input type="text" class="form-control" name="pr_unit" id="pr_unit" placeholder="Unit (Ex. 100g, 1kg)" required>
					  </div>
					  <div class="col-md-3">
					  	<label class="form-label">Quantity</label><span class="fst-italic text-danger pr_qty_err"></span>
					    <input type="number" class="form-control" min=1 name="pr_qty" id="pr_qty" placeholder="Quantity" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Price</label><span class="fst-italic text-danger pr_price_err"></span>
					    <input type="text" class="form-control" name="pr_price" id="pr_price" placeholder="Price (Ex. 50.00, 1200.50)" required>
					  </div>
					  <div class="col-md-5">
					  	<label class="form-label">Expiration Date</label><span class="fst-italic text-danger pr_exp_date_err"></span>
					    <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="pr_exp_date" id="pr_exp_date" placeholder="Expiration Date" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="addPr" class="btn btn-success"><i class='bx bx-plus me-2'></i>Add Product</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->

	<!-- Modal for Add Accessory -->
	<div class="modal fade" id="addAccessory">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add Accessory</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
					  <div class="col-md-6">
					  	<label class="form-label">Brand Name</label><span class="fst-italic text-danger acc_brand_err"></span>
					    <input type="text" class="form-control" name="acc_brand" id="acc_brand" placeholder="Brand Name (Type 'None' if no brand)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Accessory Name</label><span class="fst-italic text-danger acc_name_err"></span>
					    <input type="text" class="form-control" name="acc_name" id="acc_name" placeholder="Accessory Name" required>
					  </div>
					  <div class="col-md-5">
					  	<label class="form-label">Supplier Name</label><span class="fst-italic text-danger acc_supplier_err"></span>
					    <input type="text" class="form-control" name="acc_supplier" id="acc_supplier" placeholder="Supplier Name (Type 'None' if no supplier)" required>
					  </div>
					  <div class="col-md-3">
					  	<label class="form-label">Quantity</label><span class="fst-italic text-danger acc_qty_err"></span>
					    <input type="number" class="form-control" min=1 name="acc_qty" id="acc_qty" placeholder="Quantity" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Price</label><span class="fst-italic text-danger acc_price_err"></span>
					    <input type="text" class="form-control" name="acc_price" id="acc_price" placeholder="Price (Ex. 50.00, 1200.50)" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="addAcc" class="btn btn-success"><i class='bx bx-plus me-2'></i>Add Accessory</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->

	<!-- Modal for Add Medicine -->
	<div class="modal fade" id="addMedicine">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add Medicine</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
					  <div class="col-md-6">
					  	<label class="form-label">Brand Name</label><span class="fst-italic text-danger med_brand_err"></span>
					    <input type="text" class="form-control" name="med_brand" id="med_brand" placeholder="Brand Name (Type 'None' if no brand)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Product Name</label><span class="fst-italic text-danger med_name_err"></span>
					    <input type="text" class="form-control" name="med_name" id="med_name" placeholder="Food Product Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Supplier Name</label><span class="fst-italic text-danger med_supplier_err"></span>
					    <input type="text" class="form-control" name="med_supplier" id="med_supplier" placeholder="Supplier Name (Type 'None' if no supplier)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Unit</label><span class="fst-italic text-danger med_unit_err"></span>
					    <input type="text" class="form-control" name="med_unit" id="med_unit" placeholder="Unit (Ex. 100g, 1kg)" required>
					  </div>
					  <div class="col-md-3">
					  	<label class="form-label">Quantity</label><span class="fst-italic text-danger med_qty_err"></span>
					    <input type="number" class="form-control" min=1 name="med_qty" id="med_qty" placeholder="Quantity" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Price</label><span class="fst-italic text-danger med_price_err"></span>
					    <input type="text" class="form-control" name="med_price" id="med_price" placeholder="Price (Ex. 50.00, 1200.50)" required>
					  </div>
					  <div class="col-md-5">
					  	<label class="form-label">Expiration Date</label><span class="fst-italic text-danger med_exp_date_err"></span>
					    <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="med_exp_date" id="med_exp_date" placeholder="Expiration Date" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="addMed" class="btn btn-success"><i class='bx bx-plus me-2'></i>Add Medicine</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->

	<!-- Modal for Edit Product -->
	<div class="modal fade" id="editProduct">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit Product</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
	        	<input type="hidden" id="epr_id">
					  <div class="col-md-6">
					  	<label class="form-label">Brand Name</label><span class="fst-italic text-danger pr_brand_err"></span>
					    <input type="text" class="form-control" name="epr_brand" id="epr_brand" placeholder="Brand Name (Type 'None' if no brand)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Product Name</label><span class="fst-italic text-danger pr_name_err"></span>
					    <input type="text" class="form-control" name="epr_name" id="epr_name" placeholder="Food Product Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Supplier Name</label><span class="fst-italic text-danger pr_supplier_err"></span>
					    <input type="text" class="form-control" name="epr_supplier" id="epr_supplier" placeholder="Supplier Name (Type 'None' if no supplier)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Unit</label><span class="fst-italic text-danger pr_unit_err"></span>
					    <input type="text" class="form-control" name="epr_unit" id="epr_unit" placeholder="Unit (Ex. 100g, 1kg)" required>
					  </div>
					  <div class="col-md-3">
					  	<label class="form-label">Quantity</label><span class="fst-italic text-danger pr_qty_err"></span>
					    <input type="number" class="form-control" min=1 name="epr_qty" id="epr_qty" placeholder="Quantity" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Price</label><span class="fst-italic text-danger pr_price_err"></span>
					    <input type="text" class="form-control" name="epr_price" id="epr_price" placeholder="Price (Ex. 50.00, 1200.50)" required>
					  </div>
					  <div class="col-md-5">
					  	<label class="form-label">Expiration Date</label><span class="fst-italic text-danger pr_exp_date_err"></span>
					    <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="epr_exp_date" id="epr_exp_date" placeholder="Expiration Date" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="savePr" class="btn btn-warning"><i class='bx bxs-edit me-2'></i>Save Changes</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->

	<!-- Modal for Edit Accessory -->
	<div class="modal fade" id="editAccessory">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit Accessory</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
	        	<input type="hidden" id="eacc_id">
					  <div class="col-md-6">
					  	<label class="form-label">Brand Name</label><span class="fst-italic text-danger acc_brand_err"></span>
					    <input type="text" class="form-control" name="eacc_brand" id="eacc_brand" placeholder="Brand Name (Type 'None' if no brand)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Accessory Name</label><span class="fst-italic text-danger acc_name_err"></span>
					    <input type="text" class="form-control" name="eacc_name" id="eacc_name" placeholder="Accessory Name" required>
					  </div>
					  <div class="col-md-5">
					  	<label class="form-label">Supplier Name</label><span class="fst-italic text-danger acc_supplier_err"></span>
					    <input type="text" class="form-control" name="eacc_supplier" id="eacc_supplier" placeholder="Supplier Name (Type 'None' if no supplier)" required>
					  </div>
					  <div class="col-md-3">
					  	<label class="form-label">Quantity</label><span class="fst-italic text-danger acc_qty_err"></span>
					    <input type="number" class="form-control" min=1 name="eacc_qty" id="eacc_qty" placeholder="Quantity" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Price</label><span class="fst-italic text-danger acc_price_err"></span>
					    <input type="text" class="form-control" name="eacc_price" id="eacc_price" placeholder="Price (Ex. 50.00, 1200.50)" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="saveAcc" class="btn btn-warning"><i class='bx bx-edit me-2'></i>Save Changes</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End -->

	<!-- Modal for Edit Medicine -->
	<div class="modal fade" id="editMedicine">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit Medicine</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="row g-3">
	        	<input type="hidden" id="emed_id">
					  <div class="col-md-6">
					  	<label class="form-label">Brand Name</label><span class="fst-italic text-danger med_brand_err"></span>
					    <input type="text" class="form-control" name="emed_brand" id="emed_brand" placeholder="Brand Name (Type 'None' if no brand)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Product Name</label><span class="fst-italic text-danger med_name_err"></span>
					    <input type="text" class="form-control" name="emed_name" id="emed_name" placeholder="Food Product Name" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Supplier Name</label><span class="fst-italic text-danger med_supplier_err"></span>
					    <input type="text" class="form-control" name="emed_supplier" id="emed_supplier" placeholder="Supplier Name (Type 'None' if no supplier)" required>
					  </div>
					  <div class="col-md-6">
					  	<label class="form-label">Unit</label><span class="fst-italic text-danger med_unit_err"></span>
					    <input type="text" class="form-control" name="emed_unit" id="emed_unit" placeholder="Unit (Ex. 100g, 1kg)" required>
					  </div>
					  <div class="col-md-3">
					  	<label class="form-label">Quantity</label><span class="fst-italic text-danger med_qty_err"></span>
					    <input type="number" class="form-control" min=1 name="emed_qty" id="emed_qty" placeholder="Quantity" required>
					  </div>
					  <div class="col-md-4">
					  	<label class="form-label">Price</label><span class="fst-italic text-danger med_price_err"></span>
					    <input type="text" class="form-control" name="emed_price" id="emed_price" placeholder="Price (Ex. 50.00, 1200.50)" required>
					  </div>
					  <div class="col-md-5">
					  	<label class="form-label">Expiration Date</label><span class="fst-italic text-danger med_exp_date_err"></span>
					    <input type="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="emed_exp_date" id="emed_exp_date" placeholder="Expiration Date" required>
					  </div>
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	        <button type="button" id="saveMed" class="btn btn-warning"><i class='bx bx-edit me-2'></i>Save Changes</button>
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
        ordering : false
    	});
    	$('#myTable1').DataTable({
    		lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, 'All'],
        ],
        ordering : false
    	});
    	$('#myTable2').DataTable({
    		lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, 'All'],
        ],
        ordering : false
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

  function asb(){

  }

  function editPr(pr_id,pr_brand,pr_name,pr_supplier,unit,qty,price,exp_date){
  	var pr_id = pr_id;
  	var pr_brand = pr_brand;
  	var pr_name = pr_name;
  	var pr_supplier = pr_supplier;
  	var pr_unit = unit;
  	var pr_qty = qty;
  	var pr_price = price;
  	var pr_exp_date = exp_date;

  	$('#epr_id').val(pr_id);
  	$('#epr_brand').val(pr_brand);
  	$('#epr_name').val(pr_name);
  	$('#epr_supplier').val(pr_supplier);
  	$('#epr_unit').val(pr_unit);
  	$('#epr_qty').val(pr_qty);
  	$('#epr_price').val(pr_price);
  	$('#epr_exp_date').val(pr_exp_date);

  	$('#editProduct').modal('show');
  }

  function editAcc(acc_id,acc_brand,acc_name,acc_supplier,qty,price){
  	var acc_id = acc_id;
  	var acc_brand = acc_brand;
  	var acc_name = acc_name;
  	var acc_supplier = acc_supplier;
  	var acc_qty = qty;
  	var acc_price = price;

  	$('#eacc_id').val(acc_id);
  	$('#eacc_brand').val(acc_brand);
  	$('#eacc_name').val(acc_name);
  	$('#eacc_supplier').val(acc_supplier);
  	$('#eacc_qty').val(acc_qty);
  	$('#eacc_price').val(acc_price);

  	$('#editAccessory').modal('show');
  }

  function editMed(med_id,med_brand,med_name,med_supplier,unit,qty,price,exp_date){
  	var med_id = med_id;
  	var med_brand = med_brand;
  	var med_name = med_name;
  	var med_supplier = med_supplier;
  	var med_unit = unit;
  	var med_qty = qty;
  	var med_price = price;
  	var med_exp_date = exp_date;

  	$('#emed_id').val(med_id);
  	$('#emed_brand').val(med_brand);
  	$('#emed_name').val(med_name);
  	$('#emed_supplier').val(med_supplier);
  	$('#emed_unit').val(med_unit);
  	$('#emed_qty').val(med_qty);
  	$('#emed_price').val(med_price);
  	$('#emed_exp_date').val(med_exp_date);

  	$('#editMedicine').modal('show');
  }

  $('#addPr').click(function () {
  	var pr_brand = $('#pr_brand').val();
  	var pr_name = $('#pr_name').val();
  	var pr_supplier = $('#pr_supplier').val();
  	var pr_unit = $('#pr_unit').val();
  	var pr_qty = $('#pr_qty').val();
  	var pr_price = $('#pr_price').val();
  	var pr_exp_date = $('#pr_exp_date').val();
  	var valid = true;

  	if(pr_brand == ""){
  		valid = false;
      $(".pr_brand_err").html(" *Required");
  	}else{
  		$(".pr_brand_err").html("");
  	}

  	if(pr_name == ""){
  		valid = false;
      $(".pr_name_err").html(" *Required");
  	}else{
  		$(".pr_name_err").html("");
  	}

  	if(pr_supplier == ""){
  		valid = false;
      $(".pr_supplier_err").html(" *Required");
  	}else{
  		$(".pr_supplier_err").html("");
  	}

  	if(pr_unit == ""){
  		valid = false;
      $(".pr_unit_err").html(" *Required");
  	}else{
  		$(".pr_unit_err").html("");
  	}

  	if(pr_qty == ""){
  		valid = false;
      $(".pr_qty_err").html(" *Required");
  	}else{
  		$(".pr_qty_err").html("");
  	}

  	if(pr_price == ""){
  		valid = false;
      $(".pr_price_err").html(" *Required");
  	}else{
  		$(".pr_price_err").html("");
  	}

  	if(pr_exp_date == ""){
  		valid = false;
      $(".pr_exp_date_err").html(" *Required");
  	}else{
  		$(".pr_exp_date_err").html("");
  	}

  	if(valid){
  		Swal.fire({
        title: 'Are you sure to add product?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        pr_brand : pr_brand,
	        pr_name : pr_name,
	        pr_supplier : pr_supplier,
	        unit : pr_unit,
	        qty : pr_qty,
	        price : pr_price,
	        exp_date : pr_exp_date
      	};  

    		$.ajax({
        	url : "insert_product.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#addProduct").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Product successfully added",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="inventory.php";
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


  $('#addAcc').click(function () {
  	var acc_brand = $('#acc_brand').val();
  	var acc_name = $('#acc_name').val();
  	var acc_supplier = $('#acc_supplier').val();
  	var acc_qty = $('#acc_qty').val();
  	var acc_price = $('#acc_price').val();
  	var valid = true;

  	if(acc_brand == ""){
  		valid = false;
      $(".acc_brand_err").html(" *Required");
  	}else{
  		$(".acc_brand_err").html("");
  	}

  	if(acc_name == ""){
  		valid = false;
      $(".acc_name_err").html(" *Required");
  	}else{
  		$(".acc_name_err").html("");
  	}

  	if(acc_supplier == ""){
  		valid = false;
      $(".acc_supplier_err").html(" *Required");
  	}else{
  		$(".acc_supplier_err").html("");
  	}

  	if(acc_qty == ""){
  		valid = false;
      $(".acc_qty_err").html(" *Required");
  	}else{
  		$(".acc_qty_err").html("");
  	}

  	if(acc_price == ""){
  		valid = false;
      $(".acc_price_err").html(" *Required");
  	}else{
  		$(".acc_price_err").html("");
  	}

  	if(valid){
  		Swal.fire({
        title: 'Are you sure to add accessory?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        acc_brand : acc_brand,
	        acc_name : acc_name,
	        acc_supplier : acc_supplier,
	        qty : acc_qty,
	        price : acc_price
      	};  

    		$.ajax({
        	url : "insert_accessory.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#addAccessory").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Accessory successfully added",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="inventory.php";
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


  $('#addMed').click(function () {
  	var med_brand = $('#med_brand').val();
  	var med_name = $('#med_name').val();
  	var med_supplier = $('#med_supplier').val();
  	var med_unit = $('#med_unit').val();
  	var med_qty = $('#med_qty').val();
  	var med_price = $('#med_price').val();
  	var med_exp_date = $('#med_exp_date').val();
  	var valid = true;

  	if(med_brand == ""){
  		valid = false;
      $(".med_brand_err").html(" *Required");
  	}else{
  		$(".med_brand_err").html("");
  	}

  	if(med_name == ""){
  		valid = false;
      $(".med_name_err").html(" *Required");
  	}else{
  		$(".med_name_err").html("");
  	}

  	if(med_supplier == ""){
  		valid = false;
      $(".med_supplier_err").html(" *Required");
  	}else{
  		$(".med_supplier_err").html("");
  	}

  	if(pr_unit == ""){
  		valid = false;
      $(".med_unit_err").html(" *Required");
  	}else{
  		$(".med_unit_err").html("");
  	}

  	if(med_qty == ""){
  		valid = false;
      $(".med_qty_err").html(" *Required");
  	}else{
  		$(".med_qty_err").html("");
  	}

  	if(med_price == ""){
  		valid = false;
      $(".med_price_err").html(" *Required");
  	}else{
  		$(".med_price_err").html("");
  	}

  	if(med_exp_date == ""){
  		valid = false;
      $(".med_exp_date_err").html(" *Required");
  	}else{
  		$(".med_exp_date_err").html("");
  	}

  	if(valid){
  		Swal.fire({
        title: 'Are you sure to add medicine?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
    	if (result.isConfirmed) {
	      var form_data = {
	        med_brand : med_brand,
	        med_name : med_name,
	        med_supplier : med_supplier,
	        unit : med_unit,
	        qty : med_qty,
	        price : med_price,
	        exp_date : med_exp_date
      	};  

    		$.ajax({
        	url : "insert_medicine.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#addMedicine").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Medicine successfully added",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="inventory.php";
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


  $('#savePr').click(function () {
  	var pr_id = $('#epr_id').val();
  	var pr_brand = $('#epr_brand').val();
  	var pr_name = $('#epr_name').val();
  	var pr_supplier = $('#epr_supplier').val();
  	var pr_unit = $('#epr_unit').val();
  	var pr_qty = $('#epr_qty').val();
  	var pr_price = $('#epr_price').val();
  	var pr_exp_date = $('#epr_exp_date').val();
  	var valid = true;

  	if(pr_brand == ""){
  		valid = false;
      $(".pr_brand_err").html(" *Required");
  	}else{
  		$(".pr_brand_err").html("");
  	}

  	if(pr_name == ""){
  		valid = false;
      $(".pr_name_err").html(" *Required");
  	}else{
  		$(".pr_name_err").html("");
  	}

  	if(pr_supplier == ""){
  		valid = false;
      $(".pr_supplier_err").html(" *Required");
  	}else{
  		$(".pr_supplier_err").html("");
  	}

  	if(pr_unit == ""){
  		valid = false;
      $(".pr_unit_err").html(" *Required");
  	}else{
  		$(".pr_unit_err").html("");
  	}

  	if(pr_qty == ""){
  		valid = false;
      $(".pr_qty_err").html(" *Required");
  	}else{
  		$(".pr_qty_err").html("");
  	}

  	if(pr_price == ""){
  		valid = false;
      $(".pr_price_err").html(" *Required");
  	}else{
  		$(".pr_price_err").html("");
  	}

  	if(pr_exp_date == ""){
  		valid = false;
      $(".pr_exp_date_err").html(" *Required");
  	}else{
  		$(".pr_exp_date_err").html("");
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
	      	pr_id : pr_id,
	        pr_brand : pr_brand,
	        pr_name : pr_name,
	        pr_supplier : pr_supplier,
	        unit : pr_unit,
	        qty : pr_qty,
	        price : pr_price,
	        exp_date : pr_exp_date
      	};  

    		$.ajax({
        	url : "update_product.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#editProduct").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Product successfully updated",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="inventory.php";
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


  $('#saveAcc').click(function () {
  	var acc_id = $('#eacc_id').val();
  	var acc_brand = $('#eacc_brand').val();
  	var acc_name = $('#eacc_name').val();
  	var acc_supplier = $('#eacc_supplier').val();
  	var acc_qty = $('#eacc_qty').val();
  	var acc_price = $('#eacc_price').val();
  	var valid = true;

  	if(acc_brand == ""){
  		valid = false;
      $(".acc_brand_err").html(" *Required");
  	}else{
  		$(".acc_brand_err").html("");
  	}

  	if(acc_name == ""){
  		valid = false;
      $(".acc_name_err").html(" *Required");
  	}else{
  		$(".acc_name_err").html("");
  	}

  	if(acc_supplier == ""){
  		valid = false;
      $(".acc_supplier_err").html(" *Required");
  	}else{
  		$(".acc_supplier_err").html("");
  	}

  	if(acc_qty == ""){
  		valid = false;
      $(".acc_qty_err").html(" *Required");
  	}else{
  		$(".acc_qty_err").html("");
  	}

  	if(acc_price == ""){
  		valid = false;
      $(".acc_price_err").html(" *Required");
  	}else{
  		$(".acc_price_err").html("");
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
	      	acc_id : acc_id,
	        acc_brand : acc_brand,
	        acc_name : acc_name,
	        acc_supplier : acc_supplier,
	        qty : acc_qty,
	        price : acc_price
      	};  

    		$.ajax({
        	url : "update_accessory.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#editAccessory").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Accessory successfully updated",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="inventory.php";
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


  $('#saveMed').click(function () {
  	var med_id = $('#emed_id').val();
  	var med_brand = $('#emed_brand').val();
  	var med_name = $('#emed_name').val();
  	var med_supplier = $('#emed_supplier').val();
  	var med_unit = $('#emed_unit').val();
  	var med_qty = $('#emed_qty').val();
  	var med_price = $('#emed_price').val();
  	var med_exp_date = $('#emed_exp_date').val();
  	var valid = true;

  	if(med_brand == ""){
  		valid = false;
      $(".med_brand_err").html(" *Required");
  	}else{
  		$(".med_brand_err").html("");
  	}

  	if(med_name == ""){
  		valid = false;
      $(".med_name_err").html(" *Required");
  	}else{
  		$(".med_name_err").html("");
  	}

  	if(med_supplier == ""){
  		valid = false;
      $(".med_supplier_err").html(" *Required");
  	}else{
  		$(".med_supplier_err").html("");
  	}

  	if(pr_unit == ""){
  		valid = false;
      $(".med_unit_err").html(" *Required");
  	}else{
  		$(".med_unit_err").html("");
  	}

  	if(med_qty == ""){
  		valid = false;
      $(".med_qty_err").html(" *Required");
  	}else{
  		$(".med_qty_err").html("");
  	}

  	if(med_price == ""){
  		valid = false;
      $(".med_price_err").html(" *Required");
  	}else{
  		$(".med_price_err").html("");
  	}

  	if(med_exp_date == ""){
  		valid = false;
      $(".med_exp_date_err").html(" *Required");
  	}else{
  		$(".med_exp_date_err").html("");
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
	      	med_id : med_id,
	        med_brand : med_brand,
	        med_name : med_name,
	        med_supplier : med_supplier,
	        unit : med_unit,
	        qty : med_qty,
	        price : med_price,
	        exp_date : med_exp_date
      	};  

    		$.ajax({
        	url : "update_medicine.php",
        	type : "POST",
        	data : form_data,
        	dataType: "json",
          success: function(response){
            if(response['valid']==false){
              alert(response['msg']);
            }else{
              $("#editMedicine").modal('hide');
              Swal.fire({
                title: 'Success!',
                text: "Medicine successfully updated",
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
              if (result.isConfirmed) {
                document.location.href="inventory.php";
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