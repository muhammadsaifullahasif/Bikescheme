<?php

include "function.php";
if(isset($_GET['id'])) {
	$id = mysqli_real_escape_string($conn, $_GET['id']);
} else {
	header('location:news.php');
}

$query = mysqli_query($conn, "SELECT * FROM news WHERE id='$id'");
if(mysqli_num_rows($query) > 0) {
	$result = mysqli_fetch_assoc($query);
	$scheme_id = $result['scheme_id'];
	$media_query = mysqli_query($conn, "SELECT * FROM media WHERE scheme_id='$scheme_id' && for_id='$id'");
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
					<h5 class="card-title d-inline">Edit News</h5>
					<a href="news.php" class="btn btn-dark float-right">Back</a>
				</div>
				<div class="card-body">
					<div class="mb-2">
						<?php

						if(isset($_POST['news_add_btn'])) {
							$news_scheme_id = mysqli_real_escape_string($conn, $_POST['scheme_id']);
							$news_title = mysqli_real_escape_string($conn, $_POST['news_title']);
							$news_text = mysqli_real_escape_string($conn, $_POST['news_text']);
							$status = mysqli_real_escape_string($conn, $_POST['status']);
							if($_FILES['news_image']['name'] != '') {
								$media_name = $_FILES['news_image']['name'];
								$media_type = $_FILES['news_image']['type'];
								$media_size = $_FILES['news_image']['size'];
								$path = "images/".time().str_replace(" ", "-", $_FILES['news_image']['name']);
								$link = $url.$path;
								move_uploaded_file($_FILES['news_image']['tmp_name'], $path);
							} else {
								$media_name = $media['media_name'];
								$media_type = $media['media_type'];
								$media_size = $media['media_size'];
								$link = $media['media_path'];
							}
							if($news_scheme_id != '' && $news_title != '' && $news_text != '') {
								$query = mysqli_query($conn, "UPDATE news SET title='$news_title', news_text='$news_text', active_status='$status' WHERE id='$id'");
								$media_update = mysqli_query($conn, "UPDATE media SET media_path='$link', media_name='$media_name', media_type='$media_type', media_size='$media_size' WHERE for_id='$id' && media_for='3'");
								if($query && $media_update) {
									echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='close'>&times;</a>News is Successfully Updated</div>";
									echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=news-edit.php?id=".$id."'>";
								} else {
									echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='close'>&times;</a>News is not Updated Please Try Again</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='close'>&times;</a>All Fields Are Required</div>";
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
						?>
						<option <?php if($result['scheme_id'] == $scheme_result['id']) echo "selected"; ?> value='<?php echo $scheme_result['id'] ?>'><?php echo $scheme_result['title']; ?></option>";
						<?php
								}
								echo '</select><div id="scheme_id_msg"></div></div>';
							} else {
								$scheme_result = mysqli_fetch_assoc($scheme_query);
								echo "<input type='hidden' value='".$scheme_result['id']."' name='scheme_id'>";
							}
						}

						?>
						<div class="form-group">
							<input type="text" value="<?php echo $result['title']; ?>" class="form-control" placeholder="Enter News Title" name="news_title" id="news_title">
							<div id="news_title_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" placeholder="Enter News Text" name="news_text" id="news_text" rows="6"><?php echo $result['news_text']; ?></textarea>
							<div id="news_text"></div>
						</div>
						<div class="form-group">
							<div class="form-check-inline">
								<input type="radio" <?php if($result['active_status'] == 1) echo "checked"; ?> class="form-check-input" value="1" id="1" name="status">
								<label class="form-check-label" for="1">Active</label>
							</div>
							<div class="form-check-inline">
								<input type="radio" <?php if($result['active_status'] == 0) echo "checked"; ?> class="form-check-input" value="0" id="0" name="status">
								<label class="form-check-label" for="0">Inactive</label>
							</div>
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