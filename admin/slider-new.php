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
					<h5 class="card-title d-inline">Add Slider</h5>
					<a href='sliders.php' class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<div class="mb-2">
						<?php

						if(isset($_POST['submit'])) {
							if($_FILES['image_file']['name'] != '') {
								$scheme_id = mysqli_real_escape_string($conn, $_POST['scheme_id']);
								$image_name = mysqli_real_escape_string($conn, $_POST['image_name']);
								$image_alt = mysqli_real_escape_string($conn, $_POST['image_alt']);
								$image_link = mysqli_real_escape_string($conn, $_POST['image_link']);
								if($_FILES['image_file']['name'] != '') {
    								$media_name = $_FILES['image_file']['name'];
    								$media_type = $_FILES['image_file']['type'];
    								$media_size = $_FILES['image_file']['size'];
    								$path = "images/".time().str_replace(" ", "-", $_FILES['image_file']['name']);
    								$link = $url.$path;
								} else {
								    $media_name = 'No Image';
								    $media_type = 'Image';
								    $media_size = 0;
								    $link = $mainURL.'images/no_image.jpg';
								}
								move_uploaded_file($_FILES['image_file']['tmp_name'], $path);
								$check = mysqli_query($conn, "SELECT * FROM images ORDER BY time_created DESC LIMIT 1");
								if(mysqli_num_rows($check) > 0) {
									$check_result = mysqli_fetch_assoc($check);
									$id = $check_result['id'];
									$id++;
								} else {
									$id = 1;
								}
								$time_created = time();
								$media_query = mysqli_query($conn, "INSERT INTO media(scheme_id, media_name, media_path, media_url, media_alt, media_type, media_size, media_for, time_created) VALUES('$scheme_id', '$image_name', '$link', '$image_link', '$image_alt', '$media_type', '$media_size', '6', '$time_created')");
								if($media_query) {
									echo "<div class='alert alert-success'><a class='close' href='#' data-dismiss='alert'>&times;</a>Slider is Successfully Added</div>";
								} else {
									echo "<div class='alert alert-danger'><a class='close' href='#' data-dismiss='alert'>&times;</a>Slider is not Added Please Try Again</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a class='close' href='#' data-dismiss='alert'>&times;</a>Please Select An Slider Image</div>";
							}
						}

						?>
					</div>
					<form class="form" method="post" enctype="multipart/form-data">
						<?php

						$scheme_title_query = mysqli_query($conn, "SELECT id, title FROM scheme WHERE active_status='1' && delete_status='0'");
						if(mysqli_num_rows($scheme_title_query) > 0) {
							if(mysqli_num_rows($scheme_title_query) > 1) {
								echo '<div class="form-group"><label>Select Scheme:</label><select class="custom-select" name="scheme_id"><option value="">Select Scheme</option>';
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
							<input type="text" class="form-control" placeholder="Enter Image Name" name="image_name">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter Image Alt Text" name="image_alt">
						</div>
						<div class="form-group">
							<input type="url" class="form-control" placeholder="Enter Image Link" name="image_link">
						</div>
						<div class="form-group">
							<label>Upload Slider Image:</label>
							<input type="file" required class="d-block" name="image_file">
						</div>
						<button type="submit" name="submit" class="btn btn-dark">Submit</button>
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