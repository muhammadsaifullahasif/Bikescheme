<?php

include "../../include/db.inc.php";
include "../function.php";

if(isset($_POST['id'])) {
	$id = $_POST['id'];
	$output = '';
	$totalPay = 0;
	$additional = 0;
    $user_member_ship = mysqli_fetch_assoc(mysqli_query($conn, "SELECT meta_value FROM user_meta WHERE meta_key='user_shipno' && user_id='$id'"));
    $output .= "<div class='modal-content'>";
	$output .= "<div class='modal-header'>";
	$output .= "<h5 class='modal-title'>".$user_member_ship['meta_value']."</h5>";
	$output .= "<a class='close d-print-none' data-dismiss='modal' href='#'>&times;</a>";
	$output .= "</div>";
	$output .= "<div class='modal-body' id='statement'>";
	$output .= "<div class='card card-body mb-2 d-print-none'>";
	$output .= "<button id='print_statement' onclick='printStatement()' class='btn btn-primary'>Print Statement</button></div>";
	$output .= "<table class='table table-sm table-striped table-bordered table-hover table-responsive-md'>";
	$output .= "<thead class='thead-dark'>";
	$output .= "<tr>";
	$output .= "<th>Date</th>";
	$output .= "<th>Installment#</th>";
	$output .= "<th>Amount</th>";
	$output .= "<th>Additional / Remaining</th>";
	$output .= "<th>Collector</th>";
	$output .= "<th>Invoice Number</th>";
	$output .= "<th class='d-print-none'>Action</th>";
	$output .= "</tr>";
	$output .= "</thead>";
	$output .= "<tfoot class='thead-dark'>";
	$output .= "<tr>";
	$output .= "<th>Date</th>";
	$output .= "<th>Installment#</th>";
	$output .= "<th>Amount</th>";
	$output .= "<th>Additional / Remaining</th>";
	$output .= "<th>Collector</th>";
	$output .= "<th>Invoice Number</th>";
	$output .= "<th class='d-print-none'>Action</th>";
	$output .= "</tr>";
	$output .= "</tfoot>";
	$output .= "<tbody>";
	$query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$id'");
	if(mysqli_num_rows($query) > 0) {
		while($result = mysqli_fetch_assoc($query)) {
			$collect_person = $result['collect_person'];
			$collector_query = mysqli_query($conn, "SELECT meta_value FROM user_meta WHERE user_id='$collect_person' && meta_key='user_name'");
			if(mysqli_num_rows($collector_query) > 0) {
				$collector_result = mysqli_fetch_assoc($collector_query);
				$collector = $collector_result['meta_value'];
			} else {
				$collector = '';
			}
			if($result['dues']<0) {
				$additional = '<span style="color:red;font-weight:bold">'.$result['dues'].'</span>';
			} elseif($result['dues']>0) {
				$additional = '<span style="color:green;font-weight:bold">'.str_replace('-','+',$result['dues']).'</span>';
			} else {
				$additional = '<span style="color:black;font-weight:bold">'.$result['dues'].'</span>';
			}
			$output .= "<tr>";
			$output .= "<td>".$result['payment_date']."</td>";
			$output .= "<td>".$result['installment_num']."</td>";
			$output .= "<td>".$result['payment']."</td>";
			$output .= "<td>".$additional."</td>";
			$output .= "<td>".$collector."</td>";
			$output .= "<td>".$result['id']."</td>";
			$output .= "<td class='d-print-none'><div class='btn-group'>";
			$output .= "<a href='invoice.php?id=".$result['id']."' target='_blank' class='btn btn-primary btn-sm'>Print Receipt</a></div></td>";
			$output .= "</tr>";
			$totalPay = $totalPay + $result['payment'];
		}
	} else {
		$output .= "<tr><td colspan='7' class='text-center'>No Record Found</td></tr>";
	}
	$output .= "</tbody></table>";
	$output .= "<p class='text-right'>Total Payment = Rs: ".$totalPay."</p>";
	$output .= "<p class='text-right'>Total Dues = Rs: ".$additional."</p>";
	$output .= "</div>";
	$output .= "</div>";
	echo $output;
}

?>
<script type="text/javascript">
	$(document).ready(function(){
	    $('#print_statement').on('click', function(){
	       var printArea = window = $('#statement');
	       window.print();
	    });
		$(document).on('click', '.payment_edit_btn', function(){
			$('#modal-dialog').hide();
			$('#modal-dialog').show('slow');
			var payeditid = $(this).data('payeditid');
			$.ajax({
				url: 'ajax/display_edit_payment.php',
				type: 'POST',
				data: {id:payeditid},
				success: function(result) {
					$('#modal-dialog').html(result);
				}
			});
		});
	});
</script>