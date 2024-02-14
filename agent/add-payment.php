<?php

include "../include/db.inc.php";

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
	<!-- Main Start -->
	<section class="mt-3">
		<div class="container-fluid">
			<div class="card mb-3">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title">Transaction</h5>
				</div>
				<div class="card-body">
					<table class="table table-sm table-striped">
						<tr>
							<td>Scheme:</td>
							<td>Scheme name goes here...</td>
							<td>User Membership</td>
							<td>membership number goes here...</td>
						</tr>
						<tr>
							<td>Name:</td>
							<td>name goes here...</td>
							<td>CNIC:</td>
							<td>cnic goes here...</td>
						</tr>
						<tr>
							<td>Mobile:</td>
							<td>mobile number goes here...</td>
							<td>Email:</td>
							<td>email goes here...</td>
						</tr>
						<tr>
							<td>Installment per month:</td>
							<td>Rs: 3000</td>
							<td>Total Installment:</td>
							<td>18</td>
						</tr>
						<tr>
							<td>Paid Installment:</td>
							<td>0</td>
							<td>Dues:</td>
							<td>0</td>
						</tr>
					</table>
					<table class="table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Payment</th>
								<th>Dues</th>
								<th>Collector</th>
								<th>Date</th>
								<th>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Payment</th>
								<th>Dues</th>
								<th>Collector</th>
								<th>Date</th>
								<th>Options</th>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<td>1</td>
								<td>Rs: 3000</td>
								<td>Rs: +5000</td>
								<td>Asif Mehmood</td>
								<td>11-11-2020</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	<!-- Main End -->
	<!-- Footer Start -->
	<?php include "footer.php"; ?>
	<!-- Footer End -->
	<?php include "js.php"; ?>
</body>
</html>