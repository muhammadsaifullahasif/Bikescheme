<?php

include "function.php";
$query = "SELECT * FROM news WHERE type='2'";
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
					<h5 class="card-title float-left">Manage Announcement</h5>
					<a href="announcement-add.php" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Announcement</th>
								<th>Added Date</th>
								<th>Status</th>
								<th>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Announcement</th>
								<th>Added Date</th>
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
								<td><?php echo $result['news_text']; ?></td>
								<td><?php echo $result['date_created']; ?></td>
								<td><button data-aid="<?php echo $result['id']; ?>" class="btn btn-link activate_user"><?php if($result['active_status'] == 1) echo "Active"; else echo "Inactive"; ?></button></td>
								<td>
									<div class="btn-group">
										<a href="announcement-edit.php?id=<?php echo $result['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
										<button type="button" data-did="<?php echo $result['id']; ?>" class="btn btn-danger delete-announcement btn-sm"><i class="fas fa-trash"></i></button>
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
	<script>
	    $(document).ready(function(){
	        $(document).on('click', '.activate_user', function(){
				var activate_announcement_id = $(this).data('aid');
				$.ajax({
					url: 'ajax/activate-announcement.php',
					type: 'POST',
					data: {id:activate_announcement_id},
					success: function(result) {
						if(result == 1)
							window.location.href = window.location.href;
						else
							alert('Please Try Again');
					}
				});
			});
	        $(document).on('click', '.delete-announcement', function(){
	            if(confirm('Are you sure to delete announcement?')) {
	                var delete_id = $(this).data('did');
	                $.ajax({
	                    url: 'ajax/announcement-delete.php',
	                    type: 'POST',
	                    data: {id:delete_id},
	                    success: function(result) {
	                        window.location.href = window.location.href;
	                    }
	                });
	            }
	        });
	    });
	</script>
</body>
</html>
















