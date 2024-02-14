<?php

include "../../include/db.inc.php";
include "../function.php";


if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$output = '';
    $user_member_ship = mysqli_fetch_assoc(mysqli_query($conn, "SELECT meta_value FROM user_meta WHERE meta_key='user_shipno' && user_id='$id'"));
	$output .= "<div class='modal-content'><div class='modal-header'><h5 class='modal-title'>".$user_member_ship['meta_value']."</h5><button type='button' class='close' data-dismiss='modal'>&times;</button></div><div class='modal-body'>";
	// Getting the user detail
	$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$id' && agent_id='$agent_id' && active_status='1' && delete_status='0' && enroll_status='1'");
	if(mysqli_num_rows($user_query) > 0) {
		$user_result = mysqli_fetch_assoc($user_query);
		$scheme_id = $user_result['scheme_id'];

		// Getting the user meta
		$user_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
		if(mysqli_num_rows($user_meta_query) > 0) {
			while($user_meta_result = mysqli_fetch_assoc($user_meta_query)) {
				$user_meta[$user_meta_result['meta_key']] = $user_meta_result['meta_value'];
			}
		}
		$user_name = $user_meta['user_name'];
		$user_cnic = $user_meta['user_cnic'];
		$user_phone = $user_result['user_phone'];
		
		// Getting the scheme detail
		$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE id='$scheme_id' && active_status='1' && delete_status='0'");
		if(mysqli_num_rows($scheme_query) > 0) {
			$scheme_result = mysqli_fetch_assoc($scheme_query);
			// Getting the scheme meta
			$scheme_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$scheme_id'");
			if(mysqli_num_rows($scheme_meta_query) > 0) {
				while($scheme_meta_result = mysqli_fetch_assoc($scheme_meta_query)) {
					$scheme_meta[$scheme_meta_result['meta_key']] = $scheme_meta_result['meta_value'];
				}
			}
		}
		$draw_date = $scheme_meta['draw_date_time'];

		// Getting draw detail
		$draw_query = mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$scheme_id'");
		$draw_total = mysqli_num_rows($draw_query);
		$next_draw = $draw_total + 1;

		if($draw_total < $scheme_meta['no_of_draws']) {
			// Checking the user is already paid or not
			$trans_query = mysqli_query($conn, "SELECT * FROM transaction WHERE month='$next_draw' && user_id='$id'");
			$trans_total = mysqli_num_rows($trans_query);
			if($trans_total == 0) {
				// Getting the last dues of the user
				$trans_dues_query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$id' && scheme_id='$scheme_id' && month='$draw_total'");
				if(mysqli_num_rows($trans_dues_query) > 0) {
					$trans_dues_result = mysqli_fetch_assoc($trans_dues_query);
					$last_dues = $trans_dues_result['dues'];
					if($last_dues > 0) {
						if($last_dues >= $scheme_meta['installment_per_month']) {
							$payment_date = date('d-m-Y');
							$payment_amount = $scheme_meta['installment_per_month'];
							$new_dues = $last_dues - $payment_amount;
							$collect_person = $trans_dues_result['collect_person'];
							$time_created = time();
							// Settle Payment with last dues
							$query = mysqli_query($conn, "INSERT INTO transaction(user_id, user_name, user_phone, user_cnic, scheme_id, installment_num, draw_date, payment_date, payment, dues, collect_person, month, time_created) VALUES('$id', '$user_name', '$user_phone', '$user_cnic', '$scheme_id', '$next_draw', '$draw_date', '$payment_date', '0', '$new_dues', '$collect_person', '$next_draw', '$time_created')");
							if($query) {
								echo "<div class='alert alert-success'>Installment Paid with last dues</div>";
								die();
							} else {
								echo "<div class='alert alert-danger'>Dues of the user is over but not paid please try again</div>";
								die();
							}
						}
					}
				}
				// Showing the pament form
				$output .= "<form class='form add_payment_form' id='add_payment_form'><div id='add_payment_form_msg'></div>";
				$output .= "<input type='hidden' name='add_payment_user_id' id='add_payment_user_id' value='".$id."'>";
				$output .= "<input type='hidden' name='add_payment_scheme_id' id='add_payment_scheme_id' value='".$scheme_id."'>";
				$output .= "<input type='hidden' name='add_payment_next_draw' id='add_payment_next_draw' value='".$next_draw."'>";
				$output .= "<input type='hidden' name='add_payment_collector' id='add_payment_collector' value='".$agent_id."'>";
				$output .= "<div class='form-group input-group'>";
				$output .= "<input type='number' placeholder='Enter Amount' class='form-control form-control-lg' id='add_payment_amount' name='add_payment_amount'>";
				$output .= "<div class='input-group-append'>";
				$output .= "<button class='btn btn-primary btn-lg' id='zero_payment' type='button'>0</button>";
				$output .= "</div>";
				$output .= "</div>";
				$output .= "<div class='form-group'><input type='text' class='form-control' placeholder='Enter Date' id='add_payment_date' name='add_payment_date'></div>";
				$output .= "<button class='btn btn-primary' id='submit_payment_btn' name='submit_payment_btn' type='submit'>Submit</button></form>";
			} else {
				$output .= "<div class='alert alert-danger' style='font-size: 25px;'>Installment Already Paid</div>";
			}
		} else {
			$output .= "<div class='alert alert-danger'>Draws of the Scheme is Completed</div>";
		}
	}
	$output .= "</div>";
	$output .= "</div>";
	echo $output;
?>
<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>
<?php
}

?>