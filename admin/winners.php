<?php

include "function.php";

$query = mysqli_query($conn, "SELECT d.draw_prize, d.draw_date, u.id, u.user_phone FROM draw d LEFT JOIN users u ON d.user_id=u.id");

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
					<h5 class="card-title d-inline">Scheme Detail</h5>
					<a href='schemes.php' class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Membership</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Prize</th>
								<th>Draw Date</th>
								<th>Option</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Membership</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Prize</th>
								<th>Draw Date</th>
								<th>Option</th>
							</tr>
						</tfoot>
						<tbody>
							<?php
							
							   
							if(mysqli_num_rows($query) > 0) {
							    $i = 1;
							    while($result = mysqli_fetch_assoc($query)) {
							        $user_id = $result['id'];
							        $user_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$user_id'");
							        while($user_meta_result = mysqli_fetch_assoc($user_meta_query)) {
							            $user_meta[$user_meta_result['meta_key']] = $user_meta_result['meta_value'];
							        }
							      ?>
							      <tr>
							          <td><?php echo $i; ?></td>
							          <td><?php echo $user_meta['user_shipno']; ?></td>
							          <td><?php echo $user_meta['user_name']; ?></td>
							          <td><?php echo $result['user_phone']; ?></td>
							          <td><?php echo $result['draw_prize']; ?></td>
							          <td><?php echo $result['draw_date']; ?></td>
							          <td><button data-payviewid="<?php echo $id; ?>" class="btn btn-danger view_payment_btn btn-sm">View Payment</button></td>
							      </tr>
							      <?php
							        $i++;
							    }
							} else {
							    echo "<tr><td colspan='7' class='text-center'>No Record Found</td></tr>";
							}

							

							?>
						</tbody>
					</table>
				</div>
			</div>
			<div id="modal" class="modal">
				<div id="modal-dialog" class="modal-dialog modal-dialog-scrollable modal-xl"></div>
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
			$(document).on('click', '.close', function(e){
			    e.preventDefault();
				if($(this).data('dismiss') == 'modal') {
					$("#modal").hide('slow');
				}
			});
			$(document).on('click', '.add_payment_btn', function(){
				$("#modal").show('slow');
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