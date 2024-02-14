<?php

include "function.php";
$query = mysqli_query($conn, "SELECT * FROM news WHERE type='1'");
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
					<h5 class="card-title float-left">Manage Users</h5>
					<a href="news-add.php" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Description</th>
								<th>Added Date</th>
								<th>Status</th>
								<th>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Description</th>
								<th>Added Date</th>
								<th>Status</th>
								<th>Options</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							if($total > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($query)) {
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $result['title']; ?></td>
								<td><?php echo $result['news_text']; ?></td>
								<td><?php echo $result['date_created']; ?></td>
								<td><button type="button" class="btn btn-link btn-sm activate-news" data-aid="<?php echo $result['id']; ?>"><?php if($result['active_status'] == 1) echo "Active"; else echo "Inactive"; ?></button></td>
								<td>
									<div class="btn-group">
										<a href="" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
										<a href="news-edit.php?id=<?php echo $result['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
										<a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
									</div>
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.activate-news', function(){
				var aid = $(this).data('aid');
				$.ajax({
					url: 'ajax/activate-news.php',
					type: 'POST',
					data: {id:aid},
					success: function(result) {
						window.location.href = window.location.href;
					}
				});
			});
		});
	</script>
</body>
</html>