<?php

include "../function.php";

if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$output = "";
	$output .= "<div class='modal-content'><div class='modal-header'><h5 class='modal-title'>Edit Payment</h5><a href='#' data-dismiss='modal' class='close'>&times;</a></div>";
	$output .= "<div class='mb-2' id='edit_form_msg'></div><form id='edit_form' class='modal-body'><input type='hidden' value='".$id."' id='edit_payment_id' name='edit_payment_id'>";
	$query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaction WHERE id='$id'"));
	$output .= "<div class='form-group'><label>Enter Amount</label><input type='number' id='edit_payment_amount' name='edit_payment_amount' class='form-control' value='".$query['payment']."'></div>";
	$output .= "<button class='btn btn-primary' type='submit' id='edit_payment_btn' name='edit_payment_btn'>Edit</button>";
	$output .= "</form></div>";

	echo $output;
}

?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#edit_payment_btn').on('click', function(e){
			e.preventDefault();
			$.ajax({
				url: 'ajax/edit_payment.php',
				type: 'POST',
				data: $('#edit_form').serialize(),
				beforeSend: function() {
				    $('#edit_form_msg').html("<div class='alert alert-success'>Please Wait...</div>");
				    $('#edit_payment_btn').attr("disabled", true);
				},
				success: function(result) {
					if(result == 0) {
						$('#edit_form_msg').removeClass('alert-success').addClass('alert alert-danger').html("<a class='close' data-dismiss='alert' href='#'>&times;</a>Payment is Not Updated Please Try Again");
					} else {
					    $('#edit_form_msg').removeClass('alert-danger').addClass('alert alert-success').html("<a class='close' data-dismiss='alert' href='#'>&times;</a>Payment is Successfully Updated");
					    $('#edit_payment_btn').attr("disabled", false);
					}
				}
			});
		});
	});
</script>