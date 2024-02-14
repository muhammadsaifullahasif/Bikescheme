<?php

include "function.php";

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
} else {
    header("location:announcements.php");
}

$query = "SELECT * FROM news WHERE id='$id' && type='2'";
$conn->set_charset('utf8');
$run = mysqli_query($conn, $query);
if(mysqli_num_rows($run) > 0) {
    $result = mysqli_fetch_assoc($run);
} else {
    header("location:announcements.php");
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
					<h5 class="card-title d-inline">Add Announcement</h5>
					<a href="announcements.php" class="btn btn-dark float-right">Back</a>
				</div>
				<div class="card-body">
					<div id="msg" class="mb-3">
						<?php

						if(isset($_POST['announcement_add_btn'])) {
							$scheme_id = mysqli_real_escape_string($conn, $_POST['scheme_id']);
							$announcement_title = mysqli_real_escape_string($conn, $_POST['announcement_title']);
							$announcement_text = mysqli_real_escape_string($conn, $_POST['announcement_text']);
							$status = mysqli_real_escape_string($conn, $_POST['status']);
							$time_created = time();
							if($announcement_text != '' && $announcement_title != '') {
								$update = mysqli_query($conn, "UPDATE news SET scheme_id='$scheme_id', title='$announcement_title', news_text='$announcement_text', active_status='$status' WHERE id='$id' && type='2'");
								if($update) {
									echo "<div class='alert alert-success'><a href='#' data-dismiss='alert' class='close'>&times;</a>Announcement is Successfully Updated</div>";
									echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=announcement-edit.php?id=".$id."'>";
								} else {
									echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>Announcement is Not Updated Please Try Again</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>All Fields Are Required</div>";
							}
						}

						?>
					</div>
					<form class="form" method="post">
						<?php

						$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE active_status='1' && delete_status='0'");
						if(mysqli_num_rows($scheme_query) > 0) {
							if(mysqli_num_rows($scheme_query) > 1) {
								echo '<div class="form-group"><label>Select Scheme:</label><select class="custom-select" name="scheme_id" id="scheme_id"><option value="">Select Scheme</option>';
								while($scheme_result = mysqli_fetch_assoc($scheme_query)) {
							        ?>
							        <option <?php if($result['scheme_id'] == $scheme_result['id']) echo "selected"; ?> value="<?php echo $scheme_result['id']; ?>"><?php echo $scheme_result['title']; ?></option>
							        <?php
									echo "<option value='".$scheme_result['id']."'>".$scheme_result['title']."</option>";
								}
								echo '</select><div id="scheme_id_msg"></div></div>';
							} else {
								$scheme_result = mysqli_fetch_assoc($scheme_query);
								echo "<input type='hidden' value='".$result['scheme_id']."' name='scheme_id'>";
							}
						}

						?>
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $result['title']; ?>" placeholder="Enter Announcement Title" name="announcement_title" id="announcement_title">
							<div id="announcement_title_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" id="announcement_text" name="announcement_text" placeholder="Enter Announcement Text" rows="6"><?php echo $result['news_text']; ?></textarea>
							<div id="announcement_text_msg"></div>
						</div>
						<div class="form-group">
							<div class="form-check-inline">
								<input type="radio" <?php if($result['active_status'] == 1) echo "checked"; ?> value="1" class="form-check-input" id="1" name="status">
								<label class="form-check-label" for="1">Active</label>
							</div>
							<div class="form-check-inline">
								<input type="radio" <?php if($result['active_status'] == 0) echo "checked"; ?> class="form-check-input" value="0" id="0" name="status">
								<label class="form-check-label" for="0">Inactive</label>
							</div>
							<div id="status_msg"></div>
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