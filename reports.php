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
	            <li><a class="dropdown-item text-success" href="services.php">Services</a></li>
	            <li><a class="dropdown-item text-white bg-success" href="reports.php">Reports</a></li>
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
		<h2 class="text-black-50 mb-3">Sales This Year</h2>
		<!-- <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
		  <button type="button" class="btn btn-success"><i class='bx bxs-filter-alt' ></i></button>

		  <div class="btn-group" role="group">
		    <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
		      Filter
		    </button>
		    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
		      <li><a class="dropdown-item bg-success text-white" href="#">This Year</a></li>
		      <li><a class="dropdown-item" href="#">This Month</a></li>
		      <li><a class="dropdown-item" href="#">This Week</a></li>
		      <li><a class="dropdown-item" href="#">This Day</a></li>
		    </ul>
		  </div>
		</div> -->
		<table id="myTable" class="display" style="width:100%">
		    <thead>
		        <tr>
		            <th>Brand</th>
		            <th>Product Name</th>
		            <th>Unit</th>
		            <th>Sold</th>
		            <th>Price</th>
		            <th style="background-color: #FAD4D4;">Total Sales</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php
            include 'config.php';
            $query = mysqli_query($conn, "SELECT brand, name, unit, COUNT(qty) as sold, price, SUM(total) as total FROM sales WHERE YEAR(curdate()) = YEAR(transaction_date) GROUP BY pr_id, acc_id, med_id ORDER BY total DESC");

            while($data = mysqli_fetch_assoc($query)){  
          ?>
		        <tr>
		            <td><?php echo $data['brand']; ?></td>
		            <td><?php echo $data['name']; ?></td>
		            <td><?php echo $data['unit']; ?></td>
		            <td><?php echo $data['sold']; ?></td>
		            <td><?php echo $data['price']; ?></td>
		            <td style="background-color: #FAD4D4;"><?php echo $data['total']; ?></td>
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
		            <th>Sold</th>
		            <th>Price</th>
		            <th style="background-color: #FAD4D4;">Total Sales</th>
		        </tr>
		    </tfoot>
		</table>
	</div>
	<!-- End of Tables -->


	<!-- Reports -->
	
	<div class="container p-4 mb-5 border bg-light shadow p-3 rounded">
		<div class="row">
			<div class="col">
				<canvas id="myChart" height="175"></canvas>
			</div>
			<div class="col">
				<canvas id="myChart1" height="175"></canvas>
			</div>
		</div>
	</div>


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

	const ctx = document.getElementById('myChart').getContext('2d');
	const ctx1 = document.getElementById('myChart1').getContext('2d');

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


	<?php
    include 'config.php';
    $jan = "";
    $feb = "";
    $mar = "";
    $apr = "";
    $may = "";
    $jun = "";
    $jul = "";
    $aug = "";
    $sep = "";
    $oct = "";
    $nov = "";
    $dec = "";

    $query = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '01'");
    while($data = mysqli_fetch_assoc($query)){  
    	if($data['sales'] == ""){
    		$jan = 0;
    	}else{
    		$jan = $data['sales'];
    	}
    }

    $query2 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '02'");
    while($data2 = mysqli_fetch_assoc($query2)){  
    	if($data2['sales'] == ""){
    		$feb = 0;
    	}else{
    		$feb = $data2['sales'];
    	}
    }

    $query3 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '03'");
    while($data3 = mysqli_fetch_assoc($query3)){  
    	if($data3['sales'] == ""){
    		$mar = 0;
    	}else{
    		$mar = $data3['sales'];
    	}
    }

    $query4 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '04'");
    while($data4 = mysqli_fetch_assoc($query4)){  
    	if($data3['sales'] == ""){
    		$apr = 0;
    	}else{
    		$apr = $data4['sales'];
    	}
    }

    $query5 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '05'");
    while($data5 = mysqli_fetch_assoc($query5)){  
    	if($data5['sales'] == ""){
    		$may = 0;
    	}else{
    		$may = $data5['sales'];
    	}
    }

    $query6 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '06'");
    while($data6 = mysqli_fetch_assoc($query6)){  
    	if($data6['sales'] == ""){
    		$jun = 0;
    	}else{
    		$jun = $data6['sales'];
    	}
    }

    $query7 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '07'");
    while($data7 = mysqli_fetch_assoc($query7)){  
    	if($data7['sales'] == ""){
    		$jul = 0;
    	}else{
    		$jul = $data7['sales'];
    	}
    }

    $query8 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '08'");
    while($data8 = mysqli_fetch_assoc($query8)){  
    	if($data8['sales'] == ""){
    		$aug = 0;
    	}else{
    		$aug = $data8['sales'];
    	}
    }

    $query9 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '09'");
    while($data9 = mysqli_fetch_assoc($query9)){  
    	if($data9['sales'] == ""){
    		$sep = 0;
    	}else{
    		$sep = $data9['sales'];
    	}
    }

    $query10 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '10'");
    while($data10 = mysqli_fetch_assoc($query10)){  
    	if($data10['sales'] == ""){
    		$oct = 0;
    	}else{
    		$oct = $data10['sales'];
    	}
    }

    $query11 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '11'");
    while($data11 = mysqli_fetch_assoc($query11)){  
    	if($data11['sales'] == ""){
    		$nov = 0;
    	}else{
    		$nov = $data11['sales'];
    	}
    }

    $query12 = mysqli_query($conn, "SELECT SUM(total) as sales FROM sales WHERE MONTH(transaction_date) = '12'");
    while($data12 = mysqli_fetch_assoc($query12)){  
    	if($data12['sales'] == ""){
    		$dec = 0;
    	}else{
    		$dec = $data12['sales'];
    	}
    }
  ?>

	const myChart1 = new Chart(ctx1, {
	    type: 'line',
	    data: {
	        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
	        datasets: [{
	            data: [<?php echo $jan; ?>,<?php echo $feb; ?>,<?php echo $mar; ?>,<?php echo $apr; ?>,<?php echo $may; ?>,<?php echo $jun; ?>,<?php echo $jul; ?>,<?php echo $aug; ?>,<?php echo $sep; ?>,<?php echo $oct; ?>,<?php echo $nov; ?>,<?php echo $dec; ?>],
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
	    			text: 'Monthly Sales This Year',
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