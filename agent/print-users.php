<?php

include "../include/db.inc.php";
include "function.php";

$draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$user_scheme_id'"));
$next_draw = $draws + 1;
if(isset($_GET['q'])) {
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    $q_query = mysqli_query($conn, "SELECT user_id FROM user_meta WHERE meta_value='$q' && meta_key='user_shipno'");
    if(mysqli_num_rows($q_query) > 0) {
        $q_result = mysqli_fetch_assoc($q_query);
        $user_id = $q_result['user_id'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' && role='2' && agent_id='$agent_id'");
    }
    $printUrl = 'print-users.php?q='.$q;
} else if(isset($_GET['status'])) {
    $status = $_GET['status'];
    $printUrl = 'print-users.php?status='.$status;
    if($status == 'active') {
        $query = mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$agent_id' && active_status='1' && delete_status='0'");
    } else if($status == 'inactive') {
        $query = mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$agent_id' && active_status='0' && delete_status='0'");
    } else if($status == 'nonpaid') {
        $query = mysqli_query($conn, "SELECT u.id, u.active_status, u.user_phone FROM users u LEFT JOIN transaction t ON u.id=t.user_id && t.month='$next_draw' WHERE t.id IS NULL && u.agent_id='$agent_id' && u.role='2' && u.active_status='1' && u.delete_status='0' && u.enroll_status='1'");
    } else if($status == 'paid') {
        $query = mysqli_query($conn, "SELECT u.id, u.active_status, u.user_phone FROM users u INNER JOIN transaction t ON u.id=t.user_id WHERE t.installment_num='$next_draw' && u.role='2' && u.agent_id='$agent_id' && u.active_status='1' && u.delete_status='0' && u.enroll_status='1'");
    }
} else {
    $printUrl = 'print-users.php';
	$query = mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$agent_id'");
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
					<div class='card card-body mb-3 p-0 d-print-none'><button type='button' id='print_user_btn' class='btn btn-success'>Print Users</button></div>
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-lg">
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

							if(mysqli_num_rows($query) > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($query)) {
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
			<div id="modal" class="modal">
				<div id="modal-dialog"></div>
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
		    $('#print_user_btn').on('click', function(){
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
			$(document).on('click', '.close', function(e){
			    e.preventDefault();
				if($(this).data('dismiss') == 'modal') {
				    $('#modal-dialog').html('');
					$("#modal").hide('slow');
					window.location.href = window.location.href;
				}
			});
			$(document).on('click', '.add_payment_btn', function(){
				$("#modal").show('slow');
				$('#modal-dialog').html('');
				var payment_id = $(this).data('payid');
				$.ajax({
					url: 'ajax/display_add_payment.php',
					type: 'POST',
					data: {id:payment_id},
					success: function(result) {
						$('#modal-dialog').html(result);
					}
				});
			});
			$(document).on('click', '.view_payment_btn', function(){
				$("#modal").show('slow');
				$('#modal-dialog').html('');
				var payViewId = $(this).data('payviewid');
				$.ajax({
					url: 'ajax/display_view_payment.php',
					type: 'POST',
					data: {id:payViewId},
					success: function(result) {
						$('#modal-dialog').html(result);
					}
				});
			});
		});
	</script>
</body>
</html>