<?php

session_start();
unset($_SESSION['bikescheme_user_login']);
header('location:../index.php');

?>