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
							<h5 class="card-title">Contact</h5>
						</div>
						<div class="card-body">
							<div class="mb-2">
								<?php

								if(isset($_POST['contact_btn'])) {
									$name = mysqli_real_escape_string($conn, $_POST['name']);
									$email = mysqli_real_escape_string($conn, $_POST['email']);
									$phone = mysqli_real_escape_string($conn, $_POST['phone']);
									$subject = mysqli_real_escape_string($conn, $_POST['subject']);
									$message = mysqli_real_escape_string($conn, $_POST['message']);
									if($name != '' && $phone != '' && $subject != '' && $message != '') {
										$time_created = time();
										$contact_query = mysqli_query($conn, "INSERT INTO message(name, email, phone, subject, message, time_created) VALUES('$name', '$email', '$phone', '$subject', '$message', '$time_created')");
										if($contact_query) {
											echo "<div class='alert alert-success'><a href='#' data-dismiss='alert' class='close'>&times;</a>Your Message is Successfully Delivered<hr>Please wait we will contact you soon.</div>";
										} else {
											echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>Your Message is Not Delivered Please Try Again</div>";
										}
									}
								}

								?>
							</div>
							<form class="form mb-2" method="post">
								<div class="form-group">
									<!--<label>Name:</label>-->
									<input type="text" required class="form-control" placeholder="Enter Name" id="name" name="name">
								</div>
								<div class="form-group">
									<!--<label>Email:</label>-->
									<input type="email" class="form-control" placeholder="Enter Email" id="email" name="email">
								</div>
								<div class="form-group">
									<!--<label>Phone:</label>-->
									<input type="tel" required class="form-control" placeholder="Enter Phone" id="phone" name="phone">
								</div>
								<div class="form-group">
									<!--<label>Subject:</label>-->
									<input type="text" required class="form-control" placeholder="Enter Subject" id="subject" name="subject">
								</div>
								<div class="form-group">
									<!--<label>Message:</label>-->
									<textarea class="form-control" required placeholder="Enter Message" name="message" id="message" rows="8"></textarea>
								</div>
								<button class="btn btn-dark" type="submit" name="contact_btn" id="contact_btn">Send</button>
							</form>
							<div class="card-body">
								<?php

								$setting_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM setting");
								if(mysqli_num_rows($setting_query) > 0) {
									while($setting_result = mysqli_fetch_assoc($setting_query)) {
										$setting_meta[$setting_result['meta_key']] = $setting_result['meta_value'];
									}
								}

								?>
								<p>WhatsApp Number: <span class="text-success" style="font-weight: bold;"><?php echo $setting_meta['whatsapp_number']; ?></span></p>
								<p>Phone Number: <span class="text-success" style="font-weight: bold;"><?php echo $setting_meta['phone_number']; ?></span></p>
								<p>Email: <span class="text-success" style="font-weight: bold;"><?php echo $setting_meta['site_email']; ?></span></p>
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