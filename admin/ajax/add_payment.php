<?php

include "../function.php";

$user_id = mysqli_real_escape_string($conn, $_POST['add_payment_user_id']);
$scheme_id = mysqli_real_escape_string($conn, $_POST['add_payment_scheme_id']);
$next_draw = mysqli_real_escape_string($conn, $_POST['add_payment_next_draw']);
$last_draw = $next_draw - 1;
$pay_amount = mysqli_real_escape_string($conn, $_POST['add_payment_amount']);
$collect_person = mysqli_real_escape_string($conn, $_POST['add_payment_collector']);
$pay_date = mysqli_real_escape_string($conn, $_POST['add_payment_date']);
if($_POST['add_payment_date'] == '') {
	$payment_date = date('d-m-Y');
} else {
	$payment_date = mysqli_real_escape_string($conn, $_POST['add_payment_date']);
}
$time_created = time();
$last_dues = 0;


// Getting Collector Detail
$collector_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT meta_value FROM user_meta WHERE user_id='$collect_person' && meta_key='user_name'"));


// Getting Scheme Detail
$scheme_meta_query = "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$scheme_id'";
$conn->set_charset('utf8');
$scheme_meta_run = mysqli_query($conn, $scheme_meta_query);
if(mysqli_num_rows($scheme_meta_run) > 0) {
	while($scheme_meta_result = mysqli_fetch_assoc($scheme_meta_run)) {
		$scheme_meta[$scheme_meta_result['meta_key']] = $scheme_meta_result['meta_value'];
	}
}
$installment_per_month = $scheme_meta['installment_per_month'];
$draw_date = $scheme_meta['draw_date_time'];

// Getting Draws
$draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$scheme_id'"));

$total_previous_amount = 0;
// Geting Transactions
$total_trans = 0;
$total_trans_query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$user_id' && scheme_id='$scheme_id'");
if(mysqli_num_rows($total_trans_query) == 0) {
    $total_previous_amount = -($draws * $installment_per_month);
} else {
    while($total_trans_result = mysqli_fetch_assoc($total_trans_query)) {
        $total_previous_amount = $total_previous_amount + $total_trans_result['payment'];
    }
}

// Getting the last dues
$trans_query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$user_id' && scheme_id='$scheme_id' && installment_num='$last_draw'");
if(mysqli_num_rows($trans_query) > 0) {
	$trans_result = mysqli_fetch_assoc($trans_query);
	$last_dues = $trans_result['dues'];
}

// Getting the user detail
$user = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
if(mysqli_num_rows($user) > 0) {
	$user_result = mysqli_fetch_assoc($user);
	$user_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$user_id'");
	if(mysqli_num_rows($user_meta_query) > 0) {
		while($user_meta_result = mysqli_fetch_assoc($user_meta_query)) {
			$user_meta[$user_meta_result['meta_key']] = $user_meta_result['meta_value'];
		}
	}
}
$transaction_user_name = $user_meta['user_name'];

$paid_total_amount = 0;
$paid_total_amount_query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$user_id' && scheme_id='$scheme_id'");
if(mysqli_num_rows($paid_total_amount_query) > 0) {
    while($paid_total_amount_result = mysqli_fetch_assoc($paid_total_amount_query)) {
        $paid_total_amount = $paid_total_amount + $paid_total_amount_result['payment'];
    }
}

$paid_total_amount = $paid_total_amount + $pay_amount;

