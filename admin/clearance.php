<?php

include "function.php";

$time_created = time();

if(isset($_GET['user_id']) && isset($_GET['scheme_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $scheme_id = mysqli_real_escape_string($conn, $_GET['scheme_id']);
} else {
    header('location: users.php');
}

$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
if(mysqli_num_rows($user_query) > 0) {
    $user_result = mysqli_fetch_assoc($user_query);
	$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
	if(mysqli_num_rows($meta_query) > 0) {
		while($meta_result = mysqli_fetch_assoc($meta_query)) {
			$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
		}
	}
	$scheme = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, title FROM scheme WHERE id='$scheme_id'"));
} else {
    header('location: users.php');
}

$total_amount_query = mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$id'");
$total_amount = 0;
if(mysqli_num_rows($total_amount_query) > 0) {
    while($total_amount_result = mysqli_fetch_assoc($total_amount_query)) {
        $total_amount = $total_amount + $total_amount_result['payment'];
    }
}

$scheme_meta_query = mysqli_query($conn, "SELECT * FROM scheme_meta WHERE scheme_id='1'");
if(mysqli_num_rows($scheme_meta_query) > 0) {
    while($scheme_meta_result = mysqli_fetch_assoc($scheme_meta_query)) {
        $scheme_meta[$scheme_meta_result['meta_key']] = $scheme_meta_result['meta_value'];
    }
}

$total_payment = $next_draw * $scheme_meta['installment_per_month'];

$additional = '';
$dues = 0;
    
$dues = $total_amount - $total_payment;
    
if($dues<0) {
	$additional = '<span style="color:red;font-weight:bold">'.$dues.'</span>';
} elseif($dues>0) {
	$additional = '<span style="color:green;font-weight:bold">'.str_replace('-','+',$dues).'</span>';
} else {
	$additional = '<span style="color:black;font-weight:bold">'.$dues.'</span>';
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php include "head.php"; ?>
</head>
<body>
	<!-- Header Start -->
	<?php include "header.php"; ?>
	<!-- Header End -->
	<!-- Navigation Start -->
	<?php include "nav.php"; ?>
	<!-- Navigation End -->
	<!-- Main Start -->
	<section class="mt-3">
		<div class="container-fluid">
			<?php
			
            if(isset($_GET['clearance_method']) && $_GET['clearance_method'] == 'payment') {
            ?>
            <div class="card mb-3">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title">Payment Clearance</h5>
				</div>
				<div class="card-body">
				    <?php
				    
				    if(isset($_POST['payment_clearance'])) {
				        $user_name = $meta['user_name'];
    				    $user_father_name = $meta['user_father_name'];
    				    $user_address = $meta['user_address'];
    				    $user_cnic = mysqli_real_escape_string($conn, $_POST['receiver_cnic']);
    				    $user_phone = mysqli_real_escape_string($conn, $_POST['receiver_phone']);
    				    $cheque_number = mysqli_real_escape_string($conn, $_POST['cheque_number']);
    				    $cheque_for_date = mysqli_real_escape_string($conn, $_POST['cheque_for_date']);
    				    $bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
    				    if($cheque_number != '' && $bank_name != '') {
    				        $payment_type = 2;
    				    } else {
    				        $cheque_number = '';
    				        $bank_name = '';
    				        $cheque_for_date = '';
    				        $payment_type = 1;
    				    }
				        $query = mysqli_query($conn, "INSERT INTO clearance(user_id, user_name, user_father_name, user_address, user_cnic, user_phone, scheme_id, already_paid_amount, extra_paid_amount, total_paid_amount, payment_type, cheque_number, cheque_for_date, bank_name, clearance_type, time_created) VALUES('$id', '$user_name', '$user_father_name', '$user_address', '$user_cnic', '$user_phone', '$scheme_id', '$total_amount', '', '$total_amount', '$payment_type', '$cheque_number', '$cheque_for_date', '$bank_name', '1', '$time_created')");
				        if($query) {
				            echo "<div class='alert alert-success'>Payment is Successfully Clear</div>";
				            echo "<script>window.top.location = window.top.location;</script>";
				        } else {
				            echo "<div class='alert alert-danger'>Please Try Again</div>";
				            echo mysqli_error($conn);
				        }
				    }
				    
				    ?>
					<form class="form" method="post">
					    <?php
                        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM clearance WHERE user_id='$id' && scheme_id='$scheme_id'")) == 0) {
				        ?>
				        <div class="mb-3">
					        <label>Receiver Phone Number:</label>
					        <input type='text' class='form-control' name='receiver_phone' placeholder='Enter Receiver Phone Number' value=''>
					    </div>
					    <div class="mb-3">
					        <label>Receiver CNIC:</label>
					        <input type='text' class='form-control' name='receiver_cnic' placeholder='Enter Receiver CNIC' value=''>
					    </div>
					    <div class="mb-3">
					        <label>Total Paid Amount:</label>
					        <input type='text' class='form-control' readonly name='total_paid_amount' value='<?php echo $total_amount; ?>'>
					    </div>
					    <div class='mb-3'>
					        <label>Cheque Number:</label>
					        <input type='text' class="form-control" name='cheque_number' placeholder="Enter Cheque Number" value=''>
					    </div>
					    <div class='mb-3'>
					        <label>Cheque For Date:</label>
					        <input type='date' class="form-control" name='cheque_for_date' placeholder="Enter Cheque For Date" value=''>
					    </div>
					    <div class='mb-3'>
					        <label>Bank Name:</label>
					        <input type='text' class="form-control" name='bank_name' placeholder="Enter Bank Name" value=''>
					    </div>
					    <?php
                        }
					    ?>
						<div class="row">
						    <?php
                            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM clearance WHERE user_id='$id' && scheme_id='$scheme_id'")) == 0) {
					        ?>
						    <div class="col-6">
                                <button type="submit" name="payment_clearance" class="btn btn-success">Mark As Clear</button>
						    </div>
						    <?php
                            }
					        ?>
						    <?php
                            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM clearance WHERE user_id='$id' && scheme_id='$scheme_id'")) == 1) {
					        ?>
						    <div class="col-6">
						        <a class="btn btn-primary" target="_blank" href="clearance-invoice.php?user_id=<?php echo $id; ?>&scheme_id=<?php echo $scheme_id; ?>">Print Invoice</a>
						    </div>
						    <?php
                            }
					        ?>
						</div>
					</form>
				</div>
			</div>
            <?php
            } else if(isset($_GET['clearance_method']) && $_GET['clearance_method'] == 'motorcycle') {
            ?>
            <div class="card mb-3">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title">Motorcycle Clearance</h5>
				</div>
				<div class="card-body">
				    <?php
				    
				    if(isset($_POST['payment_clearance'])) {
				        $user_name = $meta['user_name'];
    				    $user_father_name = $meta['user_father_name'];
    				    $user_address = $meta['user_address'];
    				    $user_cnic = mysqli_real_escape_string($conn, $_POST['receiver_cnic']);
    				    $user_phone = mysqli_real_escape_string($conn, $_POST['receiver_phone']);
    				    $engine_number = mysqli_real_escape_string($conn, $_POST['engine_number']);
    				    $chassis_number = mysqli_real_escape_string($conn, $_POST['chassis_number']);
    				    $extra_paid_amount = mysqli_real_escape_string($conn, $_POST['extra_paid_amount']);
    				    $total_paid_amount = $total_amount + $extra_paid_amount;
				        $query = mysqli_query($conn, "INSERT INTO clearance(user_id, user_name, user_father_name, user_address, user_cnic, user_phone, scheme_id, already_paid_amount, extra_paid_amount, total_paid_amount, payment_type, cheque_number, bank_name, engine_number, chassis_number, clearance_type, time_created) VALUES('$id', '$user_name', '$user_father_name', '$user_address', '$user_cnic', '$user_phone', '$scheme_id', '$total_amount', '$extra_paid_amount', '$total_paid_amount', '3', '', '', '$engine_number', '$chassis_number', '2', '$time_created')");
				        if($query) {
				            echo "<div class='alert alert-success'>Payment is Successfully Clear</div>";
				            echo "<script>window.top.location = window.top.location;</script>";
				        } else {
				            echo "<div class='alert alert-danger'>Please Try Again</div>";
				            echo mysqli_error($conn);
				        }
				    }
				    
				    ?>
					<form class="form" method="post">
					    <?php
                        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM clearance WHERE user_id='$id' && scheme_id='$scheme_id'")) == 0) {
				        ?>
				        <div class="mb-3">
					        <label>Receiver Phone Number:</label>
					        <input type='text' class='form-control' name='receiver_phone' placeholder='Enter Receiver Phone Number' value=''>
					    </div>
					    <div class="mb-3">
					        <label>Receiver CNIC:</label>
					        <input type='text' class='form-control' name='receiver_cnic' placeholder='Enter Receiver CNIC' value=''>
					    </div>
					    <div class="mb-3">
					        <label>Total Paid Amount:</label>
					        <input type='text' class='form-control' readonly name='total_paid_amount' value='<?php echo $total_amount; ?>'>
					    </div>
					    <div class='mb-3'>
					        <label>Extra Paid Amount:</label>
					        <input type='text' class="form-control" name='extra_paid_amount' placeholder="Enter Extra Paid Amount" value=''>
					    </div>
					    <div class='mb-3'>
					        <label>Engine Number:</label>
					        <input type='text' class="form-control" name='engine_number' placeholder="Enter Engine Number" value=''>
					    </div>
					    <div class='mb-3'>
					        <label>Chassis Number:</label>
					        <input type='text' class="form-control" name='chassis_number' placeholder="Enter Chassis Number" value=''>
					    </div>
					    <?php
                        }
					    ?>
						<div class="row">
						    <?php
                            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM clearance WHERE user_id='$id' && scheme_id='$scheme_id'")) == 0) {
					        ?>
						    <div class="col-6">
                                <button type="submit" name="payment_clearance" class="btn btn-success">Mark As Clear</button>
						    </div>
						    <?php
                            }
					        ?>
						    <?php
                            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM clearance WHERE user_id='$id' && scheme_id='$scheme_id'")) == 1) {
					        ?>
						    <div class="col-6">
						        <a target="_blank" class="btn btn-primary" href="clearance-invoice.php?user_id=<?php echo $id; ?>&scheme_id=<?php echo $scheme_id; ?>">Print Invoice</a>
						    </div>
						    <?php
                            }
					        ?>
						</div>
					</form>
				</div>
			</div>
            <?php
            } else {
            ?>
            <div class="card mb-3">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title">Clearance</h5>
				</div>
				<div class="card-body">
					<form class="form">
					    <table class="table table-striped table-hover">
					        <tr>
					            <td>Membership Number:</td>
					            <td><?php echo $meta['user_shipno']; ?></td>
					        </tr>
					        <tr>
					            <td>Name:</td>
					            <td><?php echo $meta['user_name']; ?></td>
					        </tr>
					        <tr>
					            <td>Phone Number:</td>
					            <td><?php echo $user_result['user_phone']; ?></td>
					        </tr>
					        <tr>
					            <td>Address:</td>
					            <td><?php echo $meta['user_address']; ?></td>
					        </tr>
					        <tr>
					            <td>Total Paid Amount:</td>
					            <td>Rs: <strong><?php echo $total_amount; ?></strong></td>
					        </tr>
					        <tr>
					            <td>Pending Dues:</td>
					            <td>Rs: <strong><?php echo $additional; ?></strong></td>
					        </tr>
					    </table>
						<div class="row">
						    <div class="col-6">
						        <a class="btn btn-success" href="clearance.php?user_id=<?php echo $id; ?>&scheme_id=<?php echo $scheme_id; ?>&clearance_method=payment">Payment Clearance</a>
						    </div>
						    <div class="col-6">
						        <a class="btn btn-success" href="clearance.php?user_id=<?php echo $id; ?>&scheme_id=<?php echo $scheme_id; ?>&clearance_method=motorcycle">Motorcycle Clearance</a>
						    </div>
						</div>
					</form>
				</div>
			</div>
            <?php
            }
			
			?>
		</div>
	</section>
	<!-- Main End -->
	<!-- Footer Start -->
	<?php include "footer.php"; ?>
	<!-- Footer End -->
	<?php include "js.php"; ?>
</body>
</html>




















