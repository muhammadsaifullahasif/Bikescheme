<?php

include "include/include.inc.php";
$url = 'http://localhost:8080/bikescheme/';

function member_ship_no($conn, $agent_id, $scheme_id) {
	$query = mysqli_query($conn, "SELECT a.id, m.meta_value FROM users a INNER JOIN user_meta m ON a.id=m.user_id WHERE a.role='1' && a.id='$agent_id' && m.meta_key='user_serial_prefix'");
	if(mysqli_num_rows($query) > 0) {
		$result = mysqli_fetch_assoc($query);
		$prefix = $result['meta_value'];
	} else {
		$scheme = mysqli_fetch_assoc(mysqli_query($conn, "SELECT s.id m.meta_value FROM scheme s INNER JOIN scheme_meta m ON s.id=m.scheme_id WHERE s.id='$scheme_id' && m.meta_key='scheme_prefix'"));
		$prefix = $result['meta_value'];
	}
	$user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$agent_id'"));
	$i = ($user + 1);
	$total_ = 3;
	$strlen = 0;
	$strlen = strlen($i);
	$limt = 0;
	$limt = ($total_ - $strlen);
	$newid = ''; 
	for($k=0;$k<$limt;$k++)
		$newid = ($newid."0");
	$shipno = $prefix.'-'.$newid.$i;
	return $shipno;
}

