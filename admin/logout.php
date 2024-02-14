<?php

session_start();
unset($_SESSION['bikescheme_admin_user_login']);
header('location:../login.php');

?>