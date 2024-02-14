<?php

include "../function.php";

if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$query = mysqli_query($conn, "DELETE FROM media WHERE id='$id' && media_for='6'");
	if($query) {
		echo 1;
	} else {
		echo 0;
	}
}

?>