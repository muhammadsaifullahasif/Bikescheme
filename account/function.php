<?php

session_start();
if(isset($_SESSION['bikescheme_user_login'])) {
	$user_login = $_SESSION['bikescheme_user_login'];
} else {
	header('location:../index.php');
}

$url = 'http://localhost:8080/bikescheme/';

include "../include/db.inc.php";

$query = mysqli_query($conn, "SELECT * FROM users WHERE user_login='$user_login'");
if(mysqli_num_rows($query) > 0) {
	$result = mysqli_fetch_assoc($query);
	$user_id = $result['id'];
	$scheme_id = $result['scheme_id'];
	if($result['active_status'] == 0) {
		header('location:logout.php');
		die();
	}
	$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$user_id'");
	if(mysqli_num_rows($meta_query) > 0) {
		while($meta_result = mysqli_fetch_assoc($meta_query)) {
			$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
		}
	}

	$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE id='$scheme_id'");
	if(mysqli_num_rows($scheme_query) > 0) {
		$scheme_result = mysqli_fetch_assoc($scheme_query);
	}

	$media_query = mysqli_query($conn, "SELECT * FROM media WHERE user_id='$user_id' && media_for='2'");
	if(mysqli_num_rows($media_query) > 0) {
		$media = mysqli_fetch_assoc($media_query);
	} else {
		$media['media_path'] = '';
		$media['media_alt'] = 'Profile Image';
	}
}

?>