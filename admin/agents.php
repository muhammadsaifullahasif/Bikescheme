<?php

include "function.php";
if(isset($_GET['limit'])) {
    $limit = $_GET['limit'];
} else {
    $limit = 25;
}
$user = "select * from users WHERE role='1'";
$userRun = mysqli_query($conn, $user);
$userTotal = mysqli_num_rows($userRun);
$totalPages = ceil($userTotal / $limit);
if(isset($_GET['page']) && isset($_GET['order'])) {
	$page = $_GET['page'];
	$order = $_GET['order'];
} else {
	$page = 1;
	$order = 'ASC';
}
$offset = ($page - 1) * $limit;
$query = "select * from users WHERE role='1' ORDER BY id $order limit $offset, $limit";
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
					<h5 class="card-title float-left">Manage Agents</h5>
					<a href="agent-add.php" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<div class="card card-body mb-3 p-2">
						<div class="row mb-3">
							<div class="col-md-6">
								<span>Sort by: </span>
								<select class="custom-select custom-select-sm" style="width: 10rem;" id="order_filter">
									<option <?php if($order == "ASC") echo "selected"; ?> value="ASC">Assending</option>
									<option <?php if($order == "DESC") echo "selected"; ?> value="DESC">Descending</option>
								</select>
								<select class="custom-select custom-select-sm" style="width: 5rem;" id="limit_filter">
									<option <?php if($limit == 25) echo "selected"; ?> value="25">25</option>
									<option <?php if($limit == 50) echo "selected"; ?> value="50">50</option>
									<option <?php if($limit == 100) echo "selected"; ?> value="100">100</option>
									<option <?php if($limit == 500) echo "selected"; ?> value="500">500</option>
								</select>
							</div>
						</div>
					</div>
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Username</th>
								<th>CNIC</th>
								<th>Allow Transaction</th>
								<th>Users</th>
								<th>Status</th>
								<th>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Username</th>
								<th>CNIC</th>
								<th>Allow Transaction</th>
								<th>Users</th>
								<th>Status</th>
								<th>Options</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							if(mysqli_num_rows($run) > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($run)) {
									$id = $result['id'];
									$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE agent_id='$id'"));
									$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
									if(mysqli_num_rows($meta_query) > 0) {
										while($meta_result = mysqli_fetch_assoc($meta_query)) {
											$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
										}
									}
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $meta['user_name']; ?></td>
								<td><?php echo $result['user_login']; ?></td>
								<td><?php echo $meta['user_cnic']; ?></td>
								<td><button class="btn btn-sm btn-link allow_transaction" data-tid="<?php echo $result['id']; ?>"><?php echo $meta['user_allow_transaction']; ?></button></td>
								<td><a href="users.php?aid=<?php echo $id; ?>"><?php echo $totalUsers; ?></a></td>
								<td><button class="btn btn-sm btn-link activate_user" data-aid="<?php echo $result['id']; ?>"><?php if($result['active_status'] == 1) echo "Active"; else echo "Inactive"; ?></button></td>
								<td>
									<div class="btn-group">
										<a href="" class="btn btn-info btn-sm"><i class="fas fa-gift"></i></a>
										<a href="agent-detail.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
										<a href="agent-edit.php?id=<?php echo $id; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
										<button type="button" data-did="<?php echo $id; ?>" class="btn delete-agent btn-danger btn-sm"><i class="fas fa-trash"></i></button>
									</div>
								</td>
							</tr>
							<?php
									$i++;
								}
							} else {
								echo "<tr><td colspan='8' class='text-center'>No Record Found</td></tr>";
							}

							?>
						</tbody>
					</table>
					<ul class="pagination justify-content-end">
						<?php

						if($page > 1) {
							echo "<li class='page-item'><a href='agents.php?page=1' class='page-link'><i class='fas fa-angle-double-left'></i></a></li>";
							echo "<li class='page-item'><a href='agents.php?page=".($page - 1)."' class='page-link'><i class='fas fa-chevron-left'></i></a></li>";
						}

						for($j = 1; $j <= $totalPages; $j++) {
						?>
						<li class='page-item'><a href="agents.php?page=<?php echo $j; ?>" class="page-link"><?php echo $j; ?></a></li>
						<?php
						}

						if($totalPages > $page) {
							echo "<li class='page-item'><a href='agents.php?page=".($page + 1)."' class='page-link'><i class='fas fa-chevron-right'></i></a></li>";
							echo "<li class='page-item'><a href='agents.php?page=".$totalPages."' class='page-link'><i class='fas fa-angle-double-right'></i></a></li>";
						}

						?>
					</ul>
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
		    $('#order_filter').on('change', function(){
		        order = $(this).val();
		      window.location.href = '<?php echo $url; ?>'+'agents.php?page=<?php echo $page; ?>&order='+order;
		    });
		    $('#limit_filter').on('change', function(){
		        limit = $(this).val();
		        window.location.href = '<?php echo $url; ?>agents.php?limit='+limit;
		    });
			$(document).on('click', '.allow_transaction', function(){
				var tid = $(this).data('tid');
				$.ajax({
					url: 'ajax/allow-transaction.php',
					type: 'POST',
					data: {id:tid},
					success: function(result) {
						if(result == 1) {
							window.location.href = window.location.href;
						} else {
							alert('Please Try Again');
						}
					}
				});
			});
			$(document).on('click', '.activate_user', function(){
				var activate_user_id = $(this).data('aid');
				$.ajax({
					url: 'ajax/activate-user.php',
					type: 'POST',
					data: {id:activate_user_id},
					success: function(result) {
						if(result == 1)
							window.location.href = window.location.href;
						else
							alert('Please Try Again');
					}
				});
			});
			$(document).on('click', '.delete-agent', function(){
				if(confirm('Are you sure to delete agent?')) {
					var did = $(this).data('did');
					$.ajax({
						url: 'ajax/user-delete.php',
						type: 'POST',
						data: {id:did},
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