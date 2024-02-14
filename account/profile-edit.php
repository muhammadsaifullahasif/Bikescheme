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
			<div class="card mt-2 mb-3">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title">Edit Profile</h5>
				</div>
				<div class="card-body">
					<div class="mb-2">
						<?php

						if(isset($_POST['submit'])) {
							$name = mysqli_real_escape_string($conn, $_POST['name']);
							$father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
							$email = mysqli_real_escape_string($conn, $_POST['email']);
							$security_question = mysqli_real_escape_string($conn, $_POST['security_question']);
							$security_answer = mysqli_real_escape_string($conn, $_POST['security_answer']);
							$gender = mysqli_real_escape_string($conn, $_POST['gender']);
							$cnic = mysqli_real_escape_string($conn, $_POST['cnic']);
							$phone = mysqli_real_escape_string($conn, $_POST['phone']);
							$address = mysqli_real_escape_string($conn, $_POST['address']);
							if($_FILES['profile_image']['name'] != '') {
								$media_name = $_FILES['profile_image']['name'];
								$media_type = $_FILES['profile_image']['type'];
								$media_size = $_FILES['profile_image']['size'];
								$path = "images/".time().str_replace(" ", "-", $_FILES['profile_image']['name']);
								$link = $url.$path;
								move_uploaded_file($_FILES['profile_image']['tmp_name'], $path);
							} else {
								$media_name = $media['media_name'];
								$media_type = $media['media_type'];
								$media_size = $media['media_size'];
								$link = $media['media_path'];
							}
							if($name != '' && $father_name != '' && $security_question != '' && $security_answer != '' && $gender != '' && $cnic != '' && $phone != '' && $address != '') {
								$update = mysqli_query($conn, "UPDATE users SET user_email='$email', user_phone='$phone', WHERE user_login='$user_login'");
								$update_name = mysqli_query($conn, "UPDATE user_meta SET meta_value='$name' WHERE user_id='$user_id' && meta_key='user_name'");
								$update_father_name = mysqli_query($conn, "UPDATE user_meta SET meta_value='$father_name' WHERE user_id='$user_id' && meta_key='user_father_name'");
								$update_gender = mysqli_query($conn, "UPDATE user_meta SET meta_value='$gender' WHERE user_id='$user_id' && meta_key='user_gender'");
								$update_cnic = mysqli_query($conn, "UPDATE user_meta SET meta_value='$cnic' WHERE user_id='$user_id' && meta_key='user_cnic'");
								$update_address = mysqli_query($conn, "UPDATE user_meta SET meta_value='$address' WHERE user_id='$user_id' && meta_key='user_address'");
								$update_security_question = mysqli_query($conn, "UPDATE user_meta SET meta_value='$security_question' WHERE user_id='$user_id' && meta_key='user_security_question'");
								$update_security_answer = mysqli_query($conn, "UPDATE user_meta SET meta_value='$security_answer' WHERE user_id='$user_id' && meta_key='user_security_answer'");
								$update_media = mysqli_query($conn, "UPDATE media SET media_name='$media_name', media_type='$media_type', media_size='$media_size', media_path='$link' WHERE user_id='$user_id' && media_for='2'");
								if($update && $update_name && $update_father_name && $update_gender && $update_cnic && $update_address && $update_security_answer && $update_security_question) {
									echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert'>&times;</a>Profile is Successfully Updated</div>";
									echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=profile-edit.php'>";
								} else {
									echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a>Profile is not Updated Please Try Again</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a>All Fields Are Required Except Email</div>";
							}
						}

						?>
					</div>
					<form class="form" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<!--<label>Name:</label>-->
							<input type="text" required value="<?php echo $meta['user_name']; ?>" class="form-control" placeholder="Enter Name" id="name" name="name">
							<div id="name_msg"></div>
						</div>
						<div class="form-group">
							<!--<label>Father Name:</label>-->
							<input type="text" required value="<?php echo $meta['user_father_name']; ?>" class="form-control" placeholder="Enter Father Name" id="father_name" name="father_name">
							<div id="father_name"></div>
						</div>
						<div class="form-group">
							<!--<label>Email:</label>-->
							<input type="email" required value="<?php echo $result['user_email']; ?>" class="form-control" placeholder="Enter Email" id="email" name="email">
							<div id="email_msg"></div>
						</div>
						<div class="form-group">
							<!--<label>Security Question:</label>-->
							<select class="custom-select" name="security_question" id="security_question" required>
								<option>Select Question</option>
								<option <?php if($meta['user_security_question'] == "In Which City You Born?") echo "selected"; ?> value="In Which City You Born?">In Which City You Born?</option>
							</select>
							<div id="security_question_msg"></div>
						</div>
						<div class="form-group">
							<!--<label>Security Answer:</label>-->
							<input type="text" required value="<?php echo $meta['user_security_answer']; ?>" class="form-control" placeholder="Enter Security Answer" id="security_answer" name="security_answer">
							<div id="security_answer"></div>
						</div>
						<div class="form-group">
							<!--<label class="d-block">Gender:</label>-->
							<div class="form-check-inline">
								<input type="radio" required <?php if($meta['user_gender'] == "Male") echo "checked"; ?> class="form-check-input" id="Male" value="Male" name="gender"><label for="Male" class="form-check-label">Male</label>
							</div>
							<div class="form-check-inline">
								<input type="radio" required <?php if($meta['user_gender'] == "Female") echo "checked"; ?> class="form-check-input" id="Female" value="Female" name="gender"><label for="Female" class="form-check-label">Female</label>
							</div>
						</div>
						<div class="form-group">
							<!--<label>CNIC:</label>-->
							<input type="text" required value="<?php echo $meta['user_cnic']; ?>" class="form-control" placeholder="Enter CNIC" id="cnic" name="cnic">
							<div id="cnic_msg"></div>
						</div>
						<div class="form-group">
							<!--<label>Phone:</label>-->
							<input type="tel" required value="<?php echo $result['user_phone']; ?>" class="form-control" placeholder="Enter Phone" id="phone" name="phone">
							<div id="phone_msg"></div>
						</div>
						<div class="form-group">
							<!--<label>Address:</label>-->
							<textarea class="form-control" required placeholder="Enter Address" id="address" rows="4" name="address"><?php echo $meta['user_address']; ?></textarea>
							<div id="address_msg"></div>
						</div>
						<div class="form-group">
							<label>Profile Image:</label>
							<input type="file" class="d-block" name="profile_image">
						</div>
						<button type="submit" class="btn btn-dark" name="submit" id="save_changes">Save Changes</button>
					</form>
				</div>
			</div>
		</div>
	</section>
	<?php include "../footer.php"; ?>
	<?php include "js.php"; ?>
</body>
</html>