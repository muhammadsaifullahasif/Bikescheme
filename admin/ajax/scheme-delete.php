<?php

include "../function.php";

if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$query = mysqli_query($conn, "DELETE FROM scheme WHERE id='$id'");
	$meta = mysqli_query($conn, "DELETE FROM scheme_meta WHERE scheme_id='$id'");
	if($query && $meta) {
		echo 1;
	} else {
		echo 0;
	}
}

?>