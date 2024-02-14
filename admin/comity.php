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
					<h5 class="card-title">Add User Comity</h5>
				</div>
				<div class="card-body">
					<form class="form">
						<p class="text-muted">From here you can add another comity for user</p>
						<div class="form-group">
							<label>Enroll for Comity:</label>
							<select class="custom-select">
								<option>Select Scheme</option>
							</select>
						</div>
						<div class="form-group">
							<label>User Name</label>
							<select class="custom-select">
								<option>Select User</option>
							</select>
						</div>
						<button class="btn btn-dark">Submit</button>
					</form>
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