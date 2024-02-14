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
				<div class="col-12">
					<div class="card">
						<div class="card-header bg-dark text-white">
							<h5 class="card-title">Login</h5>
						</div>
						<div class="card-body">
							<form class="form" id="login_form">
								<div id="login_form_msg" class="mb-3"></div>
								<div class="form-group">
									<!--<label>Username:</label>-->
									<input type="text" id="username" class="form-control" placeholder="Enter Username" name="username">
									<div id="username_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Password:</label>-->
									<input type="password" id="password" class="form-control" placeholder="Enter Password" name="password">
									<div id="password_msg"></div>
								</div>
								<button class="btn btn-dark" id="loginBtn" type="submit" name="loginBtn">Login</button>
							</form>
						</div>
					</div>
				</div>
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
			$('#username').focus();
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