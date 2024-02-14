<?php

include "../../include/db.inc.php";
include "../function.php";

$user_id = mysqli_real_escape_string($conn, $_POST['add_payment_user_id']);
$scheme_id = mysqli_real_escape_string($conn, $_POST['add_payment_scheme_id']);
$next_draw = mysqli_real_escape_string($conn, $_POST['add_payment_next_draw']);
$last_draw = $next_draw - 1;
$pay_amount = mysqli_real_escape_string($conn, $_POST['add_payment_amount']);
$collect_person = mysqli_real_escape_string($conn, $_POST['add_payment_collector']);
if($_POST['add_payment_date'] == '') {
	$payment_date = date('d-m-Y');
} else {
	$payment_date = mysqli_real_escape_string($conn, $_POST['add_payment_date']);
}
$time_created = time();
$last_dues = 0;

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

// Getting Draws
$draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$scheme_id'"));


// Getting the scheme detail
$scheme_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$scheme_id'");
if(mysqli_num_rows($scheme_meta_query) > 0) {
    while($scheme_meta_result = mysqli_fetch_assoc($scheme_meta_query)) {
        $scheme_meta[$scheme_meta_result['meta_key']] = $scheme_meta_result['meta_value'];
    }
}
$installment_per_month = $scheme_meta['installment_per_month'];
$draw_date = $scheme_meta['draw_date_time'];


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

if($pay_amount != '') {
	// Inserting Transaction
	$query = mysqli_query($conn, "INSERT INTO transaction(user_id, user_name, scheme_id, installment_num, draw_date, payment_date, payment, dues, collect_person, month, time_created) VALUES('$user_id', '$transaction_user_name', '$scheme_id', '$next_draw', '$draw_date', '$payment_date', '$pay_amount', '$new_dues', '$collect_person', '$next_draw', '$time_created')");
	if($query) {
		echo 2;
	} else {
		echo 1;
	}
} else {
	echo 0;
}


























/*$user_id = $_POST['user_add_pay_id'];
$user_add_pay_scheme = $_POST['user_add_pay_scheme'];
$add_payment_amount = $_POST['add_payment_amount'];
$add_payment_collector = $_POST['add_payment_collector'];
if(isset($_POST['add_payment_date'])) {
	$payment_date = date('d-m-Y');
} else {
	$payment_date = $_POST['add_payment_date'];
}

// Getting the detail of the scheme
$scheme_query = mysqli_query($conn, "SELECT m.meta_key, m.meta_value FROM scheme s INNER JOIN scheme_meta m ON s.id=m.scheme_id WHERE s.id='$user_add_pay_scheme' && s.active_status='1' && s.delete_status='0'");
if(mysqli_num_rows($scheme_query)) {
	while($scheme_result = mysqli_fetch_assoc($scheme_query)) {
		$scheme_meta[$scheme_result['meta_key']] = $scheme_result['meta_value'];
	}
}

// Getting the total number of the draws
$draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$user_add_pay_scheme'"));
if($draws == $scheme_meta['no_of_draws']) {
	echo 0;
	die();
}
$draws++;

// Getting the detail of the last draw
$last_draw_query = mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$user_add_pay_scheme' ORDER BY time_created DESC LIMIT 1");
if(mysqli_num_rows($last_draw_query) > 0) {
	$last_draw_result = mysqli_fetch_assoc($last_draw_query);
	$last_draw = date($last_draw_result['time_created'], 'n');
} else {
	$last_draw = '1';
}

if($user_id != '' && $add_payment_amount != '' && $user_add_pay_scheme != '') {
	$totalInstallment = $scheme_meta['installment_per_month'];
	$last_dues_query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$user_id' ORDER BY time_created LIMIT 1");
	if(mysqli_num_rows($last_dues_query) > 0) {
		$last_dues_result = mysqli_fetch_assoc($last_dues_query);
		$last_dues = $last_dues_result['dues'];
		// Start From Here
	}
	$dues = $add_payment_amount - $totalInstallment;
	$time_created = time();
	// Inserting new transaction
	$query = mysqli_query($conn, "INSERT INTO transaction(user_id, scheme_id, installment_num, payment_date, payment, dues, collect_person, month, time_created) VALUES('$user_id', '$user_add_pay_scheme', '$draws', '$payment_date', '$add_payment_amount', '$dues', '$add_payment_collector', '$last_draw', '$time_created')");
	if($query) {
		echo 1;
	} else {
		echo 2;
	}
} else {
	echo 3;
}*/

?>
