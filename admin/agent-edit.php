<?php

include "function.php";

if(isset($_GET['id'])) {
	$id = mysqli_real_escape_string($conn, $_GET['id']);
} else {
	header('location:users.php');
}

$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
if(mysqli_num_rows($query) > 0) {
	$result = mysqli_fetch_assoc($query);
	$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
	if(mysqli_num_rows($meta_query) > 0) {
		while($meta_result = mysqli_fetch_assoc($meta_query)) {
			$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
		}
	}
	$media_query = mysqli_query($conn, "SELECT media_path FROM media WHERE user_id='$id' && media_for='2'");
	if(mysqli_num_rows($media_query) > 0) {
		$media = mysqli_fetch_assoc($media_query);
	}
}

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
					<h5 class="card-title d-inline">Edit Agent</h5>
					<a href="agents.php" class="btn btn-dark float-right">Back</a>
				</div>
				<div class="card-body">
					<div class="mb-2">
						<?php

						if(isset($_POST['agent_add_btn'])) {
							$username = mysqli_real_escape_string($conn, $_POST['username']);
							$name = mysqli_real_escape_string($conn, $_POST['name']);
							$father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
							$email = mysqli_real_escape_string($conn, $_POST['email']);
							$gender = mysqli_real_escape_string($conn, $_POST['gender']);
							$cnic = mysqli_real_escape_string($conn, $_POST['cnic']);
							$phone = mysqli_real_escape_string($conn, $_POST['phone']);
							$address = mysqli_real_escape_string($conn, $_POST['address']);
							$serial_prefix = mysqli_real_escape_string($conn, $_POST['serial_prefix']);
							$status = mysqli_real_escape_string($conn, $_POST['status']);
							if($_FILES['profile_image']['name'] == '') {
								$link = $media['media_path'];
							} else {
								$media_name = $_FILES['profile_image']['name'];
								$media_type = $_FILES['profile_image']['type'];
								$media_size = $_FILES['profile_image']['size'];
								$path = "images/".time().str_replace(" ", "-", $_FILES['profile_image']['name']);
								$link = $url.$path;
								move_uploaded_file($_FILES['profile_image']['tmp_name'], $path);
							}
							if($username != '' && $name != '' && $father_name != '' && $gender != '' && $cnic != '' && $address != '' && $status != '') {
								$update = mysqli_query($conn, "UPDATE users SET user_login='$username', user_email='$email', user_phone='$phone', active_status='$status' WHERE id='$id'");
								$update_name = mysqli_query($conn, "UPDATE user_meta SET meta_value='$name' WHERE user_id='$id' && meta_key='user_name'");
								$update_father_name = mysqli_query($conn, "UPDATE user_meta SET meta_value='$father_name' WHERE user_id='$id' && meta_key='user_father_name'");
								$update_gender = mysqli_query($conn, "UPDATE user_meta SET meta_value='$gender' WHERE user_id='$id' && meta_key='user_gender'");
								$update_cnic = mysqli_query($conn, "UPDATE user_meta SET meta_value='$cnic' WHERE user_id='$id' && meta_key='user_cnic'");
								$update_address = mysqli_query($conn, "UPDATE user_meta SET meta_value='$address' WHERE user_id='$id' && meta_key='user_address'");
								$update_serial_prefix = mysqli_query($conn, "UPDATE user_meta SET meta_value='$serial_prefix' WHERE user_id='$id' && meta_key='user_serial_prefix'");
								$update_media = mysqli_query($conn, "UPDATE media SET media_path='$link' WHERE user_id='$id' && media_for='2'");
								if($update && $update_name && $update_father_name && $update_gender && $update_cnic && $update_address && $update_serial_prefix) {
									echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='close'>&times;</a>Agent is Successfully Updated</div>";
									echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=agent-edit.php?id=".$id."'>";
								} else {
									echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='close'>&times;</a>Agent is not Updated Please Try Again</div>";
								}
							}
						}

						?>
					</div>
					<form class="form" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input type="text" required value="<?php echo $result['user_login']; ?>" class="form-control" placeholder="Enter Username" id="username" name="username">
							<div id="username_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" required value="<?php echo $meta['user_name']; ?>" class="form-control" placeholder="Enter Name" id="name" name="name">
							<div id="name_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" required value="<?php echo $meta['user_father_name']; ?>" class="form-control" placeholder="Enter Father Name" id="father_name" name="father_name">
							<div id="father_name_msg"></div>
						</div>
						<div class="form-group">
							<input type="email" value="<?php echo $result['user_email']; ?>" class="form-control" placeholder="Enter Email" id="email" name="email">
							<div id="email_msg"></div>
						</div>
						<div class="form-group">
							<div class="form-check-inline">
								<input type="radio" required <?php if($meta['user_gender'] == "Male") echo "checked"; ?> value="Male" class="form-check-input" id="male" name="gender">
								<label class="form-check-label" for="male">Male</label>
							</div>
							<div class="form-check-inline">
								<input type="radio" required <?php if($meta['user_gender'] == "Female") echo "checked"; ?> class="form-check-input" value="Female" id="female" name="gender">
								<label class="form-check-label" for="female">Female</label>
							</div>
							<div id="gender_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" required value="<?php echo $meta['user_cnic']; ?>" class="form-control" placeholder="Enter CNIC" id="cnic" name="cnic">
							<div id="cnic"></div>
						</div>
						<div class="form-group">
							<input type="tel" required value="<?php echo $result['user_phone']; ?>" class="form-control" placeholder="Enter Phone" id="phone" name="phone">
							<div id="phone_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" required id="address" name="address" placeholder="Enter Address" rows="4"><?php echo $meta['user_address']; ?></textarea>
							<div id="address_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" value="<?php echo $meta['user_serial_prefix']; ?>" class="form-control" placeholder="Enter Serial Prefix" name="serial_prefix">
							<div id="serial_prefix_msg"></div>
						</div>
						<div class="form-group">
							<div class="form-check-inline">
								<input required type="radio" <?php if($result['active_status'] == 1) echo "checked"; ?> value="1" class="form-check-input" id="1" name="status">
								<label class="form-check-label" for="1">Active</label>
							</div>
							<div class="form-check-inline">
								<input required type="radio" <?php if($result['active_status'] == 0) echo "checked"; ?> class="form-check-input" value="0" id="0" name="status">
								<label class="form-check-label" for="0">Inactive</label>
							</div>
							<div id="status_msg"></div>
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