$total_paid_amount = 0;
$total_paid_amount = (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$scheme_id'")) * $installment_per_month) + $installment_per_month;

$new_dues = $paid_total_amount - $total_paid_amount;



if($new_dues < 0) {
	$additional = '<span style="color:red;font-weight:bold">'.$new_dues.'</span>';
} elseif($new_dues>0) {
	$additional = '<span style="color:green;font-weight:bold">+'.str_replace('-','+',$new_dues).'</span>';
} else {
	$additional = '<span style="color:black;font-weight:bold">'.$new_dues.'</span>';
}

if($pay_amount != '') {
	// Inserting Transaction
	$query = mysqli_query($conn, "INSERT INTO transaction(user_id, user_name, scheme_id, installment_num, draw_date, payment_date, payment, dues, collect_person, month, time_created) VALUES('$user_id', '$transaction_user_name', '$scheme_id', '$next_draw', '$draw_date', '$payment_date', '$pay_amount', '$new_dues', '$collect_person', '$next_draw', '$time_created')");
	if($query) {
		if($user_result['user_email'] != '') {
			$email_to = $user_result['user_email'];
			$subject = 'Payment Receipt';
			$headers = 'From: Billing-Bikescheme <billing@bikescheme.towaqal.com>\r\n';
			$headers .= 'MIME-Version: 1.0\r\n';
			$headers .= 'Content-Type: text/html; charset=ISO-8859-1\r\n';
			$message = '
						<style>
							.table {
								width: 100%;
								margin-bottom: 1rem;
								color: #212529;
							}
							.table th,
							.table td {
								padding: 0.75rem;
								vertical-align: top;
								border-top: 1px solid #dee2e6;
							}

							.table thead th {
								vertical-align: bottom;
								border-bottom: 2px solid #dee2e6;
							}

							.table tbody + tbody {
								border-top: 2px solid #dee2e6;
							}

							.table-sm th,
							.table-sm td {
								padding: 0.3rem;
							}
							.table-striped tbody tr:nth-of-type(odd) {
								background-color: rgba(0, 0, 0, 0.05);
							}

							.table-hover tbody tr:hover {
								color: #212529;
								background-color: rgba(0, 0, 0, 0.075);
							}
							.table .thead-dark th {
								color: #fff;
								background-color: #343a40;
								border-color: #454d55;
							}
							@media (max-width: 767.98px) {
								.table-responsive-md {
									display: block;
									width: 100%;
									overflow-x: auto;
							    	-webkit-overflow-scrolling: touch;
								}
							}
						</style>
						<table class="table table-striped table-hover table-sm">
							<tr>
								<td>Scheme:</td>
								<td>Bikescheme</td>
								<td>User Membership:</td>
								<td>'.$user_meta['user_shipno'].'</td>
							</tr>
							<tr>
								<td>Name:</td>
								<td>'.$user_meta['user_name'].'</td>
								<td>CNIC:</td>
								<td>'.$user_meta['user_cnic'].'</td>
							</tr>
							<tr>
								<td>Mobile:</td>
								<td>'.$user_result['user_phone'].'</td>
								<td>Email:</td>
								<td>'.$user_result['user_email'].'</td>
							</tr>
							<tr>
								<td>Installment Permonth:</td>
								<td>Rs: '.$scheme_meta['installment_per_month'].'<td>
								<td>Total Installment:</td>
								<td>'.$scheme_meta['no_of_draws'].'</td>
							</tr>
							<tr>
								<td colspan="2">Dues / Additional</td>
								<td colspan="2">Rs: '.$additional.'</td>
							</tr>
						</table>
						<table class="table table-striped table-hover table-sm">
							<thead class="thead-dark">
								<tr>
									<th>Date</th>
									<th>Installment#</th>
									<th>Amount</th>
									<th>Additional / Remaining</th>
									<th>Collector</th>
								</tr>
							</thead>
							<tfoot class="thead-dark">
								<tr>
									<th>Date</th>
									<th>Installment#</th>
									<th>Amount</th>
									<th>Additional / Remaining</th>
									<th>Collector</th>
								</tr>
							</tfoot>
							<tbody>
								<tr>
									<td>'.$payment_date.'</td>
									<td>'.$next_draw.'</td>
									<td>'.$pay_amount.'<td>
									<td>'.$additional.'</td>
									<td>'.$collector_query['meta_value'].'</td>
								</tr>
							</tbody>
						</table>';
			mail($email_to, $subject, $message, $headers);
		}
		echo 2;
	} else {
		echo 1;
	}
} else {
	echo 0;
}

?>