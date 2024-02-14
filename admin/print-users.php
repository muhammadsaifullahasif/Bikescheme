<?php

include "function.php";

if(isset($_GET['aid'])) {
	$aid = $_GET['aid'];
	$query = mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$aid'");
} else if(isset($_GET['q'])) {
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    $q_query = mysqli_query($conn, "SELECT user_id FROM user_meta WHERE meta_value='$q' && meta_key='user_shipno'");
    if(mysqli_num_rows($q_query) > 0) {
        $q_result = mysqli_fetch_assoc($q_query);
        $user_id = $q_result['user_id'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' && role='2'");
    }
} else if(isset($_GET['status'])) {
    $status = $_GET['status'];
    if($status == 'active') {
        $query = "SELECT * FROM users WHERE role='2' && active_status='1' && delete_status='0'";
        $run = mysqli_query($conn, $query);
    } else if($status == 'inactive' || $status != 'active') {
        $query = "SELECT * FROM users WHERE role='2' && active_status='0' && delete_status='0'";
        $run = mysqli_query($conn, $query);
    }
} else {
    $query = "SELECT * FROM users WHERE role='2'";
    $conn->set_charset('utf8');
    $run = mysqli_query($conn, $query);
    $total = mysqli_num_rows($run);
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
				<div class="card-header bg-dark text-white d-print-none">
					<h5 class="card-title float-left">Manage Users</h5>
					<a href="user-add.php" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<div class='card card-body mb-3 p-0 d-print-none'><button class='btn btn-success d-print-none' type='button' id="user_print_btn">Print User List</button></div>
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md" id="user_print">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Membership</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Address</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Membership</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Address</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							if(mysqli_num_rows($run) > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($run)) {
									$id = $result['id'];
									$user_scheme_id = $result['scheme_id'];
									$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
									if(mysqli_num_rows($meta_query) > 0) {
										while($meta_result = mysqli_fetch_assoc($meta_query)) {
											$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
										}
									}
									$scheme = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, title FROM scheme WHERE id='$user_scheme_id'"));
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $meta['user_shipno']; ?></td>
								<td><?php echo $meta['user_name']; ?></td>
								<td><?php echo $result['user_phone']; ?></td>
								<td><?php echo $meta['user_address']; ?></td>
							</tr>
							<?php
									$i++;
								}
							} else {
								echo "<tr><td colspan='7' class='text-center'>No Record Found</td><tr>";
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
		    $('#user_print_btn').on('click', function(){
		        window.print();
		    });
			$(document).on('click', '.delete-user', function(){
				if(confirm('Are you sure to delete user?')) {
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
		});
	</script>
</body>
</html>












