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
					<h5 class="card-title d-inline">Add New User</h5>
					<a href='users.php' class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<div id="msg" class="mb-3">
						<?php

						if(isset($_POST['register_add_btn'])) {
							$agent_id = mysqli_real_escape_string($conn, $_POST['agent_id']);
							$scheme_id = mysqli_real_escape_string($conn, $_POST['scheme_id']);
							$username = mysqli_real_escape_string($conn, $_POST['username']);
							$name = mysqli_real_escape_string($conn, $_POST['name']);
							$father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
							$email = mysqli_real_escape_string($conn, $_POST['email']);
							$password = mysqli_real_escape_string($conn, $_POST['password']);
							$user_pass = password_hash($password, PASSWORD_DEFAULT);
							$security_question = mysqli_real_escape_string($conn, $_POST['security_question']);
							$security_answer = mysqli_real_escape_string($conn, $_POST['security_answer']);
							$gender = mysqli_real_escape_string($conn, $_POST['gender']);
							$cnic = mysqli_real_escape_string($conn, $_POST['cnic']);
							$phone = mysqli_real_escape_string($conn, $_POST['phone']);
							$address = mysqli_real_escape_string($conn, $_POST['address']);
							$introducer = mysqli_real_escape_string($conn, $_POST['introducer']);
							if($_FILES['profile_image']['name'] != '') {
								$media_name = $_FILES['profile_image']['name'];
								$media_type = $_FILES['profile_image']['type'];
								$media_size = $_FILES['profile_image']['size'];
								$path = "images/".time().str_replace(" ", "-", $_FILES['profile_image']['name']);
								$link = $url.$path;
								move_uploaded_file($_FILES['profile_image']['tmp_name'], $path);
							} else {
								$link = $mainURL.'images/no_image.jpg';
							}
							$ship_no = member_ship_no($conn, $agent_id);
							$id_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users ORDER BY time_created DESC LIMIT 1"));
							if(isset($id_query['id']) == 0) {
								$id = 1;
							} else {
								$id = $id_query['id'];
								$id++;
							}
							$time_created = time();
							if($agent_id != '' && $scheme_id != '' && $username != '' && $name != '' && $password != '' && $security_question != '' && $security_answer != '' && $gender != '' && $cnic != '' && $phone != '' && $address != '') {
								$query = mysqli_query($conn, "INSERT INTO users(id, user_login, user_pass, user_email, user_phone, agent_id, introducer, scheme_id, enroll_status, time_created) VALUES('$id', '$username', '$user_pass', '$email', '$phone', '$agent_id', '$introducer', '$scheme_id', '1', '$time_created')") or die("User Query Error");
								$meta = mysqli_query($conn, "INSERT INTO user_meta(user_id, meta_name, meta_key, meta_value) VALUES('$id', 'Name', 'user_name', '$name'), ('$id', 'Father Name', 'user_father_name', '$father_name'), ('$id', 'Gender', 'user_gender', '$gender'), ('$id', 'CNIC', 'user_cnic', '$cnic'), ('$id', 'Address', 'user_address', '$address'), ('$id', 'Security Question', 'user_security_question', '$security_question'), ('$id', 'Security Answer', 'user_security_answer', '$security_answer'), ('$id', 'Membership Number', 'user_shipno', '$ship_no')") or die("Meta Query Error");
								$image = mysqli_query($conn, "INSERT INTO media(user_id, scheme_id, media_name, media_path, media_type, media_size, media_for, time_created) VALUES('$id', '$scheme_id', '$media_name', '$link', '$media_type', '$media_size', '2', '$time_created')") or die("Media Query Error");
								if($query && $meta && $image) {
									echo "<div class='alert alert-success'><a href='#' data-dismiss='alert' class='close'>&times;</a>User is Successfully Added<br><hr>Membership Number is ".$ship_no."</div>";
								} else {
								    die(mysqli_error($conn));
								}
							} else {
								echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>All Fields Are Required</div>";
							}
						}

						?>
					</div>
					<form class="form" method="post" enctype="multipart/form-data">
						<?php

						$agent_query = mysqli_query($conn, "SELECT a.id, n.meta_value FROM users a INNER JOIN user_meta n ON a.id=n.user_id WHERE n.meta_key='user_name' && a.active_status='1' && a.delete_status='0' && a.role='1'") or die(mysqli_error($conn));
						if(mysqli_num_rows($agent_query) > 0) {
							if(mysqli_num_rows($agent_query) > 1) {
								echo '<div class="form-group"><label>Select Agent:</label><select class="custom-select" name="agent_id"><option value="">Select Agent</option>';
								while($agent_result = mysqli_fetch_assoc($agent_query)) {
									echo "<option value='".$agent_result['id']."'>".$agent_result['meta_value']."</option>";
								}
								echo '</select></div>';
							} else {
								$agent_result = mysqli_fetch_assoc($agent_query);
								echo "<input type='hidden' value='".$agent_result['id']."' name='agent_id'>";
							}
						} else {
						    echo "No Agent Found";
						}

						?>
						<?php

						$scheme_title_query = mysqli_query($conn, "SELECT id, title FROM scheme WHERE active_status='1' && delete_status='0'");
						if(mysqli_num_rows($scheme_title_query) > 0) {
							if(mysqli_num_rows($scheme_title_query) > 1) {
								echo '<div class="form-group"><label>Enroll For Scheme:</label><select class="custom-select" name="scheme_id"><option value="">Select Scheme</option>';
								while($scheme_title_result = mysqli_fetch_assoc($scheme_title_query)) {
									echo "<option value='".$scheme_title_result['id']."'>".$scheme_title_result['title']."</option>";
								}
								echo '</select></div>';
							} else {
								$scheme_title_result = mysqli_fetch_assoc($scheme_title_query);
								echo "<input type='hidden' value='".$scheme_title_result['id']."' name='scheme_id'>";
							}
						}

						?>
						<div class="form-group">
							<input type="text" required class="form-control" placeholder="Enter Username" name="username">
							<div id="username_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" required class="form-control" placeholder="Enter Name" name="name">
							<div id="name_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" required placeholder="Enter Father Name" name="father_name">
							<div id="father_name_msg"></div>
						</div>
						<div class="form-group">
							<input type="email" class="form-control" placeholder="Enter Email" name="email">
							<div id="email_msg"></div>
						</div>
						<div class="form-group">
							<input type="password" required class="form-control" placeholder="Enter Password" name="password">
							<div id="password"></div>
						</div>
						<div class="form-group">
							<select class="custom-select" name="security_question" required>
								<option value="">Select Question</option>
								<option selected value="In Which City You Born?">In Which City You Born?</option>
							</select>
							<div id="security_question_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" required placeholder="Enter Security Answer" name="security_answer">
							<div id="security_answer_msg"></div>
						</div>
						<div class="form-group">
							<div class="form-check-inline">
								<input type="radio" required class="form-check-input" id="male" value="Male" name="gender">
								<label for="male" class="form-check-label">Male</label>
							</div>
							<div class="form-check-inline">
								<input type="radio" required class="form-check-input" id="female" value="Female" name="gender">
								<label for="female" class="form-check-label">Female</label>
							</div>
						</div>
						<div class="form-group">
							<input type="text" required class="form-control" placeholder="Enter CNIC" name="cnic">
							<div id="cnic_msg"></div>
						</div>
						<div class="form-group">
							<input type="tel" required class="form-control" placeholder="Enter Phone" name="phone">
							<div id="phone_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" required placeholder="Enter Address" name="address" rows="4"></textarea>
							<div id="address_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Reffer by" name="introducer">
							<div id="introducer"></div>
						</div>
						<div class="form-group">
							<label>Profile Image:</label>
							<input type="file" class="d-block" name="profile_image">
						</div>
						<button class="btn btn-dark" id="register_add_btn" name="register_add_btn">Register</button>
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