<?php

include "../include/include.inc.php";

$draw_place = mysqli_real_escape_string($conn, $_POST['draw_place']);
$scheme_title = mysqli_real_escape_string($conn, $_POST['scheme_title']);
$draws = mysqli_real_escape_string($conn, $_POST['draws']);
$installment = mysqli_real_escape_string($conn, $_POST['installment']);
$return_installment = mysqli_real_escape_string($conn, $_POST['return_installment']);
$return_deduction = mysqli_real_escape_string($conn, $_POST['return_deduction']);
$date_time = mysqli_real_escape_string($conn, $_POST['date_time']);
$short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
$long_description = mysqli_real_escape_string($conn, $_POST['long_description']);
$terms_conditons = mysqli_real_escape_string($conn, $_POST['terms_conditons']);
echo "<pre>";
print_r($_FILES['scheme_image']);

?>