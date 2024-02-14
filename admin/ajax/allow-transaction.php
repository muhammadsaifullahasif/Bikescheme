<?php

include "../function.php";

if(isset($_POST['id'])) {
	$id = $_POST['id'];
	$query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT meta_value FROM user_meta WHERE user_id='$id' && meta_key='user_allow_transaction'"));
	if($query['meta_value'] == 'no') {
		$update = mysqli_query($conn, "UPDATE user_meta SET meta_value='yes' WHERE user_id='$id' && meta_key='user_allow_transaction'");
	} else {
		$update = mysqli_query($conn, "UPDATE user_meta SET meta_value='no' WHERE user_id='$id' && meta_key='user_allow_transaction'");
	}
	if($update) {
		echo 1;
	} else {
		echo 0;
	}
}

?>