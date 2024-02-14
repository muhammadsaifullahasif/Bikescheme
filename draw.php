<!DOCTYPE html>
<html>
<head>
	<!-- Head Files Start -->
	<?php include "head.php"; ?>
	<!-- Head Files End -->
</head>
<body>
	<!-- Header Start -->
	<?php include "header.php"; ?>
	<!-- Header End -->
	<!-- Nav Start -->
	<?php include "nav.php"; ?>
	<!-- Nav End -->
	<!-- Main Start -->
	<section>
		<div class="container-fluid">
			<div class="row mt-3">
				<!-- Left Side Start -->
				<div class="col-lg-8">
					<div class="card mb-3">
						<div class="card-header bg-dark text-white">
							<h5>Scheme Name Goes Here</h5>
						</div>
						<div class="card-body text-center">
							<p class="mb-2"><b>Draw Number: </b>3</p>
							<p class="mb-2"><b>Paid User: </b>100</p>
							<div class="counter text-danger" id="draw-counter">
								<b class="h4">14days : 7hours : 3mins : 0sec</b>
							</div>
							<div class="draw-winner" id="draw-winner">
								<p class="mb-2">Prize One Winner <b>Winner Name Goes Here</b></p>
								<p class="mb-2">Prize One Winner <b>Winner Name Goes Here</b></p>
							</div>
							<table class="table table-dark table-striped mt-4 mb-3 table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Name Of Prize</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>Prize Name Goes Here</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Prize Name Goes Here</td>
									</tr>
								</tbody>
							</table>
							<table id="draw-paid-user" class="table table-dark table-striped table-hover mt-4 mb-3">
								<thead>
									<tr>
										<th>#</th>
										<th>Name Of User</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>#</th>
										<th>Name Of User</th>
									</tr>
								</tfoot>
								<tbody>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Name of User</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- Left Side End -->
				<!-- Right Side Start -->
				<?php include "right-side.php"; ?>
				<!-- Right Side End -->
			</div>
		</div>
	</section>
	<!-- Main End -->
	<!-- Footer Start -->
	<?php include "footer.php"; ?>
	<!-- Footer End -->
	<!-- Javascript Files Start -->
	<?php include "js.php"; ?>
	<!-- Javascript Files End -->
</body>
</html>