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
					<h5 class="card-title d-inline">Add News</h5>
					<a href='news.php' class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<div id="msg" class="mb-3">
						<?php

						if(isset($_POST['news_add_btn'])) {
							$scheme_id = mysqli_real_escape_string($conn, $_POST['scheme_id']);
							$news_title = mysqli_real_escape_string($conn, $_POST['news_title']);
							$news_text = mysqli_real_escape_string($conn, $_POST['news_text']);
							if($_FILES['news_image'] != '') {
								$media_name = $_FILES['news_image']['name'];
								$media_type = $_FILES['news_image']['type'];
								$media_size = $_FILES['news_image']['size'];
								$path = "images/".time().str_replace(" ", "-", $_FILES['news_image']['name']);
								$link = $url.$path;
								move_uploaded_file($_FILES['news_image']['tmp_name'], $path);
							} else {
								$link = $mainURL.'images/no_image.jpg';
							}
							$time_created = time();
							if($news_title != '' && $news_text != '') {
								$query = mysqli_query($conn, "INSERT INTO news(scheme_id, title, news_text, type, time_created) VALUES('$scheme_id', '$news_title', '$news_text', '1', '$time_created')");
								$image = mysqli_query($conn, "INSERT INTO media(scheme_id, media_name, media_path, media_type, media_size, media_for, time_created) VALUES('$scheme_id', '$media_name', '$link', '$media_type', '$media_size', '3', '$time_created')");
								if($query && $image) {
									echo "<div class='alert alert-success'><a href='#' data-dismiss='alert' class='close'>&times;</a>News is Successfully Added</div>";
								} else {
									echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>News is Not Added Please Try Again</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>All Fields Are Required</div>";
							}
						}

						?>
					</div>
					<form class="form" method="post" enctype="multipart/form-data">
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
							<input type="text" class="form-control" placeholder="Enter News Title" name="news_title" id="news_title">
							<div id="news_title_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" placeholder="Enter News Text" name="news_text" id="news_text" rows="6"></textarea>
							<div id="news_text"></div>
						</div>
						<div class="form-group">
							<label>News Image:</label>
							<input type="file" class="d-block" name="news_image">
						</div>
						<button class="btn btn-dark" name="news_add_btn" id="news_add_btn">Submit</button>
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