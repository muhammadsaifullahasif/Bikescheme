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
					<h5 class="card-title d-inline">Add Announcement</h5>
					<a href='announcements.php' class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<div id="msg" class="mb-3">
						<?php

						if(isset($_POST['announcement_add_btn'])) {
							$scheme_id = mysqli_real_escape_string($conn, $_POST['scheme_id']);
							$announcement_title = $_POST['announcement_title'];
							$announcement_text = $_POST['announcement_text'];
							$time_created = time();
							if($announcement_text != '' && $announcement_title != '') {
							    $conn->set_charset('utf8');
								$query = mysqli_query($conn, "INSERT INTO news(scheme_id, title, news_text, type, time_created) VALUES('$scheme_id', '$announcement_title', '$announcement_text', '2', '$time_created')");
								if($query) {
									echo "<div class='alert alert-success'><a href='#' data-dismiss='alert' class='close'>&times;</a>Announcement is Successfully Added</div>";
								} else {
									echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>Announcement is Not Added Please Try Again</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>All Fields Are Required</div>";
							}
						}

						?>
					</div>
					<form class="form" method="POST">
						<?php

						$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE active_status='1' && delete_status='0'");
						if(mysqli_num_rows($scheme_query) > 0) {
							if(mysqli_num_rows($scheme_query) > 1) {
								echo '<div class="form-group"><label>Select Scheme:</label><select class="custom-select" name="scheme_id" id="scheme_id"><option value="">Select Scheme</option>';
								while($scheme_result = mysqli_fetch_assoc($scheme_query)) {
									echo "<option value='".$scheme_result['id']."'>".$scheme_result['title']."</option>";
								}
								echo '</select><div id="scheme_id_msg"></div></div>';
							} else {
								$scheme_result = mysqli_fetch_assoc($scheme_query);
								echo "<input type='hidden' value='".$scheme_result['id']."' name='scheme_id'>";
							}
						}

						?>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter Announcement Title" name="announcement_title" id="announcement_title">
							<div id="announcement_title_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" id="announcement_text" name="announcement_text" placeholder="Enter Announcement Text" rows="6"></textarea>
							<div id="announcement_text_msg"></div>
						</div>
						<button class="btn btn-dark" name="announcement_add_btn" id="announcement_add_btn">Submit</button>
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