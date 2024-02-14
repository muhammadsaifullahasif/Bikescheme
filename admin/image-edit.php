<?php

include "function.php";

if(isset($_GET['id'])) {
	$id = mysqli_real_escape_string($conn, $_GET['id']);
} else {
	header('location:images.php');
}

$q = "SELECT i.id, i.title, m.scheme_id, i.active_status, m.media_url, m.media_type, m.media_size, m.media_name, m.media_path, m.media_alt FROM images i INNER JOIN media m ON i.id=m.for_id WHERE i.id='$id' && m.media_for='4'";
$conn->set_charset('utf8');
$image = mysqli_query($conn, $q);
if(mysqli_num_rows($image) > 0) {
	$image_result = mysqli_fetch_assoc($image);
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
					<h5 class="card-title d-inline">Edit Images</h5>
					<a href='images.php' class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<div class="mb-2">
						<?php

						if(isset($_POST['submit'])) {
							$scheme_id = mysqli_real_escape_string($conn, $_POST['scheme_id']);
							$image_name = mysqli_real_escape_string($conn, $_POST['image_name']);
							$image_alt = mysqli_real_escape_string($conn, $_POST['image_alt']);
							$image_link = mysqli_real_escape_string($conn, $_POST['image_link']);
							$status = mysqli_real_escape_string($conn, $_POST['status']);
							if($_FILES['image_file']['name'] != '') {
								$media_name = $_FILES['image_file']['name'];
								$media_type = $_FILES['image_file']['type'];
								$media_size = $_FILES['image_file']['size'];
								$path = "images/".time().str_replace(" ", "-", $_FILES['image_file']['name']);
								$link = $url.$path;
								move_uploaded_file($_FILES['image_file']['tmp_name'], $path);
							} else {
								$media_name = $image_result['media_name'];
								$media_type = $image_result['media_type'];
								$media_size = $image_result['media_size'];
								$link = $image_result['media_path'];
							}
							$query = mysqli_query($conn, "UPDATE images SET scheme_id='$scheme_id', title='$image_name', active_status='$status' WHERE id='$id'") or die(mysqli_error($conn));
							$media_query = mysqli_query($conn, "UPDATE media SET media_name='$media_name', media_path='$link', media_url='$image_link', media_alt='$image_alt', media_type='$media_type', media_size='$media_size' WHERE for_id='$id' && media_type='4'") or die(mysqli_error($conn));
							if($query && $media_query) {
								echo "<div class='alert alert-success'><a class='close' href='#' data-dismiss='alert'>&times;</a>Image is Successfully Updated</div>";
								echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=image-edit.php?id=".$id."'>";
							} else {
								echo "<div class='alert alert-danger'><a class='close' href='#' data-dismiss='alert'>&times;</a>Image is not Updated Please Try Again</div>";
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
							<input type="text" value="<?php echo $image_result['title']; ?>" class="form-control" placeholder="Enter Image Name" name="image_name">
						</div>
						<div class="form-group">
							<input type="text" value="<?php echo $image_result['media_alt']; ?>" class="form-control" placeholder="Enter Image Alt Text" name="image_alt">
						</div>
						<div class="form-group">
							<input type="url" value="<?php echo $image_result['media_url']; ?>" class="form-control" placeholder="Enter Image Link" name="image_link">
						</div>
						<div class="form-group">
							<div class="form-check-inline">
								<input type="radio" <?php if($image_result['active_status'] == 1) echo "checked"; ?> class="form-check-input" value="1" id="Active" name="status"><label for="Active" class="form-check-label">Active</label>
								<input type="radio" <?php if($image_result['active_status'] == 0) echo "checked"; ?> class="form-check-input" value="0" id="Inactive" name="status"><label for="Inactive" class="form-check-label">Inactive</label>
							</div>
						</div>
						<div class="form-group">
							<label>Upload Image:</label>
							<input type="file" class="d-block" name="image_file">
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