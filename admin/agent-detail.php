<?php

include "function.php";
if(isset($_GET['id'])) {
	$id = mysqli_real_escape_string($conn, $_GET['id']);
} else {
	header('location:users.php');
}

$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
if(mysqli_num_rows($query) > 0) {
	$result = mysqli_fetch_assoc($query);
	$scheme_id = $result['scheme_id'];
	$user_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
	if(mysqli_num_rows($user_meta_query) > 0) {
		while($user_meta_result = mysqli_fetch_assoc($user_meta_query)) {
			$meta[$user_meta_result['meta_key']] = $user_meta_result['meta_value'];
		}
	}
	$media_query = mysqli_query($conn, "SELECT * FROM media WHERE user_id='$id' && media_for='2'");
	if(mysqli_num_rows($media_query) > 0) {
		$media = mysqli_fetch_assoc($media_query);
	}
	$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE id='$scheme_id'");
	if(mysqli_num_rows($scheme_query) > 0) {
		$scheme = mysqli_fetch_assoc($scheme_query);
		$scheme_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$scheme_id'");
		if(mysqli_num_rows($scheme_meta_query) > 0) {
			while($scheme_meta_result = mysqli_fetch_assoc($scheme_meta_query)) {
				$scheme_meta[$scheme_meta_result['meta_key']] = $scheme_meta_result['meta_value'];
			}
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
					<h5 class="card-title d-inline">Agent Detail</h5>
					<a href="agents.php" class="btn btn-dark float-right">Back</a>
				</div>
				<div class="card-body">
					<table class="table table-sm">
						<tr>
							<td colspan="2" class="text-center"><img height="100" width="100" src="<?php echo $media['media_path']; ?>"></td>
						</tr>
						<tr>
							<td>Name:</td>
							<td><?php echo $meta['user_name']; ?></td>
						</tr>
						<tr>
							<td>Father Name:</td>
							<td><?php echo $meta['user_father_name']; ?></td>
						</tr>
						<tr>
							<td>CNIC:</td>
							<td><?php echo $meta['user_cnic']; ?></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><?php echo $result['user_email']; ?></td>
						</tr>
						<tr>
							<td>Phone:</td>
							<td><?php echo $result['user_phone']; ?></td>
						</tr>
						<tr>
							<td>Address:</td>
							<td><?php echo $meta['user_address']; ?></td>
						</tr>
					</table>
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