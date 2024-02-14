<?php

include "../include/db.inc.php";
include "function.php";
$draws = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$user_scheme_id'"));
$next_draw = $draws + 1;
if(isset($_GET['q'])) {
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    $q_query = mysqli_query($conn, "SELECT user_id FROM user_meta WHERE meta_value='$q' && meta_key='user_shipno'");
    if(mysqli_num_rows($q_query) > 0) {
        $q_result = mysqli_fetch_assoc($q_query);
        $user_id = $q_result['user_id'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' && role='2' && agent_id='$agent_id'");
    }
    $printUrl = 'print-users.php?q='.$q;
} else if(isset($_GET['status'])) {
    $status = $_GET['status'];
    $printUrl = 'print-users.php?status='.$status;
    if($status == 'active') {
        $query = mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$agent_id' && active_status='1' && delete_status='0'");
    } else if($status == 'inactive') {
        $query = mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$agent_id' && active_status='0' && delete_status='0'");
    } else if($status == 'nonpaid') {
        $query = mysqli_query($conn, "SELECT u.id, u.active_status, u.user_phone FROM users u LEFT JOIN transaction t ON u.id=t.user_id && t.month='$next_draw' WHERE t.id IS NULL && u.agent_id='$agent_id' && u.role='2' && u.active_status='1' && u.delete_status='0' && u.enroll_status='1'");
    } else if($status == 'paid') {
        $query = mysqli_query($conn, "SELECT u.id, u.active_status, u.user_phone FROM users u INNER JOIN transaction t ON u.id=t.user_id WHERE t.installment_num='$next_draw' && u.role='2' && u.agent_id='$agent_id' && u.active_status='1' && u.delete_status='0' && u.enroll_status='1'");
    } else if($status == 'zero_transaction') {
        $query = mysqli_query($conn, "SELECT u.id, u.user_phone FROM users u INNER JOIN transaction t ON u.id=t.user_id WHERE t.installment_num='$next_draw' && t.payment='0' && u.role='2' && u.active_status='1' && u.delete_status='0' && u.agent_id='$agent_id'");
    }
} else {
    $printUrl = 'print-users.php';
	$query = mysqli_query($conn, "SELECT * FROM users WHERE role='2' && agent_id='$agent_id'");
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
			<div class="card mb-3">
				<div class="card-header bg-dark text-white d-print-none">
					<h5 class="card-title float-left">Manage Users</h5>
					<a href="user-add.php" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<div class='card card-body mb-3'><a href='<?php echo $printUrl; ?>' target="_blank" class='btn btn-success'>Print User List</a></div>
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-lg">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Membership</th>
								<th>Status</th>
								<th>Enroll Date</th>
								<th>Total Payment</th>
								<th>Total Dues</th>
								<th>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Membership</th>
								<th>Status</th>
								<th>Enroll Date</th>
								<th>Total Payment</th>
								<th>Total Dues</th>
								<th>Options</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							if(mysqli_num_rows($query) > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($query)) {
									$id = $result['id'];
									$check_draw = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE user_id='$id'"));
									$user_scheme_id = $result['scheme_id'];
									$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
									if(mysqli_num_rows($meta_query) > 0) {
										while($meta_result = mysqli_fetch_assoc($meta_query)) {
											$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
										}
									}
									$scheme = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, title FROM scheme WHERE id='$user_scheme_id'"));
									
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
								<td><a href="tel:<?php echo $result['user_phone']; ?>"><?php echo $meta['user_name']; ?></a></td>
								<td><?php echo $meta['user_shipno']; ?></td>
								<td><button class="btn btn-sm btn-link activate_user" data-aid="<?php echo $result['id']; ?>"><?php if($result['active_status'] == 1) echo "Active"; else echo "Inactive"; ?></button></td>
								<td><?php echo date("d-m-Y", strtotime($result['date_created'])); ?></td>
								<td><b class="text-danger">Rs: <?php echo $total_amount; ?></b></td>
								<td><b>Rs: <?php echo $additional; ?></b></td>
								<td>
									<div class="btn-group">
										<a href="user-detail.php?id=<?php echo $id; ?>" class="btn btn-success"><i class="fas fa-search"></i></a>
										<a href="user-edit.php?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
										<button data-did="<?php echo $id; ?>" class="btn btn-danger delete-user"><i class="fas fa-trash"></i></button>
										<?php

										if($agent_meta['user_allow_transaction'] == 'yes') {
										    if($result['active_status'] == 1) {
										        $transaction = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaction WHERE user_id='$id' && month='$next_draw'"));
										        if($transaction == 0) {
										            if($check_draw == 1) {
										?>
										<button data-payid="<?php echo $id; ?>" class='btn btn-secondary add_payment_btn btn-sm'>Already Winner</button>
										<?php
										            } else {
										?>
										<button data-payid="<?php echo $id; ?>" class="btn btn-success add_payment_btn btn-sm">Add Payment</button>
										<?php
										            }
										        } else {
										?>
										<button data-payid="<?php echo $id; ?>" class='btn btn-warning add_payment_btn btn-sm'>Already Paid</button>
										<?php
										        }
										    }
										}

										?>
										<button data-payviewid="<?php echo $result['id']; ?>" class="btn btn-info view_payment_btn btn-sm">View Payment / Print Receipt</button>
									</div>
								</td>
							</tr>
							<?php
									$i++;
								}
							} else {
								echo "<tr><td colspan='7' class='text-center'>No Record Found</td><tr>";
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
			$(document).on('click', '.delete-user', function(){
				if(confirm('Are you sure to delete user?')) {
					var did = $(this).data('did');
					$.ajax({
						url: 'ajax/user-delete.php',
						type: 'POST',
						data: {id:did},
						success: function(result) {
							window.location.href = window.location.href;
						}
					});
				}
			});
			$(document).on('click', '.activate_user', function(){
				var activate_user_id = $(this).data('aid');
				$.ajax({
					url: 'ajax/activate-user.php',
					type: 'POST',
					data: {id:activate_user_id},
					success: function(result) {
						if(result == 1)
							window.location.href = window.location.href;
						else
							alert('Please Try Again');
					}
				});
			});
			$(document).on('click', '.close', function(e){
			    e.preventDefault();
				if($(this).data('dismiss') == 'modal') {
				    $('#modal-dialog').html('');
					$("#modal").hide('slow');
				}
			});
			$(document).on('click', '.add_payment_btn', function(){
				$("#modal").show('slow');
				$('#modal-dialog').html('');
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
				$('#modal-dialog').html('');
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