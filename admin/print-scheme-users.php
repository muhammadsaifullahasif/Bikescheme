<?php

include "function.php";
if(isset($_GET['scheme_id'])) {
	$scheme_id = mysqli_real_escape_string($conn, $_GET['scheme_id']);
	$printUrl = 'print-scheme-users.php?scheme_id='.$scheme_id;
} else {
    if(isset($_GET['status']) && isset($_GET['scheme_id'])) {
        $status = $_GET['status'];
    } else if(isset($_GET['status']) && !isset($_GET['scheme_id'])) {
        $status = $_GET['status'];
        header("location:select-scheme.php?status=".$status);
    } else {
        header('location:index.php');
    }
    $printUrl = 'print-scheme-users.php?scheme_id='.$scheme_id.'&status='.$status;
}
if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$draw_query = mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$scheme_id'");
$draw_total = mysqli_num_rows($draw_query);
$next_draw = $draw_total + 1;
if(isset($_GET['status']) && isset($_GET['scheme_id'])) {
    $scheme_id = $_GET['scheme_id'];
    $status = $_GET['status'];
    if($status == "paid") {
		// Checking the user is already paid or not
		$query = "SELECT u.id, u.user_phone FROM users u INNER JOIN transaction t ON u.id=t.user_id WHERE t.installment_num='$next_draw' && u.role='2' && u.active_status='1' && u.delete_status='0' && u.enroll_status='1'";
        $run = mysqli_query($conn, $query);
        $total = mysqli_num_rows($run);
    } else if($status == "nonpaid") {
		// Checking the user is already paid or not
		$month = date("m-Y", time());
		$query = "SELECT DISTINCT u.id, u.user_phone FROM users u LEFT JOIN transaction t ON u.id=t.user_id && t.month='$next_draw' WHERE t.id IS NULL && u.role='2' && u.active_status='1' && u.delete_status='0' && u.enroll_status='1'";
        $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $total = mysqli_num_rows($run);
    }
} else {
    $query = "SELECT * FROM users WHERE scheme_id='$scheme_id' && active_status='1' && delete_status='0' && role='2' && enroll_status='1'";
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
			<div class="card">
				<div class="card-header bg-dark text-white d-print-none">
					<h5 class="card-title d-inline">Scheme Detail</h5>
					<a href='schemes.php' class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<div class='card card-body mb-3 p-0 d-print-none'><button type='button' id='print_user_btn' class='btn btn-success'>Print User List</button></div>
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
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

							if($total > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($run)) {
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
								<td><?php echo $meta['user_name']; ?></td>
								<td><?php echo $result['user_phone']; ?></td>
								<td><?php echo $meta['user_address']; ?></td>
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