<?php

include "function.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include "head.php"; ?>
	<link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.min.css">
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
					<h5 class="card-title d-inline">Add Scheme</h5>
					<a href='schemes.php' class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<div id="scheme_form_msg" class="mb-3">
						<?php

						if(isset($_POST['scheme_add_btn'])) {
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
							    $media_name = 'No Available Image';
							    $media_type = 'image';
							    $media_size = 0;
							    $link = $mainURL.'images/no_image.jpg';
							}
							$id_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM scheme ORDER BY time_created DESC LIMIT 1"));
							if(isset($id_query['id']) == 0) {
								$id = 1;
							} else {
								$id = $id_query['id'];
								$id++;
							}
							$time_created = time();
							if($draw_place != '' && $scheme_title != '' && $draws != '' && $installment != '' && $return_installment != '' && $return_deduction != '' && $date_time != '' && $terms_conditons != '' && $media_name != '') {
								$query = mysqli_query($conn, "INSERT INTO scheme(id, title, short_description, long_description, time_created) VALUES('$id', '$scheme_title', '$short_description', '$long_description', '$time_created')");
								$meta = mysqli_query($conn, "INSERT INTO scheme_meta(scheme_id, meta_name, meta_key, meta_value) VALUES('$id', 'Draw Place', 'draw_place', '$draw_place'), ('$id', 'Total Draws', 'no_of_draws', '$draws'), ('$id', 'Installment', 'installment_per_month', '$installment'), ('$id', 'No Return Upto Installment', 'return_installment', '$return_installment'), ('$id', 'On Return Deduction', 'return_deduction', '$return_deduction'), ('$id', 'Draw Date and Time', 'draw_date_time', '$date_time'), ('$id', 'Scheme Terms and Conditions', 'scheme_terms_conditions', '$terms_conditons'), ('$id', 'Scheme Prefix', 'scheme_prefix', '$scheme_prefix'), ('$id', 'Scheme Group', 'scheme_group', '$scheme_group')");
								$image = mysqli_query($conn, "INSERT INTO media(scheme_id, media_name, media_path, media_type, media_size, media_for, time_created) VALUES('$id', '$media_name', '$link', '$media_type', '$media_size', '1', '$time_created')");
								if($query && $meta && $image) {
									echo "<div class='alert alert-success'><a href='#' data-dismiss='alert' class='close'>&times;</a>Scheme is Successfully Added</div>";
								} else {
									echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>Scheme is Not Added Please Try Again</div>";
								}
							} else {
								echo "<div class='alert alert-danger'><a href='#' data-dismiss='alert' class='close'>&times;</a>All Fields Are Requireds</div>";
							}
						}

						?>
					</div>
					<form class="form" id="scheme_form" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input type="text" id="draw_place" required class="form-control" placeholder="Enter Draw Place" name="draw_place">
							<div id="draw_place_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" required id="scheme_title" class="form-control" placeholder="Enter Scheme Title" name="scheme_title">
							<div id="scheme_title_msg"></div>
						</div>
						<div class="form-group">
							<input type="number" id="draws" required class="form-control" placeholder="Enter Number of Draws" name="draws">
							<div id="draws_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" id="installment" required class="form-control" placeholder="Enter Installment" name="installment">
							<div id="installment_msg"></div>
						</div>
						<div class="form-group">
							<input type="number" id="return_installment" class="form-control" placeholder="Enter No Return upto Installment" name="return_installment">
							<div id="return_installment_msg"></div>
						</div>
						<div class="form-group">
							<input type="text" id="return_deduction" class="form-control" placeholder="Enter On Return Deduction" name="return_deduction">
							<div id="return_deduction_msg"></div>
						</div>
						<div class="form-group">
							<input type="datetime-local" id="data_time" required class="form-control" name="date_time">
							<div id="date_time_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" id="short_description" name="short_description" placeholder="Enter Short Description" rows="4"></textarea>
							<div id="short_description_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" id="long_description" name="long_description" placeholder="Enter Long Description" rows="6"></textarea>
							<div id="long_description_msg"></div>
						</div>
						<div class="form-group">
							<textarea class="form-control" required id="terms_conditons" name="terms_conditons" placeholder="Enter Terms & Conditions"></textarea>
							<div id="terms_conditons_msg"></div>
						</div>
						<div class="form-group">
						    <input type="text" class="form-control" required id="scheme_prefix" name="scheme_prefix" placeholder="Enter Scheme Prefix">
						    <div id="scheme_prefix_msg"></div>
						</div>
						<div class="form-group">
						    <input type="number" class="form-control" required id="scheme_group" name="scheme_group" placeholder="Enter Scheme Group">
						    <div id="scheme_group_msg"></div>
						</div>
						<div class="form-group">
							<label>Scheme Image:</label>
							<input type="file" class="d-block" name="scheme_image">
						</div>
						<button class="btn btn-dark" type="submit" name="scheme_add_btn">Submit</button>
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
	<script type="text/javascript" src="jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#date_time').datapicker({
				format: 'Y-m-d H:i',
				formatTime:'H:i',
				formatDate:'Y-m-d',
				minDate:'2015-1-1'
			});
			$('#scheme_add_btn').on('click', function(e){
				e.preventDefault();
				var draw_place = $('#draw_place').val();
				var scheme_title = $('#scheme_title').val();
				var draws = $('#draws').val();
				var installment = $('#installment').val();
				var return_installment = $('#return_installment').val();
				var return_deduction = $('#return_deduction').val();
				var date_time = $('#date_time').val();
				var short_description = $('#short_description').val();
				var long_description = $('#long_description').val();
				var terms_conditons = $('#terms_conditons').val();
				var bool = 0;
				if(draw_place == '') {
					$('#draw_place').addClass('is-invalid');
					$('#draw_place_msg').addClass('invalid-feedback').text('This field is required');
					bool = 1;
				} else {
					$('#draw_place').removeClass('is-invalid');
					$('#draw_place_msg').removeClass('invalid-feedback').text('');
				}
				$('#draw_place').on('focus', function(){
					$('#draw_place').removeClass('is-invalid');
					$('#draw_place_msg').removeClass('invalid-feedback').text('');
				});
				if(scheme_title == '') {
					$('#scheme_title').addClass('is-invalid');
					$('#scheme_title_msg').addClass('invalid-feedback').text('This field is required');
				} else {
					$('#scheme_title').removeClass('is-invalid');
					$('#scheme_title_msg').removeClass('invalid-feedback').text('');
				}
				$('#scheme_title').on('focus', function(){
					$('#scheme_title').removeClass('is-invalid');
					$('#scheme_title_msg').removeClass('invalid-feedback').text('');
				});
				if(draws == '') {
					$('#draws').addClass('is-invalid');
					$('#draws_msg').addClass('invalid-feedback').text('This field is required');
					bool = 1;
				} else {
					$('#draws').removeClass('is-invalid');
					$('#draws_msg').removeClass('invalid-feedback').text('');
				}
				$('#draws').on('focus', function(){
					$('#draws').removeClass('is-invalid');
					$('#draws_msg').removeClass('invalid-feedback').text('');
				});
				if(installment == '') {
					$('#installment').addClass('is-invalid');
					$('#installment_msg').addClass('invalid-feedback').text('This field is required');
					bool = 1;
				} else {
					$('#installment').removeClass('is-invalid');
					$('#installment_msg').removeClass('invalid-feedback').text('');
				}
				$('#installment').on('focus', function(){
					$('#installment').removeClass('is-invalid');
					$('#installment_msg').removeClass('invalid-feedback').text('');
				});
				if(return_installment == '') {
					$('#return_installment').addClass('is-invalid');
					$('#return_installment_msg').addClass('invalid-feedback').text('This field is required');
					bool = 1;
				} else {
					$('#return_installment').removeClass('is-invalid');
					$('#return_installment_msg').removeClass('invalid-feedback').text('');
				}
				$('#return_installment').on('focus', function(){
					$('#return_installment').removeClass('is-invalid');
					$('#return_installment_msg').removeClass('invalid-feedback').text('');
				});
				if(return_deduction == '') {
					$('#return_deduction').addClass('is-invalid');
					$('#return_deduction_msg').addClass('invalid-feedback').text('This field is required');
					bool = 1;
				} else {
					$('#return_deduction').removeClass('is-invalid');
					$('#return_deduction_msg').removeClass('invalid-feedback').text('');
				}
				$('#return_deduction').on('focus', function(){
					$('#return_deduction').removeClass('is-invalid');
					$('#return_deduction_msg').removeClass('invalid-feedback').text('');
				});
				if(date_time == '') {
					$('#date_time').addClass('is-invalid');
					$('#date_time_msg').addClass('invalid-feedback').text('This field is required');
					bool = 1;
				} else {
					$('#date_time').removeClass('is-invalid');
					$('#date_time_msg').removeClass('invalid-feedback').text('');
				}
				$('#date_time').on('focus', function(){
					$('#date_time').removeClass('is-invalid');
					$('#date_time_msg').removeClass('invalid-feedback').text('');
				});
				if(short_description == '') {
					$('#short_description').addClass('is-invalid');
					$('#short_description_msg').addClass('invalid-feedback').text('This field is required');
					bool = 1;
				} else {
					$('#short_description').removeClass('is-invalid');
					$('#short_description_msg').removeClass('invalid-feedback').text('');
				}
				$('#short_description').on('focus', function(){
					$('#short_description').removeClass('is-invalid');
					$('#short_description_msg').removeClass('invalid-feedback').text('');
				});
				if(long_description == '') {
					$('#long_description').addClass('is-invalid');
					$('#long_description_msg').addClass('invalid-feedback').text('This field is required');
					bool = 1;
				} else {
					$('#long_description').removeClass('is-invalid');
					$('#long_description_msg').removeClass('invalid-feedback').text('');
				}
				$('#long_description').on('focus', function(){
					$('#long_description').removeClass('is-invalid');
					$('#long_description_msg').removeClass('invalid-feedback').text('');
				});
				if(terms_conditons == '') {
					$('#terms_conditons').addClass('is-invalid');
					$('#terms_conditons_msg').addClass('invalid-feedback').text('This field is required');
					bool = 1;
				} else {
					$('#terms_conditons').removeClass('is-invalid');
					$('#terms_conditons_msg').removeClass('invalid-feedback').text('');
				}
				$('#terms_conditons').on('focus', function(){
					$('#terms_conditons').removeClass('is-invalid');
					$('#terms_conditons_msg').removeClass('invalid-feedback').text('');
				});
			});
		});
	</script>
</body>
</html>