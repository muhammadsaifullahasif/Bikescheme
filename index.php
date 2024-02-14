<?php

include "include/include.inc.php";
$time_created = time();

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
	<!-- Slider Start -->
	<?php include "slider.php"; ?>
	<!-- Slider End -->
	<!-- Announcement Start -->
	<?php include "announcement.php"; ?>
	<!-- Announcement End -->
	<!-- Main Start -->
	<section>
		<div class="container-fluid">
			<div class="row mt-3">
				<!-- Left Side Start -->
				<div class="col-lg-8">
					<div class="row mb-3">
						<?php

                        $gallery_query = "SELECT * FROM images i INNER JOIN media m ON i.id=m.for_id WHERE i.active_status='1' && i.delete_status='0' && m.media_for='4' ORDER BY i.time_created DESC LIMIT 4";
                        $conn->set_charset('utf8');
						$gallery_run = mysqli_query($conn, $gallery_query);
						if(mysqli_num_rows($gallery_run) > 0) {
							while($gallery_result = mysqli_fetch_assoc($gallery_run)) {
						?>
						<div class="col-md-6 mb-3">
							<div class="card">
								<a target="_blank" href="<?php echo $gallery_result['media_path']; ?>"><img style="height: 300px;" src="<?php echo $gallery_result['media_path']; ?>" alt="<?php echo $gallery_result['media_alt']; ?>" class="card-img-top"></a>
								<div class="card-body">
									<h5 class="card-title"><?php echo $gallery_result['title'] ?></h5>
									<p><?php echo $gallery_result['description']; ?></p>
								</div>
							</div>
						</div>
						<?php
							}
						}

						?>
					</div>
					<div class="row mb-3">
						<div class="col-12">
							<div class="jumbotron p-3"><h3>Our Scheme</h3></div>
							<div class="row">
								<?php

								$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE active_status='1' && delete_status='0'");
								if(mysqli_num_rows($scheme_query) > 0) {
									while($scheme_result = mysqli_fetch_assoc($scheme_query)) {
										$scheme_id = $scheme_result['id'];
										$scheme_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$scheme_id'");
										$scheme_media_query = mysqli_query($conn, "SELECT * FROM media WHERE scheme_id='$scheme_id' && media_for='1'");
										if(mysqli_num_rows($scheme_media_query) > 0) {
											$scheme_media_result = mysqli_fetch_assoc($scheme_media_query);
										}
										if(mysqli_num_rows($scheme_meta_query) > 0) {
											while($scheme_meta_result = mysqli_fetch_assoc($scheme_meta_query)) {
												$scheme_meta[$scheme_meta_result['meta_key']] = $scheme_meta_result['meta_value'];
											}
										}
								?>
								<div class="col-md-4 mb-3">
									<div class="card scheme-single">
										<a target="_blank" href="<?php echo $scheme_media_result['media_path']; ?>"><img src="<?php echo $scheme_media_result['media_path']; ?>" alt="<?php echo $scheme_result['title']; ?>" class="card-img-top"></a>
										<div class="card-body">
											<h5 class="card-title"><?php echo $scheme_result['title']; ?></h5>
											<p><b>Location:</b> <span><?php echo $scheme_meta['draw_place']; ?></span></p>
											<p><b>Draw Date:</b> <span><?php echo $scheme_meta['draw_date_time'] ?></span></p>
											<p><b>Draws:</b> <span><?php echo $scheme_meta['no_of_draws'] ?></span></p>
										</div>
									</div>
								</div>
								<?php
									}
								}

								?>
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