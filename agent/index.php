<?php

include "../include/db.inc.php";
include "function.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include "head.php"; ?>
</head>
<body>
	<!-- Header Start -->
	<?php include "header.php"; ?>
	<!-- Header End -->
	<!-- Navigation Start -->
	<?php include "nav.php"; ?>
	<!-- Navigation End -->
	<section class="mt-3">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title">Agent Dashboard</h5>
				</div>
				<div class="card-body">
					<h6>Welcome to <?php echo $agent_meta['user_name']; ?></h6>
    				<div class="card card-body text-center">
    				    <?php
    				    
    				    if($totalUsers >= $scheme_group_limit) {
    				    ?>
    				    <h5 class="card-title text-success">Congratulations You win <?php echo floor($totalUsers/$scheme_group_limit) ?> bike, now pay 3 installments of your users and get a bike</h5>
    				    <?php
    				    }
    				    
    				    ?>
    				    <h5 class='card-title text-left d-inline'>Group Members <p class="d-inline text-success" style="font-size: 30px;"><?php echo $totalUsers.'/'.$scheme_group_limit; ?></p></h5>
    				    <div class="progress bg-info" style="height: 2rem;">
    					    <div class="progress-bar <?php if($totalUsers < $scheme_group_limit) echo "bg-danger"; else echo "bg-success"; ?>" role="progressbar" style="width: <?php echo ($totalUsers * (100/$scheme_group_limit)); ?>%" aria-valuenow="$scheme_group_limit" aria-valuemin="0" aria-valuemax="100"><b style='font-size: 20px'><?php echo $totalUsers.'/'.$scheme_group_limit; ?></b></div>
    					</div>
    				</div>
					<table class="table table-dark table-sm table-striped table-hover mt-2 mb-3">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Total Number of Users</td>
								<td><?php echo $totalUsers; ?></td>
							</tr>
							<tr>
								<td>2</td>
								<td>Total Number of Schemes</td>
								<td><?php echo $totalScheme; ?></td>
							</tr>
							<tr>
								<td>3</td>
								<td>Monthly Payment</td>
								<td>Rs: <?php echo monthly_payment($conn, $agent_id, $next_draw); ?></td>
							</tr>
							<tr>
							    <td>4</td>
							    <td>Total Payment</td>
							    <td>Rs: <?php echo total_payment($conn, $agent_id); ?></td>
							</tr>
							<tr>
							    <td>5</td>
							    <td>Total Dues</td>
							    <td>Rs: <?php echo total_dues($conn, $agent_id); ?></td>
							</tr>
							<tr>
							    <td>6</td>
							    <td>Monthly Dues</td>
							    <td>Rs: <?php echo monthly_dues($conn, $agent_id, $next_draw); ?></td>
							</tr>
						</tbody>
					</table>
					<?php
					
					if(isset($_POST['search_btn'])) {
					    $q = mysqli_real_escape_string($conn, $_POST['q']);
					    echo "<script>window.location.href='users.php?q=".$q."';</script>";
					}
					
					?>
					<form class="form form-row mb-3" method="POST">
						<div>
							<label>Membership Number</label>
						</div>
						<div class="col">
							<input type="text" class="form-control" placeholder="Enter Username" name="q">
						</div>
						<button class="btn btn-dark" type="submit" name="search_btn"><i class="fas fa-search"></i></button>
					</form>
					<div class='row mb-3'>
					    <div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='users.php?status=nonpaid'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-money-bill-alt card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Add Payment</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='users.php?status=zero_transaction'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-times-circle text-danger card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Zero Payment</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='users.php?status=paid'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-user text-success card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Paid Users</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='users.php?status=nonpaid'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-user text-dark card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Non Paid Users</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='users.php?status=active'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-user-check card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Active Users</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='users.php?status=inactive'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-user-times card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Inactive Users</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='users.php'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-users text-dark card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Manage Users</p>
								</div>
							</div></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Footer Start -->
	<?php include "footer.php"; ?>
	<!-- Footer End -->
	<?php include "js.php"; ?>
</body>
</html>