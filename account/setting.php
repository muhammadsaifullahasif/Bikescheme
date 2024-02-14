<?php

include "function.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include "head.php"; ?>
</head>
<body>
	<?php include "header.php"; ?>
	<?php include "nav.php"; ?>
	<section class="my-3">
		<div class="container-fluid">
			<ul class="nav bg-dark text-white nav-justified">
				<li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
				<li class="nav-item"><a href="transaction.php" class="nav-link text-white">Transaction</a></li>
				<li class="nav-item"><a href="setting.php" class="nav-link text-white">Setting</a></li>
			</ul>
			<div class="card mt-3">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title">Setting</h5>
				</div>
				<div class="card-body">
					<div class="mb-2">
						<?php

						if(isset($_POST['change_username'])) {
							$old_username = mysqli_real_escape_string($conn, $_POST['old_username']);
							$new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
							if($old_username != '' && $new_username != '') {
								$check_username = mysqli_query($conn, "SELECT * FROM users WHERE user_login='$old_username'");
								if(mysqli_num_rows($check_username) > 0) {
									$update_username = mysqli_query($conn, "UPDATE users SET user_login='$new_username' WHERE user_login='$old_username'");
									if($update_username) {
										$_SESSION['bikescheme_user_login'] = $new_username;
										echo "<div class='alert alert-success'><a class='close' data-dismiss='alert' href='#'>&times;</a>Username is Successfully Updated</div>";
										echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=setting.php'>";
									} else {
										echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>Username is not Updated Please Try Again</div>";
									}
								} else {
									echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>Old Username is incorrect</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>Please Fill Both Fields</div>";
							}
						}

						if(isset($_POST['change_password'])) {
							$old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
							$new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
							$new_pass = password_hash($new_password, PASSWORD_DEFAULT);
							$confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
							if($old_password != '' && $new_password != '' && $confirm_password != '') {
								if($new_password == $confirm_password) {
									$check_pass = mysqli_query($conn, "SELECT user_pass FROM users WHERE user_login='$user_login'");
									if(mysqli_num_rows($check_pass) > 0) {
										$check_pass_result = mysqli_fetch_assoc($check_pass);
										if(password_verify($old_password, $check_pass_result['user_pass'])) {
											$update_password = mysqli_query($conn, "UPDATE users SET user_pass='$new_pass' WHERE user_login='$user_login'");
											if($update_password) {
												echo "<div class='alert alert-success'><a class='close' data-dismiss='alert' href='#'>&times;</a>Password is Successfully Updated</div>";
												echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=setting.php'>";
											} else {
												echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>Password is not Updated Please Try Again</div>";
											}
										} else {
											echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>Old Password is Incorrect</div>";
										}
									} else {
										echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>No User Found</div>";
									}
								} else {
									echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>New Password and Confirm Password Not Matched</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert' href='#'>&times;</a>Please Fill All Fields</div>";
							}
						}

						?>
					</div>
					<form class="form" method="post">
						<div class="card mb-3">
							<div class="card-header bg-dark text-white py-1">
								<h5 class="card-title mb-0">Change Username</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<!--<label>Old Username:</label>-->
									<input type="text" required class="form-control" placeholder="Enter Old Username" id="old_username" name="old_username">
									<div id="old_username_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>New Username:</label>-->
									<input type="text" required class="form-control" placeholder="Enter New Username" id="new_usename" name="new_username">
									<div id="new_username_msg"></div>
								</div>
								<button class="btn btn-dark" type="submit" name="change_username">Change Username</button>
							</div>
						</div>
					</form>
					<form class="form" method="post">
						<div class="card mb-3">
							<div class="card-header bg-dark text-white py-1">
								<h5 class="card-title mb-0">Change Password</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<!--<label>Old Password:</label>-->
									<input type="text" required class="form-control" placeholder="Enter Old Password" id="old_password" name="old_password">
									<div id="old_password"></div>
								</div>
								<div class="form-group">
									<!--<label>New Password:</label>-->
									<input type="password" required class="form-control" placeholder="Enter New Password" id="new_password" name="new_password">
									<div id="new_password_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Confirm New Password:</label>-->
									<input type="password" required class="form-control" placeholder="Enter New Password Again" id="confirm_password" name="confirm_password">
									<div id="confirm_password_msg"></div>
								</div>
								<button class="btn btn-dark" type="submit" name="change_password">Change Password</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<?php include "../footer.php"; ?>
	<?php include "js.php"; ?>
</body>
</html>