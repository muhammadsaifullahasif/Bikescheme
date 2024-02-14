<?php

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
					<h5 class="card-title">Admin Dashboard</h5>
				</div>
				<div class="card-body">
					<h6>Welcome to Control Panel</h6>
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
								<td>Total Number of Agents</td>
								<td><?php echo $totalAgents; ?></td>
							</tr>
							<tr>
								<td>4</td>
								<td>Total Monthly Received Payment</td>
								<td>Rs: <?php echo monthly_payment($conn, $next_draw); ?></td>
							</tr>
							<tr>
							    <td>5</td>
							    <td>Total Received Payment</td>
							    <td>Rs: <?php echo total_payment($conn); ?></td>
							</tr>
							<tr>
							    <td>6</td>
							    <td>Total Dues</td>
							    <td>Rs: <?php echo total_dues($conn); ?></td>
							</tr>
							<tr>
							    <td>7</td>
							    <td>Monthly Dues</td>
							    <td>Rs: <?php echo monthly_dues($conn, $next_draw); ?></td>
							</tr>
						</tbody>
					</table>
					<?php
					
					if(isset($_POST['search_btn'])) {
					    $q = mysqli_real_escape_string($conn, $_POST['q']);
					    echo "<script>window.location.href='search-user.php?q=".$q."';</script>";
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
					<div class="row mb-3">
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='scheme-detail.php?status=nonpaid'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-money-bill-alt card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Add Payment</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='scheme-detail.php?status=zero_transaction'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-times-circle text-danger card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Zero Payment</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='scheme-detail.php?status=nonpaid'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-user text-dark card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Non Paid User</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='scheme-detail.php?status=paid'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-user text-success card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Paid User</p>
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
							<a href='winners.php'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-trophy text-warning card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Winners</p>
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
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='delete_users.php'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-trash text-danger card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Delete Users</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='schemes.php'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-layer-group text-dark card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Manage Schemes</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='account-setting.php'><div class="card text-center mb-3 p-1">
								<i class="fas fa-5x mx-auto fa-key text-dark card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Account Setting</p>
								</div>
							</div></a>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-4" style="width: 50%">
							<a href='clearance-users.php'><div class="card text-center">
								<!--<i class="fas fa-5x mx-auto fa-badge-check text-success card-img-top"></i>-->
								<i class="fas fa-5x mx-auto fa-check-circle text-success card-img-top"></i>
								<div class="card-body">
									<p class="card-text">Clearance User</p>
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