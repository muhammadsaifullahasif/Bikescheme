<?php

include "../../include/db.inc.php";
include "../function.php";

if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id' && agent_id='$agent_id'"));
	if($query['active_status'] == 1) {
		$update = mysqli_query($conn, "UPDATE users SET active_status='0' WHERE id='$id'");
	} else {
		$update = mysqli_query($conn, "UPDATE users SET active_status='1' WHERE id='$id'");
	}
	if($update) {
		echo 1;
	} else {
		echo 0;
	}
}

?>