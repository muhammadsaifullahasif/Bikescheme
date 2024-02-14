<?php

session_start();
unset($_SESSION['bikescheme_agent_user_login']);
header('location:../login.php');

?>