<?php

session_start();
if(isset($_SESSION['bikescheme_agent_user_login'])) {
	$user_login = $_SESSION['bikescheme_agent_user_login'];
} else {
	header('location:../login.php');
}

$mainURL = 'http://localhost:8080/bikescheme/';
$url = 'http://localhost:8080/bikescheme/agent/';

$query = mysqli_query($conn, "SELECT * FROM users WHERE user_login='$user_login'");
if(mysqli_num_rows($query) > 0) {
	$result = mysqli_fetch_assoc($query);
	$agent_id = $result['id'];
	$user_scheme_id = $result['scheme_id'];
	$agent_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$agent_id'");
	if(mysqli_num_rows($agent_meta_query) > 0) {
		while($agent_meta_result = mysqli_fetch_assoc($agent_meta_query)) {
			$agent_meta[$agent_meta_result['meta_key']] = $agent_meta_result['meta_value'];
		}
	}
}

$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$agent_id'"));

$totalScheme = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM scheme"));

$scheme_group_limit_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT meta_value FROM scheme_meta WHERE scheme_id='$user_scheme_id' && meta_key='scheme_group'"));
$scheme_group_limit = $scheme_group_limit_query['meta_value'];

function today_payment($conn, $agent_id) {
	$today_date = date('d-m-Y');
	$user = mysqli_query($conn, "SELECT * FROM transaction WHERE collect_person='$agent_id' && date_format(date_created, '%d-%m-%Y')='$today_date'");
	$payment = 0;
	if(mysqli_num_rows($user) > 0) {
		while($result = mysqli_fetch_assoc($user)) {
			$payment = $payment + $result['payment'];
		}
	}
	return $payment;
}

function total_payment($conn, $agent_id) {
    $user = mysqli_query($conn, "SELECT * FROM transaction WHERE collect_person='$agent_id'");
    $payment = 0;
	if(mysqli_num_rows($user) > 0) {
		while($result = mysqli_fetch_assoc($user)) {
			$payment = $payment + $result['payment'];
		}
	}
	return $payment;
}

function monthly_payment($conn, $agent_id, $next_draw) {
    $user = mysqli_query($conn, "SELECT * FROM transaction WHERE collect_person='$agent_id' && installment_num='$next_draw'");
    $payment = 0;
	if(mysqli_num_rows($user) > 0) {
		while($result = mysqli_fetch_assoc($user)) {
			$payment = $payment + $result['payment'];
		}
	}
	return $payment;
}

function total_dues($conn, $agent_id) {
    $monthly_installment_query = mysqli_query($conn, "SELECT meta_value FROM scheme_meta WHERE scheme_id='1' && meta_key='installment_per_month'");
    $monthly_installment_result = mysqli_fetch_assoc($monthly_installment_query);
    $monthly_installment = $monthly_installment_result['meta_value'];
    $total_draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='1'"));
    $total_paid_amount = 0;
    $remove_winner_amount = 0;
    $total_winners = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE agent_id='$agent_id' && enroll_status='0' && role='2'"));
    
    $per_month = $monthly_installment;
    for($i = 0; $i < $total_winners; $i++) {
        $remove_winner_amount += $per_month;
        $per_month += $monthly_installment;
    }
    
    $users_query = mysqli_query($conn, "SELECT * FROM users WHERE active_status='1' && role='2' && agent_id='$agent_id'");
    if(mysqli_num_rows($users_query) > 0) {
        while($users_result = mysqli_fetch_assoc($users_query)) {
            $user_id = $users_result['id'];
            $total_paid_amount_query = mysqli_query($conn, "SELECT payment FROM transaction WHERE user_id='$user_id' && collect_person='$agent_id'");
            if(mysqli_num_rows($total_paid_amount_query) > 0) {
                while($total_paid_amount_result = mysqli_fetch_assoc($total_paid_amount_query)) {
                    $total_paid_amount = $total_paid_amount + $total_paid_amount_result['payment'];
                }
            }
        }
    }
    echo $total_paid_amount - (((mysqli_num_rows($users_query) * $monthly_installment) * $total_draws) - $remove_winner_amount);
}

function monthly_dues($conn, $agent_id, $next_draw) {
    
    $monthly_installment_query = mysqli_query($conn, "SELECT meta_value FROM scheme_meta WHERE scheme_id='1' && meta_key='installment_per_month'");
    $monthly_installment_result = mysqli_fetch_assoc($monthly_installment_query);
    $monthly_installment = $monthly_installment_result['meta_value'];
    $total_draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='1'"));
    $total_paid_amount = 0;
    
    $users_query = mysqli_query($conn, "SELECT * FROM users WHERE active_status='1' && role='2' && enroll_status='1' && agent_id='$agent_id'");
    if(mysqli_num_rows($users_query) > 0) {
        while($users_result = mysqli_fetch_assoc($users_query)) {
            $user_id = $users_result['id'];
            $total_paid_amount_query = mysqli_query($conn, "SELECT payment FROM transaction WHERE user_id='$user_id' && collect_person='$agent_id' && installment_num='$next_num'");
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

$draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$user_scheme_id'"));
$next_draw = $draws + 1;

?>