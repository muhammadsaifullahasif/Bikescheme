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
					<div class="card mb-2">
						<div class="card-header bg-dark text-white">
							<h5 class="card-title">Scheme</h5>
						</div>
						<div class="card-body">
							<div class="card mb-3">
								<div class="row">
									<?php

									$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE active_status='1' && delete_status='0'");
									if(mysqli_num_rows($scheme_query) > 0) {
										while($scheme_result = mysqli_fetch_assoc($scheme_query)) {
											$scheme_id = $scheme_result['id'];
											$scheme_meta_query = "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$scheme_id'";
											$conn->set_charset('utf8');
											$scheme_meta_run = mysqli_query($conn, $scheme_meta_query);
											$scheme_media_query = mysqli_query($conn, "SELECT * FROM media WHERE scheme_id='$scheme_id' && media_for='1'");
											if(mysqli_num_rows($scheme_media_query) > 0) {
												$scheme_media_result = mysqli_fetch_assoc($scheme_media_query);
											}
											if(mysqli_num_rows($scheme_meta_run) > 0) {
												while($scheme_meta_result = mysqli_fetch_assoc($scheme_meta_run)) {
													$scheme_meta[$scheme_meta_result['meta_key']] = $scheme_meta_result['meta_value'];
												}
											}
									?>
									<div class="col-md-4">
										<a target="_blank" href="<?php echo $scheme_media_result['media_path']; ?>"><img src="<?php echo $scheme_media_result['media_path']; ?>" alt="<?php echo $scheme_result['title']; ?>" class="card-img-top"></a>
									</div>
									<div class="col-md-8 py-2">
										<h6 class="card-title bg-danger text-white py-2 px-2"><?php echo $scheme_result['title']; ?></h6>
										<table class="table table-sm">
											<tr>
												<td>Location:</td>
												<td><?php echo $scheme_meta['draw_place']; ?></td>
											</tr>
											<tr>
												<td>Draw Date:</td>
												<td><?php echo $scheme_meta['draw_date_time'] ?></td>
											</tr>
											<tr>
												<td>Total Draws:</td>
												<td><?php echo $scheme_meta['no_of_draws'] ?></td>
											</tr>
											<tr>
											    <td colspan="2"><?php echo $scheme_meta['scheme_terms_conditions']; ?></td>
											</tr>
										</table>
										<a href="register.php" class="btn btn-dark">Register</a>
									</div>
									<?php
										}
									}

									?>
								</div>
							</div>
						</div>
					</div>
					<?php include "team-member.php"; ?>
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
	<script type="text/javascript">
		$(document).ready(function(){
			$('#loginBtn').on('click', function(e){
				e.preventDefault();
				var username = $('#username').val();
				var password = $('#password').val();
				var bool = 0;
				if(username == '') {
					$('#username').removeClass('is-valid').addClass('is-invalid');
					$('#username_msg').removeClass('valid-feedback').addClass('invalid-feedback').text('This field is required');
					bool = 0;
				} else {
					$('#username').removeClass('is-invalid');
					$('#username_msg').removeClass('invalid-feedback').text('');
				}
				$('#username').on('focus', function(){
					$('#username').removeClass('is-invalid');
					$('#username_msg').removeClass('invalid-feedback').text('');
				});
				if(password == '') {
					$('#password').removeClass('is-valid').addClass('is-invalid');
					$('#password_msg').removeClass('valid-feedback').addClass('invalid-feedback').text('This field is required');
					bool = 0;
				} else {
					$('#password').removeClass('is-invalid');
					$('#password_msg').removeClass('invalid-feedback').text('');
				}
				$('#password').on('focus', function(){
					$('#password').removeClass('is-invalid');
					$('#password_msg').removeClass('invalid-feedback').text('');
				});
				if(bool == 0) {
					$.ajax({
						url: 'ajax/login.php',
						type: 'POST',
						data: $('#login_form').serialize(),
						success: function(result) {
							if(result == 0) {
								$('#login_form_msg').removeClass('alert-success').addClass('alert alert-danger').html("<a class='close' href='#' data-dismiss='alert'>&times;</a>Both Fields Are Required");
							} else if(result == 1) {
								$('#login_form_msg').removeClass('alert-success').addClass('alert alert-danger').html("<a class='close' href='#' data-dismiss='alert'>&times;</a>No User Found");
							} else if(result == 2) {
								$('#login_form_msg').removeClass('alert-success').addClass('alert alert-danger').html("<a class='close' href='#' data-dismiss='alert'>&times;</a>Incorrect Login Detail Please Try Again");
							} else if(result == 3) {
								$('#login_form_msg').removeClass('alert-success').addClass('alert alert-danger').html("<a class='close' href='#' data-dismiss='alert'>&times;</a>Account is Inactive <a class='alert-link'>Contact Admin</a>");
							} else if(result == 4) {
								window.location.href = 'account/index.php';
							} else if(result == 5) {
								window.location.href = 'agent/index.php';
							} else if(result == 6) {
								window.location.href = 'admin/index.php';
							}
						}
					});
				}
			});
		});
	</script>
	<!-- Javascript Files End -->
</body>
</html>