<?php

include "../function.php";

if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$query = mysqli_query($conn, "DELETE FROM media WHERE for_id='$id' && media_for='4'");
	$image = mysqli_query($conn, "DELETE FROM images WHERE id='$id'");
	if($query && $image) {
		echo 1;
	} else {
		echo 0;
	}
}

?>