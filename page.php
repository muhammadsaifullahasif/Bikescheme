<?php

if(isset($_GET['page']) && isset($_GET['a'])) {
	header('location:register.php?agent_id='.$_GET['a']);
} else {
	header('location:index.php');
}

?>
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