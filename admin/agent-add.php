<?php

include "function.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include "head.php"; ?>
</head>
<body>
	<!-- Header Start -->
	<?php include "header.php"; ?>
	<!-- Header End -->
	<!-- Navigation Start -->
	<?php include "nav.php"; ?>
	<!-- Navigation End -->
	<!-- Main Start -->
	<section class="mt-3">
		<div class="container-fluid">
			<div class="card mb-3">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title d-inline">Add Agent</h5>
					<a href="agents.php" class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<div id="msg" class="mb-3">
						<?php

						if(isset($_POST['agent_add_btn'])) {
							$username = mysqli_real_escape_string($conn, $_POST['username']);
							$name = mysqli_real_escape_string($conn, $_POST['name']);
							$father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
							$email = mysqli_real_escape_string($conn, $_POST['email']);
							$password = mysqli_real_escape_string($conn, $_POST['password']);
							$user_pass = password_hash($password, PASSWORD_DEFAULT);
							$gender = mysqli_real_escape_string($conn, $_POST['gender']);
							$cnic = mysqli_real_escape_string($conn, $_POST['cnic']);
							$phone = mysqli_real_escape_string($conn, $_POST['phone']);
							$address = mysqli_real_escape_string($conn, $_POST['address']);
							$serial_prefix = mysqli_real_escape_string($conn, $_POST['serial_prefix']);
							if($_FILES['profile_image'] != '') {
								$media_name = $_FILES['profile_image']['name'];
								$media_type = $_FILES['profile_image']['type'];
								$media_size = $_FILES['profile_image']['size'];
								$path = "images/".time().str_replace(" ", "-", $_FILES['profile_image']['name']);
								$link = $url.$path;
								move_uploaded_file($_FILES['profile_image']['tmp_name'], $path);
							} else {
							    $media_name = '';
							    $media_type = '';
							    $media_size = '';
								$link = $mainURL.'images/no_image.jpg';
							}
							$id_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users ORDER BY time_created DESC LIMIT 1"));
							if(isset($id_query['id']) == 0) {
								$id = 1;
							} else {
								$id = $id_query['id'];
								$id++;
							}
							$time_created = time();
							if($name != '' && $father_name != '' && $password != '' && $gender != '' && $cnic != '' && $phone != '' && $address != '' && $serial_prefix != '') {
								$query = mysqli_query($conn, "INSERT INTO users(id, user_login, user_pass, user_email, user_phone, role, active_status, time_created) VALUES('$id', '$username', '$user_pass', '$email', '$phone', '1', '1', '$time_created')") or die(mysqli_error($conn));
								$meta = mysqli_query($conn, "INSERT INTO user_meta(user_id, meta_name, meta_key, meta_value) VALUES('$id', 'Name', 'user_name', '$name'), ('$id', 'Father Name', 'user_father_name', '$father_name'), ('$id', 'Gender', 'user_gender', '$gender'), ('$id', 'CNIC', 'user_cnic', '$cnic'), ('$id', 'Address', 'user_address', '$address'), ('$id', 'Serial Prefix', 'user_serial_prefix', '$serial_prefix'), ('$id', 'Allow Transaction', 'user_allow_transaction', 'no')");
								$image = mysqli_query($conn, "INSERT INTO media(user_id, media_name, media_path, media_type, media_size, media_for, time_created) VALUES('$id', '$media_name', '$link', '$media_type', '$media_size', '2', '$time_created')");
								if($query && $meta && $image) {
									echo "<div class='alert alert-success'><a href='#' data-dismiss='alert' class='close'>&times;</a>Agent is Successfully Added</div>";
								} else {
									echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>Agent is Not Added Please Try Again</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>All Fields Are Required</div>";
							}
						}

						?>
					</div>
					<form class="form" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input type="text" required class="form-control" placeholder="Enter Username" id="username" name="username">
							<div id="username_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" required class="form-control" placeholder="Enter Name" id="name" name="name">
							<div id="name_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" required placeholder="Enter Father Name" id="father_name" name="father_name">
							<div id="father_name_msg"></div>
						</div>
						<div class="form-group">
							<input type="email" class="form-control" placeholder="Enter Email" id="email" name="email">
							<div id="email_msg"></div>
						</div>
						<div class="form-group">
							<!--<label>Password:</label>-->
							<input type="text" class="form-control" required placeholder="Enter Password" id="password" name="password">
							<div id="password_msg"></div>
						</div>
						<div class="form-group">
							<div class="form-check-inline">
								<input type="radio" value="Male" required class="form-check-input" id="male" name="gender">
								<label class="form-check-label" for="male">Male</label>
							</div>
							<div class="form-check-inline">
								<input type="radio" class="form-check-input" required value="Female" id="female" name="gender">
								<label class="form-check-label" for="female">Female</label>
							</div>
							<div id="gender_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" required placeholder="Enter CNIC" id="cnic" name="cnic">
							<div id="cnic"></div>
						</div>
						<div class="form-group">
							<input type="tel" class="form-control" required placeholder="Enter Phone" id="phone" name="phone">
							<div id="phone_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" required id="address" name="address" placeholder="Enter Address" rows="4"></textarea>
							<div id="address_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter Serial Prefix" name="serial_prefix">
							<div id="serial_prefix_msg"></div>
						</div>
						<div class="form-group">
							<label>Profile Image:</label>
							<input type="file" class="d-block" name="profile_image">
						</div>
						<button class="btn btn-dark" name="agent_add_btn" id="agent_add_btn">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!-- Main End -->
	<!-- Footer Start -->
	<?php include "footer.php"; ?>
	<!-- Footer End -->
	<?php include "js.php"; ?>
</body>
</html>