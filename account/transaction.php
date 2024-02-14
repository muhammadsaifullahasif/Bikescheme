<?php

include "function.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include "head.php"; ?>
</head>
<body>
	<?php include "header.php"; ?>
	<?php include "nav.php"; ?>
	<section class="my-3">
		<div class="container-fluid">
			<ul class="nav bg-dark text-white nav-justified">
				<li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
				<li class="nav-item"><a href="transaction.php" class="nav-link text-white">Transaction</a></li>
				<li class="nav-item"><a href="setting.php" class="nav-link text-white">Setting</a></li>
			</ul>
			<div class="card mt-2 mb-3">
				<div class="card-header bg-dark py-1 text-white">
					<h5 class="card-title mb-0">Payment</h5>
				</div>
				<div class="card-body">
					<table class="table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>Date</th>
								<th>Installment#</th>
								<th>Amount</th>
								<th>Additional / Remaining</th>
								<th>Collector</th>
								<th>Invoice Number</th>
								<th>Receipt</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>Date</th>
								<th>Installment#</th>
								<th>Amount</th>
								<th>Additional / Remaining</th>
								<th>Collector</th>
								<th>Invoice Number</th>
								<th>Receipt</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							$trans_query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$user_id' && scheme_id='$scheme_id'");
							if(mysqli_num_rows($trans_query) > 0) {
								while($trans = mysqli_fetch_assoc($trans_query)) {
									if($trans['dues']<0) {
										$additional = '<span style="color:red;font-weight:bold">'.$trans['dues'].'</span>';
									} elseif($trans['dues']>0) {
										$additional = '<span style="color:green;font-weight:bold">'.str_replace('-','+',$trans['dues']).'</span>';
									} else {
										$additional = '<span style="color:black;font-weight:bold">'.$trans['dues'].'</span>';
									}
									$collect_person = $trans['collect_person'];
									$collect_person_query = mysqli_query($conn, "SELECT meta_value FROM user_meta WHERE meta_key='user_name' && user_id='$collect_person'");
									if(mysqli_num_rows($collect_person_query) > 0) {
										$collect_person_result = mysqli_fetch_assoc($collect_person_query);
										$collector = $collect_person_result['meta_value'];
									} else {
										$collector = '';
									}
							?>
							<tr>
								<td><?php echo $trans['payment_date']; ?></td>
								<td><?php echo $trans['installment_num']; ?></td>
								<td><?php echo $trans['payment']; ?></td>
								<td><?php echo $additional; ?></td>
								<td><?php echo $collector; ?></td>
								<td><?php echo $trans['id']; ?></td>
								<td><a href="invoice.php?id=<?php echo $trans['id']; ?>" class="btn btn-success"><i class="fas fa-receipt"></i></a></td>
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
			</div>
		</div>
	</section>
	<?php include "../footer.php"; ?>
	<?php include "js.php"; ?>
</body>
</html>