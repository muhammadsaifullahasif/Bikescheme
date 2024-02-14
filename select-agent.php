<?php

include "include/include.inc.php";

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
					<div class="card mt-2 mb-3">
						<div class="card-header bg-dark text-white">
							<h5 class="card-title">Select Agent</h5>
						</div>
						<div class="card-body">
							<?php

							if(isset($_POST['select_agent_btn'])) {
								$agent_id = mysqli_real_escape_string($conn, $_POST['agent_id']);
								if($agent_id != '') {
								    echo "<script>window.location.href='register.php?agent_id=".$agent_id."';</script>";
								} else {
									echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>Please Select Any Agent</div>";
								}
							}

							?>
							<form class="form" method="post">
								<div class="form-group">
									<label>Select Agent:</label>
									<select class="custom-select" name="agent_id">
										<option value="">Select Agent</option>
										<?php

										$agent_query = mysqli_query($conn, "SELECT u.id, m.meta_value FROM users u INNER JOIN user_meta m ON u.id=m.user_id WHERE u.role='1' && u.active_status='1' && u.delete_status='0' && m.meta_key='user_name'");
										if(mysqli_num_rows($agent_query) > 0) {
											while($agent_result = mysqli_fetch_assoc($agent_query)) {
												echo "<option value='".$agent_result['id']."'>".$agent_result['meta_value']."</option>";
											}
										}

										?>
									</select>
								</div>
								<button type="submit" name="select_agent_btn" class="btn btn-dark">Next</button>
							</form>
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