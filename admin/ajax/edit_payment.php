<?php

include "../function.php";

$edit_payment_id = mysqli_real_escape_string($conn, $_POST['edit_payment_id']);
$edit_payment_amount = mysqli_real_escape_string($conn, $_POST['edit_payment_amount']);
$dues = 0;
$query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaction WHERE id='$edit_payment_id'"));
$scheme_id = $query['scheme_id'];
$last_pay = $query['payment'];
$last_dues = $query['dues'];
$dues = $edit_payment_amount - $last_pay;
$new_dues = $last_dues + $dues;

$update = mysqli_query($conn, "UPDATE transaction SET payment='$edit_payment_amount', dues='$new_dues' WHERE id='$edit_payment_id'");
if($update) {
	echo 1;
} else {
	echo 0;
}

?>