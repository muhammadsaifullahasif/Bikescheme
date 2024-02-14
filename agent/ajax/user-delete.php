<?php

include "../../include/db.inc.php";
include '../function.php';

if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$query = mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
	$meta = mysqli_query($conn, "DELETE FROM user_meta WHERE user_id='$id'");
	$media = mysqli_query($conn, "DELETE FROM media WHERE user_id='$id' && media_for='2'");
	if($query && $meta && $media) {
		echo 1;
	} else {
		echo 0;
	}
} else {
	header("location:users.php");
}

?>