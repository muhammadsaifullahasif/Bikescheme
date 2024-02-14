<?php

include "../include/include.inc.php";
session_start();

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if($username != '' && $password != '') {
	$query = mysqli_query($conn, "SELECT * FROM users WHERE user_login='$username'");
	if(mysqli_num_rows($query) > 0) {
		$result = mysqli_fetch_assoc($query);
		if(password_verify($password, $result['user_pass'])) {
			if($result['active_status'] == 1) {
				if($result['role'] == 0) {
					$_SESSION['bikescheme_admin_user_login'] = $username;
					echo 6;
				} else if($result['role'] == 1) {
					$_SESSION['bikescheme_agent_user_login'] = $username;
					echo 5;
				} else if($result['role'] == 2) {
					$_SESSION['bikescheme_user_login'] = $username;
					echo 4;
				}
			} else {
				echo 3;
			}
		} else {
			echo 2;
		}
	} else {
		echo 1;
	}
} else {
	echo 0;
}

?>