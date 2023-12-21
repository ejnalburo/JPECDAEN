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
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
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
	          <a class="h5 nav-link active text-success fw-bolder" aria-current="page" href="admin_index.php">Dashboard</a>
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

	<!-- Dashboard -->
	<div class="container my-3">
		<div class="row">
			<div class="col-lg p-3 border bg-success shadow rounded">
				<h4 class="float-end text-white"><img src="img/patient1.png" class="w-100" alt=""></h4>
				<p class="text-white">As of today:</p>
				<?php
          include 'config.php';
          $query = mysqli_query($conn, "SELECT count(app_id) as app FROM appointments WHERE app_date = CURDATE() ");

          while($data = mysqli_fetch_assoc($query)){  
        ?>
				<h4 class="text-white bold mt-4 fw-bolder"><?php if($data['app']==0){echo 0;}else{ echo $data['app'];} ?></h4>
				<?php
					}
				?>
				<h5 class="text-white">Patients</h5>
			</div>
			<div class="col-lg p-3 border bg-success shadow rounded">
				<h4 class="float-end text-white"><img src="img/product.png" class="w-100" alt=""></h4>
				<p class="text-white">As of today:</p>
				<?php
          include 'config.php';
          $query = mysqli_query($conn, "SELECT SUM(qty) as product FROM sales WHERE transaction_date = CURDATE()");

          while($data = mysqli_fetch_assoc($query)){  
        ?>
				<h4 class="text-white bold mt-4 fw-bolder"><?php if($data['product']==0){echo 0;}else{ echo $data['product'];}  ?></h4>
				<?php
					}
				?>
				<h5 class="text-white">Products</h5>
			</div>
			<div class="col-lg p-3 border bg-success shadow p-3 rounded">
				<h4 class="float-end text-white"><img src="img/sales.png" class="w-100" alt=""></h4>
				<p class="text-white">As of today:</p>
				<?php
          include 'config.php';
          $query = mysqli_query($conn, "SELECT SUM(total) as total FROM sales WHERE transaction_date = CURDATE()");

          while($data = mysqli_fetch_assoc($query)){  
        ?>
				<h4 class="text-white bold mt-4 fw-bolder">₱<?php if($data['total']==0){echo "0.00";}else{ echo $data['total'];}  ?></h4>
				<?php
					}
				?>
				<h5 class="text-white">Sales</h5>
			</div>
		</div>
	</div>				
	<!-- End of Dashboard -->

	<!-- Reports -->
	<div class="container p-4 my-5 border bg-light shadow p-3 rounded">
		<canvas id="myChart" width="400" height="200"></canvas>
	</div>
	<!-- End of Reports -->

	<!-- Tables -->
	<div class="container p-4 my-5 border bg-light shadow p-3 rounded table-responsive">
		<h2 class="text-black-50 mb-3">Nearly out of stock</h2>
		<a href="inventory.php"><button class="btn btn-success mb-3"><i class='bx bxs-hand-right me-2'></i>Go to Inventory</button></a>
		
		<table id="myTable" class="display" style="width:100%">
	        <thead>
	            <tr>
	              <th>Brand</th>
		            <th>Product Name</th>
		            <th>Unit</th>
		            <th>Price</th>
		            <th style="background-color: #FAD4D4;">Qty</th>
	            </tr>
	        </thead>
	        <tbody>
	        	<?php
	            include 'config.php';
	            $query = mysqli_query($conn, "SELECT * FROM products WHERE qty <= 50 ORDER BY qty ASC");

	            while($data = mysqli_fetch_assoc($query)){  
	          ?>
	            <tr>
	                <td><?php echo $data['pr_brand']; ?></td>
	                <td><?php echo $data['pr_name']; ?></td>
	                <td><?php echo $data['unit']; ?></td>
	                <td><?php echo $data['price']; ?></td>
	                <td style="background-color: #FAD4D4;"><?php echo $data['qty']; ?></td>
	            </tr>
	          <?php
	          	}
	          ?>

	          <?php
	            include 'config.php';
	            $query = mysqli_query($conn, "SELECT * FROM medicines WHERE qty <= 50 ORDER BY qty ASC");

	            while($data = mysqli_fetch_assoc($query)){  
	          ?>
	            <tr>
	                <td><?php echo $data['med_brand']; ?></td>
	                <td><?php echo $data['med_name']; ?></td>
	                <td><?php echo $data['unit']; ?></td>
	                <td><?php echo $data['price']; ?></td>
	                <td style="background-color: #FAD4D4;"><?php echo $data['qty']; ?></td>
	            </tr>
	          <?php
	          	}
	          ?>

	          <?php
	            include 'config.php';
	            $query = mysqli_query($conn, "SELECT * FROM accessories WHERE qty <= 50 ORDER BY qty ASC");

	            while($data = mysqli_fetch_assoc($query)){  
	          ?>
	            <tr>
	                <td><?php echo $data['acc_brand']; ?></td>
	                <td><?php echo $data['acc_name']; ?></td>
	                <td><?php echo $data['unit']; ?></td>
	                <td><?php echo $data['price']; ?></td>
	                <td style="background-color: #FAD4D4;"><?php echo $data['qty']; ?></td>
	            </tr>
	          <?php
	          	}
	          ?>
	        </tbody>
	        <tfoot>
	            <tr>
	                <th>Brand</th>
			            <th>Product Name</th>
			            <th>Unit</th>
			            <th>Price</th>
			            <th style="background-color: #FAD4D4;">Qty</th>
	            </tr>
	        </tfoot>
	    </table>
	</div>

	<div class="container p-4 my-5 border bg-light shadow p-3 rounded table-responsive">
		<h2 class="text-black-50 mb-3">Nearly Expired Products</h2>
		<a href="inventory.php"><button class="btn btn-success mb-3"><i class='bx bxs-hand-right me-2'></i>Go to Inventory</button></a>
		
		<table id="myTable2" class="display" style="width:100%">
	        <thead>
	            <tr>
	                <th>Brand</th>
		            <th>Product Name</th>
		            <th>Unit</th>
		            <th>Price</th>
		            <th>Qty</th>
		            <th style="background-color: #FAD4D4;">Expiration Date</th>
	            </tr>
	        </thead>
	        <tbody>
	          <?php
	            include 'config.php';
	            $query = mysqli_query($conn, "SELECT * FROM products WHERE YEAR(exp_date) <= YEAR(curdate()) ORDER BY qty ASC");

	            while($data = mysqli_fetch_assoc($query)){  
	          ?>
	            <tr>
	                <td><?php echo $data['pr_brand']; ?></td>
	                <td><?php echo $data['pr_name']; ?></td>
	                <td><?php echo $data['unit']; ?></td>
	                <td><?php echo $data['price']; ?></td>
	                <td><?php echo $data['qty']; ?></td>
	                <td style="background-color: #FAD4D4;"><?php echo $data['exp_date']; ?></td>
	            </tr>
	          <?php
	          	}
	          ?>

	          <?php
	            include 'config.php';
	            $query = mysqli_query($conn, "SELECT * FROM medicines WHERE YEAR(exp_date) <= YEAR(curdate()) ORDER BY qty ASC");

	            while($data = mysqli_fetch_assoc($query)){  
	          ?>
	            <tr>
	                <td><?php echo $data['med_brand']; ?></td>
	                <td><?php echo $data['med_name']; ?></td>
	                <td><?php echo $data['unit']; ?></td>
	                <td><?php echo $data['price']; ?></td>
	                <td><?php echo $data['qty']; ?></td>
	                <td style="background-color: #FAD4D4;"><?php echo $data['exp_date']; ?></td>
	            </tr>
	          <?php
	          	}
	          ?>
	        </tbody>
	        <tfoot>
	            <tr>
	                <th>Brand</th>
			            <th>Product Name</th>
			            <th>Unit</th>
			            <th>Price</th>
			            <th>Qty</th>
			            <th style="background-color: #FAD4D4;">Expiration Date</th>
	            </tr>
	        </tfoot>
	    </table>
	</div>
	<!-- End of Tables -->
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
        order: [[4, 'asc']],
    	});
    	$('#myTable2').DataTable({
    		lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, 'All'],
        ],
        order: [[5, 'asc']],
    	});

	} );
	
	<?php
    include 'config.php';
    $a = "";
    $b = "";
    $c = "";

    $query = mysqli_query($conn, "SELECT SUM(a.total) as qty, SUM(a.qty) as sold FROM sales a, products b WHERE a.pr_id = b.pr_id AND YEAR(transaction_date) = YEAR(CURDATE())");

    while($data = mysqli_fetch_assoc($query)){  
    	$a = $data['qty'];
    	$aa = "Sold: ".$data['sold'];
    }

    $query1 = mysqli_query($conn, "SELECT SUM(a.total) as qty, SUM(a.qty) as sold FROM sales a, accessories b WHERE a.acc_id = b.acc_id AND YEAR(transaction_date) = YEAR(CURDATE())");

    while($data1 = mysqli_fetch_assoc($query1)){  
    	$b = $data1['qty'];
    	$bb = "Sold: ".$data1['sold'];
    }

    $query2 = mysqli_query($conn, "SELECT SUM(a.total) as qty, SUM(a.qty) as sold FROM sales a, medicines b WHERE a.med_id = b.med_id AND YEAR(transaction_date) = YEAR(CURDATE())");

    while($data2 = mysqli_fetch_assoc($query2)){  
    	$c = $data2['qty'];
    	$cc = "Sold: ".$data2['sold'];
    }
  ?>

	const ctx = document.getElementById('myChart').getContext('2d');
	const myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	    		
	        labels: ['Food Products \n<?php echo $aa; ?>','Accessories \n<?php echo $bb; ?>','Medicines \n<?php echo $cc; ?>'],
	        datasets: [{
	            data: [<?php echo $a; ?>,<?php echo $b; ?>,<?php echo $c; ?>],
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255, 99, 132, 1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 4
	        }]
	    },
	    options: {
	    	plugins: {
	    		title: {
	    			display: true,
	    			text: 'Total Sales per Category (This Year)',
	    			font: {
	    					size: 20
	    			}
	    		},
	    		legend: {
	    			display: false,
	    			labels: {
	    				color: 'rgb(255, 99, 132)',
	    				text: 'Red'
	    			}
	    		}
	    	},
	        scales: {
	            y: {
	                beginAtZero: true
	            }
	        }
	    }
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
</script>				
</html>