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
							<h5 class="card-title">Gallery</h5>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="card mb-3">
										<i class="fas fa-image fa-5x text-center" style="font-size: 200px" class="card-img-top"></i>
										<div class="card-body">
											<h5 class="card-title">Image Gallery</h5>
											<a href="" class="btn btn-dark">View Images</a>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card mb-3">
										<i class="fas fa-video fa-5x text-center" style="font-size: 200px" class="card-img-top"></i>
										<div class="card-body">
											<h5 class="card-title">Video Gallery</h5>
											<a href="" class="btn btn-dark">Watch Videos</a>
										</div>
									</div>
								</div>
							</div>
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