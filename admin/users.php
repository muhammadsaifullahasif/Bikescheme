<?php

include "function.php";

if(isset($_GET['aid'])) {
	$aid = mysqli_real_escape_string($conn, $_GET['aid']);
	$query = mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$aid' && delete_status='0'");
	$printUrl = 'print-users.php?aid='.$aid;
} else if(isset($_GET['q'])) {
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    $q_query = mysqli_query($conn, "SELECT user_id FROM user_meta WHERE meta_value='$q' && meta_key='user_shipno'");
    if(mysqli_num_rows($q_query) > 0) {
        $q_result = mysqli_fetch_assoc($q_query);
        $user_id = $q_result['user_id'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' && role='2'");
    }
    $printUrl = 'print-users.php?q='.$q;
} else if(isset($_GET['status'])) {
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    if($status == 'active') {
        $query = "SELECT * FROM users WHERE role='2' && active_status='1' && delete_status='0'";
        $run = mysqli_query($conn, $query);
    } else if($status == 'inactive' || $status != 'active') {
        $query = "SELECT * FROM users WHERE role='2' && active_status='0' && delete_status='0'";
        $run = mysqli_query($conn, $query);
    }
    $printUrl = 'print-users.php?status='.$status;
} else {
    $query = "SELECT * FROM users WHERE role='2' && delete_status='0'";
    $conn->set_charset('utf8');
    $run = mysqli_query($conn, $query);
    $total = mysqli_num_rows($run);
    $printUrl = 'print-users.php';
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
					<h5 class="card-title float-left">Manage Users</h5>
					<a href="user-add.php" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<div class='card card-body mb-3 p-0'><a target="_blank" href="<?php echo $printUrl; ?>" class='btn btn-success'>Print User List</a></div>
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md" id="user_print">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th class='d-print-none'>Username</th>
								<th>Membership</th>
								<th class='d-print-block d-none'>Name</th>
								<th class='d-print-block d-none'>Phone</th>
								<th class='d-print-block d-none'>Address</th>
								<th class='d-print-none'>CNIC</th>
								<th class='d-print-none'>Scheme Name</th>
								<th class='d-print-none'>Status</th>
								<th class='d-print-none'>Total Paid</th>
								<th class='d-print-none'>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th class='d-print-none'>Username</th>
								<th>Membership</th>
								<th class='d-print-flex d-none'>Name</th>
								<th class='d-print-block d-none'>Phone</th>
								<th class='d-print-block d-none'>Address</th>
								<th class='d-print-none'>CNIC</th>
								<th class='d-print-none'>Scheme Name</th>
								<th class='d-print-none'>Status</th>
								<th class='d-print-none'>Total Paid</th>
								<th class='d-print-none'>Options</th>
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
									
									$total_amount_query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$id'");
									$total_amount = 0;
									if(mysqli_num_rows($total_amount_query) > 0) {
									    while($total_amount_result = mysqli_fetch_assoc($total_amount_query)) {
									        $total_amount = $total_amount + $total_amount_result['payment'];
									    }
									}
									
									$scheme = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, title FROM scheme WHERE id='$user_scheme_id'"));
									$clearance_query = mysqli_query($conn, "SELECT * FROM clearance WHERE user_id='$id' && scheme_id='$user_scheme_id'");
									if(mysqli_num_rows($clearance_query) > 0) {
									    continue;
									} else {
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td class='d-print-none'><a href="tel:<?php echo $result['user_phone']; ?>"><?php echo $meta['user_name']; ?></a></td>
								<td><?php echo $meta['user_shipno']; ?></td>
								<td class='d-print-block d-none'><?php echo $meta['user_name']; ?></td>
								<td class='d-print-block d-none'><?php echo $result['user_phone']; ?></td>
								<td class='d-print-block d-none'><?php echo $meta['user_address']; ?></td>
								<td class='d-print-none'><?php echo $meta['user_cnic']; ?></td>
								<td class='d-print-none'><a href="scheme-detail.php?scheme_id=<?php echo $scheme['id']; ?>"><?php echo $scheme['title']; ?></a></td>
								<td class='d-print-none'><button class="btn btn-sm btn-link activate_user" data-aid="<?php echo $result['id']; ?>"><?php if($result['active_status'] == 1) echo "Active"; else echo "Inactive"; ?></button></td>
								<td class='d-print-none'><b>Rs: <?php echo $total_amount; ?></b></td>
								<td class='d-print-none'>
									<div class="btn-group">
										<a href="user-detail.php?id=<?php echo $id; ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
										<a href="user-edit.php?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
										<button data-did="<?php echo $id; ?>" class="btn btn-danger delete-user"><i class="fas fa-trash"></i></button>
										<?php
										
										if(mysqli_num_rows($clearance_query) > 0) {
										    echo '<a target="_blank" href="clearance-invoice.php?user_id='.$id.'&scheme_id='.$user_scheme_id.'" class="btn btn-primary">Print Invoice</a>';
										} else {
										    echo '<a href="clearance.php?user_id='.$id.'&scheme_id='.$user_scheme_id.'" class="btn btn-success">Clearance</a>';
										}
										
										?>
									</div>
								</td>
							</tr>
							<?php
									}
									$i++;
								}
							} else {
								echo "<tr><td colspan='8' class='text-center'>No Record Found</td><tr>";
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












