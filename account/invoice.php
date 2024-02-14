<?php

include "../include/db.inc.php";
include "function.php";

if(isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	header('location:index.php');
}

$transaction_query = mysqli_query($conn, "SELECT * FROM transaction WHERE id='$id'");
$transaction_total = mysqli_num_rows($transaction_query);
$userid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaction WHERE id='$id'"));
$user_id = $userid['user_id'];
$yet_payment = 0;
$yet_payment_month = $userid['month'];
$total_transaction_query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$user_id' && month<='$yet_payment_month'");
if(mysqli_num_rows($total_transaction_query) > 0) {
    while($total_transaction_result = mysqli_fetch_assoc($total_transaction_query)) {
        $yet_payment = $yet_payment + $total_transaction_result['payment'];
    }
}
$t_query = mysqli_query($conn, "SELECT * FROM transaction WHERE id='$id'");
if(mysqli_num_rows($t_query) > 0) {
	while($t_result = mysqli_fetch_assoc($t_query)) {
		if($t_result['dues']<0) {
			$t_additional = '<span style="color:red;font-weight:bold">'.$t_result['dues'].'</span>';
		} elseif($t_result['dues']>0) {
			$t_additional = '<span style="color:green;font-weight:bold">+'.str_replace('-','+',$t_result['dues']).'</span>';
		} else {
			$t_additional = '<span style="color:black;font-weight:bold">'.$t_result['dues'].'</span>';
		}
	}
}
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' && role='2'");
if(mysqli_num_rows($user_query) > 0) {
	$user_result = mysqli_fetch_assoc($user_query);
	$user_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$user_id'");
	if(mysqli_num_rows($user_meta_query) > 0) {
		while($user_meta_result = mysqli_fetch_assoc($user_meta_query)) {
			$user_meta[$user_meta_result['meta_key']] = $user_meta_result['meta_value'];
		}
	}
	$scheme_id = $user_result['scheme_id'];
	$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE id='$scheme_id'");
	if(mysqli_num_rows($scheme_query) > 0) {
		$scheme_result = mysqli_fetch_assoc($scheme_query);
		$scheme_meta_query = "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$scheme_id'";
		$conn->set_charset('utf8');
		$scheme_meta_run = mysqli_query($conn, $scheme_meta_query);
		if(mysqli_num_rows($scheme_meta_run) > 0) {
			while($scheme_meta_result = mysqli_fetch_assoc($scheme_meta_run)) {
				$scheme_meta[$scheme_meta_result['meta_key']] = $scheme_meta_result['meta_value'];
			}
		}
	}
}

$draw_date = mysqli_fetch_assoc(mysqli_query($conn, "SELECT draw_date FROM transaction WHERE id='$id'"));

$paid_installment = mysqli_fetch_assoc(mysqli_query($conn, "SELECT installment_num FROM transaction WHERE id='$id'"));

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
			<div class="card card-body d-print-none"><button type="button" id="print_invoice" class="btn btn-lg btn-success mr-3 mb-1">Print</button></div>
			<div id="invoice">
				<div class="card card-body p-0">
					<table class="table table-striped table-hover table-sm">
						<tr>
							<td>Scheme:</td>
							<td><?php echo $scheme_result['title']; ?></td>
							<td>User Membership:</td>
							<td style="font-size: 25px; font-weight: bold" class="text-danger"><h2><?php echo $user_meta['user_shipno']; ?></h2></td>
						</tr>
						<tr>
							<td>Name:</td>
							<td><?php echo $user_meta['user_name']; ?></td>
							<td>CNIC:</td>
							<td><?php echo $user_meta['user_cnic']; ?></td>
						</tr>
						<tr>
							<td>Mobile:</td>
							<td><?php echo $user_result['user_phone']; ?></td>
							<td>Total Collected Payment:</td>
							<td><?php echo $yet_payment; ?></td>
						</tr>
						<tr>
							<td>Installment Permonth:</td>
							<td class="text-danger"><h2>Rs: <?php echo $scheme_meta['installment_per_month'] ?></h2></td>
							<td>Paid / Total Installment:</td>
							<td class="text-danger"><h2><?php echo $paid_installment['installment_num'].'/'.$scheme_meta['no_of_draws']; ?></h2></td>
						</tr>
						<tr>
							<td>Draw Date and Time</td>
							<td><?php echo $draw_date['draw_date']; ?></td>
							<td>Dues / Additional</td>
							<td>Rs: <?php echo $t_additional; ?></td>
						</tr>
					</table>
				</div>
				<?php
				
				if($user_meta['user_special_note'] != "") {
				?>
				<div class="card card-body p-0">
				    <h5 class="card-title mt-n1">Special Note:</h5>
				    <p class="text-right"><?php echo $user_meta['user_special_note']; ?></p>
				</div>
				<?php
				}
				
				?>
				<div class="card card-body p-0">
					<table class="table table-striped table-hover table-sm">
						<thead class="thead-dark">
							<tr>
								<th>Receiving Date</th>
								<th>Installment#</th>
								<th>Paid Amount</th>
								<th>Additional / Remaining</th>
								<th>Collector</th>
								<th>Invoice Number</th>
							</tr>
						</thead>
						<tbody>
							<?php

							if($transaction_total > 0) {
								while($transaction_result = mysqli_fetch_assoc($transaction_query)) {
									$collect_person = $transaction_result['collect_person'];
									$collector_query = mysqli_query($conn, "SELECT meta_value FROM user_meta WHERE user_id='$collect_person' && meta_key='user_name'");
									if(mysqli_num_rows($collector_query) > 0) {
										$collector_result = mysqli_fetch_assoc($collector_query);
										$collector = $collector_result['meta_value'];
									} else {
										$collector = '';
									}
									if($transaction_result['dues']<0) {
										$additional = '<span style="color:red;font-weight:bold">'.$transaction_result['dues'].'</span>';
									} elseif($transaction_result['dues']>0) {
										$additional = '<span style="color:green;font-weight:bold">+'.str_replace('-','+',$transaction_result['dues']).'</span>';
									} else {
										$additional = '<span style="color:black;font-weight:bold">'.$transaction_result['dues'].'</span>';
									}
							?>
							<tr>
								<td><?php echo $transaction_result['payment_date']; ?></td>
								<td><?php echo $transaction_result['installment_num']; ?></td>
								<td><?php echo $transaction_result['payment']; ?></td>
								<td><?php echo $additional; ?></td>
								<td><?php echo $collector; ?></td>
								<td><?php echo $transaction_result['id']; ?></td>
							</tr>
							<?php
								}
							} else {
								echo "<tr><td colspan='6' class='text-center'>No Record Found</td></tr>";
							}

							?>
						</tbody>
					</table>
				</div>
				<div class="card card-body p-0">
					<h5 class="card-title mt-n1">Terms & Conditions</h5>
					<p class="text-right"><?php echo $scheme_meta['scheme_terms_conditions']; ?></p>
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
			$('#print_invoice').on('click', function(){
				window.print();
			});
		});
	</script>
</body>
</html>