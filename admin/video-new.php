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
					<h5 class="card-title d-inline">Add Videos</h5>
					<a class='btn btn-dark' href='videos.php'>Back</a>
				</div>
				<div class="card-body">
					<form class="form">
						<div class="form-group">
							<select class="custom-select">
								<option>Select Scheme</option>
							</select>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter Video Name" name="">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter Video Alt Text" name="">
						</div>
						<div class="form-group">
							<label>Upload Video:</label>
							<input type="file" class="d-block" multiple name="">
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