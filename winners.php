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
							<h5 class="card-title">Winners</h5>	
						</div>
						<div class="card-body">
							<?php

							$winner_query = mysqli_query($conn, "SELECT * FROM draw ORDER BY time_created DESC LIMIT 3");
							if(mysqli_num_rows($winner_query) > 0) {
								while($winner_result = mysqli_fetch_assoc($winner_query)) {
									$winner_user_id = $winner_result['user_id'];
									$winner_scheme_id = $winner_result['scheme_id'];
									$user_meta_query = "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$winner_user_id'";
                					$conn->set_charset('utf8');
                					$user_meta_run = mysqli_query($conn, $user_meta_query);
                					if(mysqli_num_rows($user_meta_run) > 0) {
                					    while($user_meta_result = mysqli_fetch_assoc($user_meta_run)) {
                					        $user_meta[$user_meta_result['meta_key']] = $user_meta_result['meta_value'];
                					    }
                					}
									$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE id='$winner_scheme_id'");
									if(mysqli_num_rows($scheme_query) > 0) {
										$scheme_result = mysqli_fetch_assoc($scheme_query);
									}
									$media_query = mysqli_query($conn, "SELECT * FROM media WHERE user_id='$winner_user_id' && scheme_id='$winner_scheme_id' && media_for='2'");
									if(mysqli_num_rows($media_query) > 0) {
										$media_result = mysqli_fetch_assoc($media_query);
									}
							?>
							<div class="card mb-3">
								<div class="row">
									<div class="col-md-4">
										<img src="<?php echo $media_result['media_path']; ?>" class="card-img h-100">
									</div>
									<div class="col-md-8">
										<h5 class="card-title"><?php echo $user_meta['user_name']; ?></h5>
										<table class="table">
										    <tr>
										        <td>Membership Number:</td>
										        <td><b><?php echo $user_meta['user_shipno']; ?></b></td>
										    </tr>
											<tr>
												<td>Scheme:</td>
												<td><?php echo $scheme_result['title']; ?></td>
											</tr>
											<tr>
												<td>Draw:</td>
												<td><?php echo $winner_result['draw_number']; ?></td>
											</tr>
											<tr>
												<td>Prize:</td>
												<td><?php echo $winner_result['draw_prize']; ?></td>
											</tr>
											<tr>
												<td>Draw Date:</td>
												<td><?php echo $winner_result['draw_date']; ?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<?php
								}
							}

							?>
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