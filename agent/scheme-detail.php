<?php

include "../include/db.inc.php";
include "function.php";
if(isset($_GET['scheme_id'])) {
	$scheme_id = mysqli_real_escape_string($conn, $_GET['scheme_id']);
} else {
	header('location:index.php');
}

$query = mysqli_query($conn, "SELECT * FROM users WHERE scheme_id='$scheme_id' && agent_id='$agent_id' && active_status='1' && delete_status='0' && role='2' && enroll_status='1'");
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
			<div class="card">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title">Scheme Detail</h5>
				</div>
				<div class="card-body">
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Membership</th>
								<th>Name</th>
								<th>Phone</th>
								<th>CNIC</th>
								<th>Option</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Membership</th>
								<th>Name</th>
								<th>Phone</th>
								<th>CNIC</th>
								<th>Option</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							if($total > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($query)) {
									$id = $result['id'];
									$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
									if(mysqli_num_rows($meta_query) > 0) {
										while($meta_result = mysqli_fetch_assoc($meta_query)) {
											$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
										}
									}
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $meta['user_shipno']; ?></td>
								<td><a href="tel:<?php echo $result['user_phone']; ?>"><?php echo $meta['user_name']; ?></a></td>
								<td><a href="tel:<?php echo $result['user_phone']; ?>"><?php echo $result['user_phone']; ?></a></td>
								<td><?php echo $meta['user_cnic']; ?></td>
								<td>
									<div class="btn-group">
										<?php

										if($agent_meta['user_allow_transaction'] == 'yes') {
										?>
										<button data-payid="<?php echo $id; ?>" class="btn btn-success add_payment_btn btn-sm">Add Payment</button>
										<?php
										}

										?>
										<button data-payviewid="<?php echo $id; ?>" class="btn btn-danger view_payment_btn btn-sm">View Payment</button>
									</div>
								</td>
							</tr>
							<?php
									$i++;
								}
							} else {
								echo "<tr><td class='text-center' colspan='6'>No Record Found</td></tr>";
							}

							?>
						</tbody>
					</table>
				</div>
			</div>
			<div id="modal" class="modal">
				<div id="modal-dialog" class="modal-dialog-scrollable"></div>
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
			$(document).on('click', '.close', function(){
				if($(this).data('dismiss') == 'modal') {
					$("#modal").hide('slow');
				}
			});
			$(document).on('click', '.add_payment_btn', function(){
				$("#modal").show('slow');
				// $('#add_payment_amount').focus();
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