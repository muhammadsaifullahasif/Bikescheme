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
					<h5 class="card-title">Manage Site</h5>
				</div>
				<div class="card-body">
					<form class="form">
						<p class="text-danger form-text text-center">Manage your site from this setting zone</p>
						<div class="form-group">
							<label>Admin Email Address:</label>
							<input type="email" class="form-control" placeholder="Enter Admin Email Address" name="">
						</div>
						<div class="form-group">
							<label>Admin Name:</label>
							<input type="text" class="form-control" placeholder="Enter Admin Name" name="">
						</div>
						<div class="form-group">
							<label>Contact Us Email:</label>
							<input type="email" class="form-control" placeholder="Enter Contact Us Email" name="">
						</div>
						<div class="form-group">
							<label>Phone Number:</label>
							<input type="tel" class="form-control" placeholder="Enter Phone Number" name="">
						</div>
						<div class="form-group">
							<label>Skype ID:</label>
							<input type="text" class="form-control" placeholder="Enter Skype ID" name="">
						</div>
						<div class="form-group">
							<label>Facebook URL:</label>
							<input type="url" class="form-control" placeholder="Enter Facebook URL" name="">
						</div>
						<div class="form-group">
							<label>Site Name:</label>
							<input type="text" class="form-control" placeholder="Enter Site Name" name="">
						</div>
						<div class="form-group">
							<label>Site URL:</label>
							<input type="url" class="form-control" placeholder="Enter Site URL" name="">
						</div>
						<div class="form-group">
							<label>Site Keywords:</label>
							<input type="text" class="form-control" placeholder="Enter Site Keywords (seperate with , commas)" name="">
						</div>
						<div class="form-group">
							<label>Site Description:</label>
							<textarea class="form-control" placeholder="Enter Site Description" rows="4"></textarea>
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