if(isset($_GET['agent_id'])) {
	$agent_id = $_GET['agent_id'];
	$agent_query = mysqli_query($conn, "SELECT * FROM users WHERE role='1' && active_status='1' && delete_status='0' && id='$agent_id'");
	if(mysqli_num_rows($agent_query) != 1) {
	    header('location:select-agent.php');
	    die();
	}
} else {
	$agent_query = mysqli_query($conn, "SELECT * FROM users WHERE role='1' && active_status='1' && delete_status='0'");
	if(mysqli_num_rows($agent_query) > 0) {
		if(mysqli_num_rows($agent_query) == 1) {
			$agent_result = mysqli_fetch_assoc($agent_query);
			$agent_id = $agent_result['id'];
		} else {
			header('location:select-agent.php');
			die();
		}
	} else {
		header('location:select-agent.php');
		die();
	}
}
$agent_media = mysqli_fetch_assoc(mysqli_query($conn, "SELECT media_path, media_alt FROM media WHERE user_id='$agent_id' && media_for='2'"));

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
	<!-- Announcement Start -->
	<?php include "announcement.php"; ?>
	<!-- Announcement End -->
	<!-- Main Start -->
	<section>
		<div class="container-fluid">
			<div class="row mt-3">
				<!-- Left Side Start -->
				<div class="col-lg-8">
					<div class="card mb-2">
						<div class="card-header bg-dark text-white">
							<h5 class="card-title">Become A Member</h5>
						</div>
						<div class="card-body">
							<div id="msg" class="mb-3">
								<?php

								if(isset($_POST['register_add_btn'])) {
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
									if($_FILES['profile_image'] != '') {
										$media_name = $_FILES['profile_image']['name'];
										$media_type = $_FILES['profile_image']['type'];
										$media_size = $_FILES['profile_image']['size'];
										$path = "images/".time().str_replace(" ", "-", $_FILES['profile_image']['name']);
										$link = $url.$path;
										move_uploaded_file($_FILES['profile_image']['tmp_name'], $path);
									} else {
									    $media_name = 'No Image Available';
									    $media_type = 'Image';
									    $media_size = 0;
										$link = $url.'images/no_image.jpg';
									}
									$ship_no = member_ship_no($conn, $agent_id, $scheme_id);
									$id_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users ORDER BY time_created DESC LIMIT 1"));
									if(isset($id_query['id']) == 0) {
										$id = 1;
									} else {
										$id = $id_query['id'];
										$id++;
									}
									$time_created = time();
									if($agent_id != '' && $scheme_id != '' && $username != '' && $name != '' && $father_name != '' && $password != '' && $security_question != '' && $security_answer != '' && $gender != '' && $cnic != '' && $phone != '' && $address != '') {
										$query = mysqli_query($conn, "INSERT INTO users(id, user_login, user_pass, user_email, user_phone, agent_id, introducer, scheme_id, enroll_status, time_created) VALUES('$id', '$username', '$user_pass', '$email', '$phone', '$agent_id', '$introducer', '$scheme_id', '1', '$time_created')");
										$meta = mysqli_query($conn, "INSERT INTO user_meta(user_id, meta_name, meta_key, meta_value) VALUES('$id', 'Name', 'user_name', '$name'), ('$id', 'Father Name', 'user_father_name', '$father_name'), ('$id', 'Gender', 'user_gender', '$gender'), ('$id', 'CNIC', 'user_cnic', '$cnic'), ('$id', 'Address', 'user_address', '$address'), ('$id', 'Security Question', 'user_security_question', '$security_question'), ('$id', 'Security Answer', 'user_security_answer', '$security_answer'), ('$id', 'Membership Number', 'user_shipno', '$ship_no')");
										$image = mysqli_query($conn, "INSERT INTO media(user_id, scheme_id, media_name, media_path, media_type, media_size, media_for, time_created) VALUES('$id', '$scheme_id', '$media_name', '$link', '$media_type', '$media_size', '2', '$time_created')");
										if($query && $meta && $image) {
											echo "<div class='alert alert-success'><a href='#' data-dismiss='alert' class='close'>&times;</a>Welcome <strong style='color: #00f;'>".$name."</strong> Your Account is Successfully Created and your Membership Number is <b class='text-danger' style='font-size: 25px;'>".$ship_no."</b><br>Your Username is <b style='color: #00f;'>".$username."</b><br>Your Password is <b style='color: #D2691E;'>".$password."</b><hr>Your account status is pending agent will review and approve it and contact you</div>";
										} else {
											echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>User is not Added Please Try Again</div>";
										}
									} else {
										echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>All Fields Are Required</div>";
									}
								}

								?>
							</div>
							<form class="form" method="post" enctype="multipart/form-data">
							    <div class="form-group text-center">
							        <img src="<?php echo $agent_media['media_path']; ?>" alt="<?php echo $agent_media['media_alt']; ?>" width="120" height="120">
							    </div>
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
								} else {
								    echo "<div class='alert alert-danger'>No Scheme Found</div>";
								    die();
								}

								?>
								<div class="form-group">
									<!--<label>Username:</label>-->
									<input type="text" class="form-control" required placeholder="Enter Username" name="username">
									<div id="username_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Name:</label>-->
									<input type="text" class="form-control" required placeholder="Enter Name" name="name">
									<div id="name_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Father Name:</label>-->
									<input type="text" class="form-control" required placeholder="Enter Father Name" name="father_name">
									<div id="father_name_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Email:</label>-->
									<input type="email" class="form-control" placeholder="Enter Email" name="email">
									<div id="email_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Password:</label>-->
									<input type="password" class="form-control" required placeholder="Enter Password" name="password">
									<div id="password"></div>
								</div>
								<div class="form-group">
									<!--<label>Security Question:</label>-->
									<select class="custom-select" name="security_question" required>
										<option value="">Select Question</option>
										<option value="In Which City You Born?" selected>In Which City You Born?</option>
									</select>
									<div id="security_question_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Security Answer:</label>-->
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
									<!--<label>CNIC:</label>-->
									<input type="text" class="form-control" required placeholder="Enter CNIC" name="cnic">
									<div id="cnic_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Phone:</label>-->
									<input type="tel" class="form-control" required placeholder="Enter Phone" name="phone">
									<div id="phone_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Address:</label>-->
									<textarea class="form-control" required placeholder="Enter Address" name="address" rows="4"></textarea>
									<div id="address_msg"></div>
								</div>
								<div class="form-group">
									<!--<label>Reffer:</label>-->
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