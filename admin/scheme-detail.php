<?php

include "function.php";
if(isset($_GET['scheme_id'])) {
	$scheme_id = mysqli_real_escape_string($conn, $_GET['scheme_id']);
	$printUrl = 'print-scheme-users.php?scheme_id='.$scheme_id;
} else {
    if(isset($_GET['status']) && isset($_GET['scheme_id'])) {
        $status = $_GET['status'];
    } else if(isset($_GET['status']) && !isset($_GET['scheme_id'])) {
        $status = $_GET['status'];
        header("location:select-scheme.php?status=".$status);
    } else {
        header('location:index.php');
    }
    $printUrl = 'print-scheme-users.php?scheme_id='.$scheme_id.'&status='.$status;
}
if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$draw_query = mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$scheme_id'");
$draw_total = mysqli_num_rows($draw_query);
$next_draw = $draw_total + 1;
if(isset($_GET['status']) && isset($_GET['scheme_id'])) {
    $scheme_id = $_GET['scheme_id'];
    $status = $_GET['status'];
    if($status == "paid") {
		// Checking the user is already paid or not
		$query = "SELECT u.id, u.user_phone FROM users u INNER JOIN transaction t ON u.id=t.user_id WHERE t.installment_num='$next_draw' && u.role='2' && u.active_status='1' && u.delete_status='0'";
        $run = mysqli_query($conn, $query);
        $total = mysqli_num_rows($run);
    } else if($status == "nonpaid") {
		// Checking the user is already paid or not
		$month = date("m-Y", time());
		$query = "SELECT DISTINCT u.id, u.user_phone FROM users u LEFT JOIN transaction t ON u.id=t.user_id && t.month='$next_draw' WHERE t.id IS NULL && u.role='2' && u.active_status='1' && u.delete_status='0'";
        $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $total = mysqli_num_rows($run);
    } else if($status == 'zero_transaction') {
        $query = "SELECT u.id, u.user_phone FROM users u INNER JOIN transaction t ON u.id=t.user_id WHERE t.installment_num='$next_draw' && t.payment='0' && u.role='2' && u.active_status='1' && u.delete_status='0'";
        $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $total = mysqli_num_rows($run);
    }
} else {
    $query = "SELECT * FROM users WHERE scheme_id='$scheme_id' && active_status='1' && delete_status='0' && role='2'";
    $conn->set_charset('utf8');
    $run = mysqli_query($conn, $query);
    $total = mysqli_num_rows($run);
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
			<div class="card">
				<div class="card-header bg-dark text-white">
					<h5 class="card-title d-inline">Scheme Detail</h5>
					<a href='schemes.php' class='btn btn-dark float-right'>Back</a>
				</div>
				<div class="card-body">
					<div class='card card-body mb-3 p-0'><a href='<?php echo $printUrl; ?>' target='_blank' class='btn btn-success'>Print User List</a></div>
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Membership</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Total Payment</th>
								<th>Total Dues</th>
								<th>Option</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Membership</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Total Payment</th>
								<th>Total Dues</th>
								<th>Option</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							if($total > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($run)) {
									$id = $result['id'];
									$check_draw = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE user_id='$id'"));
									$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
									if(mysqli_num_rows($meta_query) > 0) {
										while($meta_result = mysqli_fetch_assoc($meta_query)) {
											$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
										}
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
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $meta['user_shipno']; ?></td>
								<td><a href="tel:<?php echo $result['user_phone']; ?>"><?php echo $meta['user_name']; ?></a></td>
								<td><a href="tel:<?php echo $result['user_phone']; ?>"><?php echo $result['user_phone']; ?></a></td>
								<td><b class="text-danger">Rs: <?php echo $total_amount; ?></b></td>
								<td><b>Rs: <?php echo $additional; ?></b></td>
								<td>
									<div class="btn-group">
										<?php
										
										if(isset($_GET['status']) && $status != "paid") {
    										echo "<button data-payid='".$id."' class='btn btn-success add_payment_btn btn-sm'>Add Payment</button>";
										}
										if(!isset($_GET['status'])) {
										    $transaction_check = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$id' && month='$next_draw'"));
    								        if($transaction_check == 0) {
    								            if($check_draw == 1) {
    								                echo "<button data-payid='".$id."' class='btn btn-secondary add_payment_btn btn-sm'>Already Winner</button>";
    								            } else {
    								                echo "<button data-payid='".$id."' class='btn btn-success add_payment_btn btn-sm'>Add Payment</button>";
    								            }
    								        } else {
    								            echo "<button data-payid='".$id."' class='btn btn-warning add_payment_btn btn-sm'>Already Paid&nbsp;</button>";
    								        }
										}
    									?>
										<button data-payviewid="<?php echo $id; ?>" class="btn btn-danger view_payment_btn btn-sm">View Payment</button>
									</div>
								</td>
							</tr>
							<?php
									$i++;
								}
							} else {
								echo "<tr><td class='text-center' colspan='6'>No Record Found</td></tr>";
							}

							?>
						</tbody>
					</table>
				</div>
			</div>
			<div id="modal" class="modal">
				<div id="modal-dialog" class="modal-dialog modal-dialog-scrollable modal-xl"></div>
			</div>
		</div>
	</section>
	<!-- Main End -->
	<!-- Footer Start -->
	<?php include "footer.php"; ?>
	<!-- Footer End -->
	<?php include "js.php"; ?>
	<script type="text/javascript">
		$(document).ready(function(){
    		$(document).on('submit', '.add_payment_form', function(e){
    			e.preventDefault();
    			$.ajax({
    				url: 'ajax/add_payment.php',
    				type: 'POST',
    				data: $(this).serialize(),
    				beforeSend: function() {
    				    $('#add_payment_form_msg').html("<div class='alert alert-success'>Please Wait...</div>");
    				    $('#submit_payment_btn').attr("disabled", true);
    				},
    				success: function(result) {
    					if(result == 2) {
    						$('#add_payment_form_msg').html("<div class='alert alert-success'><a class='close' href='#' data-dismiss='alert'>&times;</a>Payment is Successfull Added</div>");
    				        $('#submit_payment_btn').attr("disabled", true);
    				        setTimeout(function(){
    				            $('#modal').hide('slow');
    				        }, 1000);
    					} else if(result == 1) {
    						$('#add_payment_form_msg').html("<div class='alert alert-danger'><a class='close' href='#' data-dismiss='alert'>&times;</a>Payment is Not Added Please Try Again</div>");
    						$('#submit_payment_btn').attr("disabled", false);
    					} else if(result == 0) {
    						$('#add_payment_form_msg').html("<div class='alert alert-danger'><a class='close' href='#' data-dismiss='alert'>&times;</a>Please Fill All Fields</div>");
    						$('#submit_payment_btn').attr("disabled", false);
    					}
    				}
    			});
    		});
			$(document).on('click', '.close', function(e){
			    e.preventDefault();
				if($(this).data('dismiss') == 'modal') {
					$("#modal").hide('slow');
				}
			});
			$(document).on('click', '.add_payment_btn', function(){
				$("#modal").show('slow');
				$("#modal-dialog").html("");
				var payment_id = $(this).data('payid');
				$.ajax({
					url: 'ajax/display_add_payment.php',
					type: 'POST',
					data: {id:payment_id},
					success: function(result) {
						$('#modal-dialog').html(result);
					}
				});
			});
			$(document).on('click', '.view_payment_btn', function(){
				$("#modal").show('slow');
				var payViewId = $(this).data('payviewid');
				$.ajax({
					url: 'ajax/display_view_payment.php',
					type: 'POST',
					data: {id:payViewId},
					success: function(result) {
						$('#modal-dialog').html(result);
					}
				});
			});
		});
	</script>
</body>
</html>