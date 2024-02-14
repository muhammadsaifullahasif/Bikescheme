<?php

include "function.php";
$query = mysqli_query($conn, "SELECT * FROM scheme");
$total = mysqli_num_rows($query);

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
					<h5 class="card-title float-left">Manage Draws</h5>
				</div>
				<div class="card-body">
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Total Draws</th>
								<th>Total Users</th>
								<th>Announced</th>
								<th>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Total Draws</th>
								<th>Total Users</th>
								<th>Announced</th>
								<th>Options</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							if($total > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($query)) {
									$id = $result['id'];
									$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_scheme WHERE scheme_id='$id'"));
									$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$id'");
									if(mysqli_num_rows($meta_query) > 0) {
										while($meta_result = mysqli_fetch_assoc($meta_query)) {
											$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
										}
									}
									$totalDraws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$id'"));
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><a href="draw-add.php?id=<?php echo $result['id']; ?>"><?php echo $result['title']; ?></a></td>
								<td><?php echo $meta['no_of_draws']; ?></td>
								<td><?php echo $totalUsers; ?></td>
								<td><?php echo $totalDraws; ?></td>
								<td>
									<a href="" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
								</td>
							</tr>
							<?php
									$i++;
								}
							} else {
								echo "<tr><td colspan='6' class='text-center'>No Record Found</td></tr>";
							}

							?>
						</tbody>
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