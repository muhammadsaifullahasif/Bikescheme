<?php

include "function.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include "head.php"; ?>
</head>
<body>
	<?php include "header.php"; ?>
	<?php include "nav.php"; ?>
	<section class="my-3">
		<div class="container-fluid">
			<ul class="nav bg-dark text-white nav-justified">
				<li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
				<li class="nav-item"><a href="transaction.php" class="nav-link text-white">Transaction</a></li>
				<li class="nav-item"><a href="setting.php" class="nav-link text-white">Setting</a></li>
			</ul>
			<div class="card card-body">
				<table class="table table-sm table-striped table-hover table-responsive-md">
					<tr>
						<td colspan="2" class="text-right"><a href="profile-edit.php" class="btn btn-dark"><i class="fas fa-edit mr-2"></i>Edit</a></td>
					</tr>
					<tr>
						<td colspan="2" class="text-center"><img width="100" height="100" src="<?php echo $media['media_path']; ?>" alt="<?php echo $media['media_alt']; ?>"></td>
					</tr>
					<tr>
						<td>Membership Number:</td>
						<td><?php echo $meta['user_shipno']; ?></td>
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
					<tr>
						<td>Scheme:</td>
						<td><?php echo $scheme_result['title']; ?></td>
					</tr>
				</table>
			</div>
		</div>
	</section>
	<?php include "../footer.php"; ?>
	<?php include "js.php"; ?>
</body>
</html>