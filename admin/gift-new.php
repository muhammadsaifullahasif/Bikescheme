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
					<h5 class="card-title">Add Gift</h5>
				</div>
				<div class="card-body">
					<form class="form">
						<div class="form-group">
							<label>Select Scheme:</label>
							<select class="custom-select">
								<option>Select Scheme</option>
							</select>
						</div>
						<div class="form-group">
							<label>Gift Name:</label>
							<input type="text" class="form-control" placeholder="Enter Gift Name" name="">
						</div>
						<div class="form-group">
							<label class="d-block">Gift Type:</label>
							<input type="checkbox" id="bumper-prize" name="">
							<label for="bumper-prize" class="form-check-label">Bumper Prize</label>
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