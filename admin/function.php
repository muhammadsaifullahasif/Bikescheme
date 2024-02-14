<?php

include "include/include.inc.php";
session_start();
if(isset($_SESSION['bikescheme_admin_user_login'])) {
	$user_login = $_SESSION['bikescheme_admin_user_login'];
} else {
	header('location:../login.php');
}

$mainURL = 'http://localhost:8080/bikescheme/';
$url = 'http://localhost:8080/bikescheme/admin/';

$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='2'"));

$totalScheme = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM scheme"));

$totalAgents = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='1'"));

function today_payment($conn) {
	$today_date = date('Y-m-d');
	$user = mysqli_query($conn, "SELECT * FROM transaction WHERE date_format(date_created, '%Y-%m-%d')='$today_date'");
	$payment = 0;
	if(mysqli_num_rows($user) > 0) {
		while($result = mysqli_fetch_assoc($user)) {
			$payment = $payment + $result['payment'];
		}
	}
	return $payment;
}

function total_payment($conn) {
	$user = mysqli_query($conn, "SELECT * FROM transaction");
	$payment = 0;
	if(mysqli_num_rows($user) > 0) {
		while($result = mysqli_fetch_assoc($user)) {
			$payment = $payment + $result['payment'];
		}
	}
	return $payment;
}

function monthly_payment($conn, $next_draw) {
    $user = mysqli_query($conn, "SELECT payment FROM transaction WHERE installment_num='$next_draw'");
    $payment = 0;
	if(mysqli_num_rows($user) > 0) {
		while($result = mysqli_fetch_assoc($user)) {
			$payment = $payment + $result['payment'];
		}
	}
	return $payment;
}

function total_dues($conn) {
    $monthly_installment_query = mysqli_query($conn, "SELECT meta_value FROM scheme_meta WHERE scheme_id='1' && meta_key='installment_per_month'");
    $monthly_installment_result = mysqli_fetch_assoc($monthly_installment_query);
    $monthly_installment = $monthly_installment_result['meta_value'];
    $total_draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='1'"));
    $total_paid_amount = 0;
    $remove_winner_amount = 0;
    
    $per_month = $monthly_installment;
    for($i = 0; $i < $total_draws; $i++) {
        $remove_winner_amount += $per_month;
        $per_month += $monthly_installment;
    }
    
    $users_query = mysqli_query($conn, "SELECT * FROM users WHERE active_status='1' && role='2'");
    if(mysqli_num_rows($users_query) > 0) {
        while($users_result = mysqli_fetch_assoc($users_query)) {
            $user_id = $users_result['id'];
            $total_paid_amount_query = mysqli_query($conn, "SELECT payment FROM transaction WHERE user_id='$user_id'");
            if(mysqli_num_rows($total_paid_amount_query) > 0) {
                while($total_paid_amount_result = mysqli_fetch_assoc($total_paid_amount_query)) {
                    $total_paid_amount = $total_paid_amount + $total_paid_amount_result['payment'];
                }
            }
        }
    }
    return $total_paid_amount - (((mysqli_num_rows($users_query) * $monthly_installment) * $total_draws) - $remove_winner_amount);
}

function monthly_dues($conn, $next_draw) {
    
    $monthly_installment_query = mysqli_query($conn, "SELECT meta_value FROM scheme_meta WHERE scheme_id='1' && meta_key='installment_per_month'");
    $monthly_installment_result = mysqli_fetch_assoc($monthly_installment_query);
    $monthly_installment = $monthly_installment_result['meta_value'];
    $total_draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='1'"));
    $total_paid_amount = 0;
    
    $users_query = mysqli_query($conn, "SELECT * FROM users WHERE active_status='1' && role='2' && enroll_status='1'");
    if(mysqli_num_rows($users_query) > 0) {
        while($users_result = mysqli_fetch_assoc($users_query)) {
            $user_id = $users_result['id'];
            $total_paid_amount_query = mysqli_query($conn, "SELECT payment FROM transaction WHERE user_id='$user_id' && installment_num='$next_draw'");
            if(mysqli_num_rows($total_paid_amount_query) > 0) {
                while($total_paid_amount_result = mysqli_fetch_assoc($total_paid_amount_query)) {
                    $total_paid_amount = $total_paid_amount + $total_paid_amount_result['payment'];
                }
            }
        }
    }
    echo $total_paid_amount - (mysqli_num_rows($users_query) * $monthly_installment);
    
}

function member_ship_no($conn, $agent_id) {
	$query = mysqli_query($conn, "SELECT a.id, m.meta_value FROM users a INNER JOIN user_meta m ON a.id=m.user_id WHERE a.role='1' && a.id='$agent_id' && m.meta_key='user_serial_prefix'");
	$result = mysqli_fetch_assoc($query);
	$prefix = $result['meta_value'];
	$user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$agent_id'"));
	$i = ($user + 1);
	$total_ = 3;
	$strlen = 0;
	$strlen = strlen($i);
	$limt = 0;
	$limt = ($total_ - $strlen);
	$newid = ''; 
	for($k=0;$k<$limt;$k++)
		$newid = ($newid."0");
	$shipno = $prefix.'-'.$newid.$i;
	return $shipno;
}

$draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw"));
$next_draw = $draws + 1;

?>