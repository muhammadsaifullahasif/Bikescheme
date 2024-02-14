<?php

include "function.php";

if(isset($_GET['scheme_id'])) {
	$id = mysqli_real_escape_string($conn, $_GET['scheme_id']);
	$query = mysqli_query($conn, "SELECT * FROM scheme WHERE id='$id'");
	if(mysqli_num_rows($query) > 0) {
		$result = mysqli_fetch_assoc($query);
		$meta_query = "SELECT * FROM scheme_meta WHERE scheme_id='$id'";
		$conn->set_charset('utf8');
		$meta_run = mysqli_query($conn, $meta_query);
		if(mysqli_num_rows($meta_run) > 0) {
			while($meta_result = mysqli_fetch_assoc($meta_run)) {
				$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
			}
		}
		$media_query = mysqli_query($conn, "SELECT media_path FROM media WHERE scheme_id='$id' && media_for='1'");
		if(mysqli_num_rows($media_query) > 0) {
			$media = mysqli_fetch_assoc($media_query);
		}
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
					<h5 class="card-title d-inline">Edit Scheme</h5>
					<a href="schemes.php" class="btn btn-dark float-right">Back</a>
				</div>
				<div class="card-body">
					<div class="mb-2">
						<?php

						if(isset($_POST['submit'])) {
							$draw_place = mysqli_real_escape_string($conn, $_POST['draw_place']);
							$scheme_title = mysqli_real_escape_string($conn, $_POST['scheme_title']);
							$draws = mysqli_real_escape_string($conn, $_POST['draws']);
							$installment = mysqli_real_escape_string($conn, $_POST['installment']);
							$return_installment = mysqli_real_escape_string($conn, $_POST['return_installment']);
							$return_deduction = mysqli_real_escape_string($conn, $_POST['return_deduction']);
							$date_time = mysqli_real_escape_string($conn, $_POST['date_time']);
							$short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
							$long_description = mysqli_real_escape_string($conn, $_POST['long_description']);
							$terms_conditons = mysqli_real_escape_string($conn, $_POST['terms_conditons']);
							$status = mysqli_real_escape_string($conn, $_POST['status']);
							$scheme_prefix = mysqli_real_escape_string($conn, $_POST['scheme_prefix']);
							$scheme_group = mysqli_real_escape_string($conn, $_POST['scheme_group']);
							if($_FILES['scheme_image']['name'] != '') {
								$media_name = $_FILES['scheme_image']['name'];
								$media_type = $_FILES['scheme_image']['type'];
								$media_size = $_FILES['scheme_image']['size'];
								$path = "images/".time().str_replace(" ", "-", $_FILES['scheme_image']['name']);
								$link = $url.$path;
								move_uploaded_file($_FILES['scheme_image']['tmp_name'], $path);
							} else {
							    $media_name = $media['media_name'];
								$media_type = $media['media_type'];
								$media_size = $media['media_size'];
								$link = $media['media_path'];
							}
							if($draw_place != '' && $scheme_title != '' && $draws != '' && $installment != '' && $date_time != '' && $terms_conditons != '') {
								$update = mysqli_query($conn, "UPDATE scheme SET title='$scheme_title', short_description='$short_description', long_description='$long_description', active_status='$status' WHERE id='$id'");
								$update_draw_place = mysqli_query($conn, "UPDATE scheme_meta SET meta_value='$draw_place' WHERE scheme_id='$id' && meta_key='draw_place'");
								$update_no_of_draws = mysqli_query($conn, "UPDATE scheme_meta SET meta_value='$draws' WHERE scheme_id='$id' && meta_key='no_of_draws'");
								$update_installment = mysqli_query($conn, "UPDATE scheme_meta SET meta_value='$installment' WHERE scheme_id='$id' && meta_key='installment_per_month'");
								$update_return_installment = mysqli_query($conn, "UPDATE scheme_meta SET meta_value='$return_installment' WHERE scheme_id='$id' && meta_key='return_installment'");
								$update_return_deduction = mysqli_query($conn, "UPDATE scheme_meta SET meta_value='$return_deduction' WHERE scheme_id='$id' && meta_key='return_deduction'");
								$update_date_time = mysqli_query($conn, "UPDATE scheme_meta SET meta_value='$date_time' WHERE scheme_id='$id' && meta_key='draw_date_time'");
								$update_terms_conditions = mysqli_query($conn, "UPDATE scheme_meta SET meta_value='$terms_conditons' WHERE scheme_id='$id' && meta_key='scheme_terms_conditions'") or die(mysqli_error($conn));
								$update_scheme_prefix = mysqli_query($conn, "UPDATE scheme_meta SET meta_value='$scheme_prefix' WHERE scheme_id='$id' && meta_key='scheme_prefix'");
								$update_scheme_group = mysqli_query($conn, "UPDATE scheme_meta SET meta_value='$scheme_group' WHERE scheme_id='$id' && meta_key='scheme_group'");
								$update_media = mysqli_query($conn, "UPDATE media SET media_path='$link' WHERE scheme_id='$id' && media_for='1'");
								if($update && $update_draw_place && $update_no_of_draws && $update_installment && $update_return_installment && $update_return_deduction && $update_date_time && $update_terms_conditions && $update_scheme_prefix && $update_scheme_group && $update_media) {
									echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='close'>&times;</a>Scheme is Successfully Updated</div>";
									echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=scheme-edit.php?scheme_id=".$id."'>";
								} else {
									echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='close'>&times;</a>Scheme is not Updated Please Try Again</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='close'>&times;</a>All Fields Are Required</div>";
							}
						}

						?>
					</div>
					<form class="form" id="scheme_form" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label>Draw Place:</label>
							<input type="text" required value="<?php echo $meta['draw_place']; ?>" id="draw_place" class="form-control" placeholder="Enter Draw Place" name="draw_place">
							<div id="draw_place_msg"></div>
						</div>
						<div class="form-group">
							<label>Scheme Title:</label>
							<input type="text" required value="<?php echo $result['title']; ?>" id="scheme_title" class="form-control" placeholder="Enter Scheme Title" name="scheme_title">
							<div id="scheme_title_msg"></div>
						</div>
						<div class="form-group">
							<label>Draws:</label>
							<input type="number" required value="<?php echo $meta['no_of_draws']; ?>" id="draws" class="form-control" placeholder="Enter Number of Draws" name="draws">
							<div id="draws_msg"></div>
						</div>
						<div class="form-group">
							<label>Installment:</label>
							<input type="text" required value="<?php echo $meta['installment_per_month']; ?>" id="installment" class="form-control" placeholder="Enter Installment" name="installment">
							<div id="installment_msg"></div>
						</div>
						<div class="form-group">
							<label>No Return upto Installment:</label>
							<input type="number" value="<?php echo $meta['return_installment']; ?>" id="return_installment" class="form-control" placeholder="Enter No Return upto Installment" name="return_installment">
							<div id="return_installment_msg"></div>
						</div>
						<div class="form-group">
							<label>On Return Deduction:</label>
							<input type="text" value="<?php echo $meta['return_deduction']; ?>" id="return_deduction" class="form-control" placeholder="Enter On Return Deduction" name="return_deduction">
							<div id="return_deduction_msg"></div>
						</div>
						<div class="form-group">
							<label>Date and Time:</label>
							<input type="datetime-local" required value="<?php echo $meta['draw_date_time']; ?>" id="date_time" class="form-control" name="date_time">
							<div id="date_time_msg"></div>
						</div>
						<div class="form-group">
							<label>Short Description:</label>
							<textarea class="form-control" id="short_description" name="short_description" placeholder="Enter Short Description" rows="4"><?php echo $result['short_description']; ?></textarea>
							<div id="short_description_msg"></div>
						</div>
						<div class="form-group">
							<label>Long Description:</label>
							<textarea class="form-control" id="long_description" name="long_description" placeholder="Enter Long Description" rows="6"><?php echo $result['long_description']; ?></textarea>
							<div id="long_description_msg"></div>
						</div>
						<div class="form-group">
							<label>Terms & Conditions:</label>
							<textarea class="form-control" required id="terms_conditons" name="terms_conditons" placeholder="Enter Terms & Conditions"><?php echo $meta['scheme_terms_conditions']; ?></textarea>
							<div id="terms_conditons_msg"></div>
						</div>
						<div class="form-group">
						    <label>Scheme Prefix:</label>
						    <input type="text" required class="form-control" id="scheme_prefix" name="scheme_prefix" placeholder="Enter Scheme Prefix" value="<?php echo $meta['scheme_prefix']; ?>">
						    <div id="scheme_prefix_msg"></div>
						</div>
						<div class="form-group">
						    <label>Scheme Group:</label>
						    <input type="number" required class="form-control" id="scheme_group" name="scheme_group" placeholder="Enter Scheme Group" value="<?php echo $meta['scheme_group']; ?>">
						    <div id="scheme_group_msg"></div>
						</div>
						<div class="form-group">
							<label class="d-block">Status:</label>
							<div class="form-check-inline">
								<input type="radio" required <?php if($result['active_status'] == 1) echo "checked"; ?> class="form-check-input" value="1" id="1" name="status">
								<label for="1" class="form-check-label">Active</label>
							</div>
							<div class="form-check-inline">
								<input type="radio" required <?php if($result['active_status'] == 0) echo "checked"; ?> class="form-check-input" value="0" id="0" name="status">
								<label for="0" class="form-check-label">Inactive</label>
							</div>
						</div>
						<div class="form-group">
							<label>Scheme Image:</label>
							<input type="file" class="d-block" name="scheme_image">
						</div>
						<button class="btn btn-dark" type="submit" id="scheme_add_btn" name="submit">Submit</button>
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