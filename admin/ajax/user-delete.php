<?php

include '../function.php';

if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$query = mysqli_query($conn, "UPDATE users SET delete_status='1' WHERE id='$id'");
	if($query) {
		echo 1;
	} else {
		echo 0;
	}
} else {
	header("location:users.php");
}

?>