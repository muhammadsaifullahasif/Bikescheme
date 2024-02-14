<?php

include "function.php";
$query = "SELECT i.id, i.title, i.title, i.active_status, m.media_path, m.media_alt FROM images i INNER JOIN media m ON i.id=m.for_id WHERE m.media_for='4'";
$conn->set_charset('utf8');
$run = mysqli_query($conn, $query);
$total = mysqli_num_rows($run);

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
					<h5 class="card-title float-left">Manage Images</h5>
					<a href="image-new.php" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Image</th>
								<th>Status</th>
								<th>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Image</th>
								<th>Status</th>
								<th>Options</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							if($total > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($run)) {
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $result['title']; ?></td>
								<td><img src="<?php echo $result['media_path']; ?>" style="width: 200px"></td>
								<td><button data-did="<?php echo $result['id']; ?>" class="btn active-image btn-link"><?php if($result['active_status'] == 1) echo "Active"; else echo "Inactive"; ?></button></td>
								<td>
									<a href="image-edit.php?id=<?php echo $result['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
									<button type="button" data-did="<?php echo $result['id']; ?>" class="btn delete-image btn-danger btn-sm"><i class="fas fa-trash"></i></button>
								</td>
							</tr>
							<?php
									$i++;
								}
							} else {
								echo "<tr><td colspan='5' class='text-center'>No Record Found</td></tr>";
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.active-image', function(){
				var activate_image_id = $(this).data('did');
				$.ajax({
					url: 'ajax/activate-image.php',
					type: 'POST',
					data: {id:activate_image_id},
					success: function(result) {
						if(result == 1)
							window.location.href = window.location.href;
						else
							alert('Please Try Again');
					}
				});
			});
			$(document).on('click', '.delete-image', function(){
				if(confirm('Are you sure to delete Image?')) {
					var slider_id = $(this).data('did');
					$.ajax({
						url: 'ajax/image-delete.php',
						type: 'POST',
						data: {id:slider_id},
						success: function(result) {
							if(result == 1)
								window.location.href = window.location.href;
							else
								alert('Please Try Again');
						}
					});
				}
			});
		});
	</script>
</body>
</html>