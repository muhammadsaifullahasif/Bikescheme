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
					<div class="card mb-2">
						<div class="card-header bg-dark text-white">
							<h5 class="card-title float-left">Video Gallery</h5>
							<select class="float-right w-25 custom-select-sm custom-select">
								<option>Select Scheme</option>
								<option>All</option>
							</select>
						</div>
						<div class="card-body">
							
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