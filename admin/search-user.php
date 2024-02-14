<?php

include "function.php";

if(isset($_GET['q'])) {
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    $q_query = mysqli_query($conn, "SELECT user_id FROM user_meta WHERE meta_value='$q' && meta_key='user_shipno'");
    if(mysqli_num_rows($q_query) > 0) {
        $q_result = mysqli_fetch_assoc($q_query);
        $user_id = $q_result['user_id'];
        $query = "SELECT * FROM users WHERE id='$user_id' && role='2'";
        $run = mysqli_query($conn, $query);
    }
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
				<div class="card-header bg-dark text-white">
					<h5 class="card-title float-left">Manage Users</h5>
					<a href="user-add.php" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Membership</th>
								<th>CNIC</th>
								<th>Scheme Name</th>
								<th>Status</th>
								<th>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Membership</th>
								<th>CNIC</th>
								<th>Scheme Name</th>
								<th>Status</th>
								<th>Options</th>
							</tr>
						</tfoot>
						<tbody>
							<?php

							if(mysqli_num_rows($run) > 0) {
								$i = 1;
								while($result = mysqli_fetch_assoc($run)) {
									$id = $result['id'];
									$user_scheme_id = $result['scheme_id'];
									$check_draw = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE user_id='$id'"));
									$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
									if(mysqli_num_rows($meta_query) > 0) {
										while($meta_result = mysqli_fetch_assoc($meta_query)) {
											$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
										}
									}
									$scheme = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, title FROM scheme WHERE id='$user_scheme_id'"));
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $meta['user_name']; ?></td>
								<td><?php echo $meta['user_shipno']; ?></td>
								<td><?php echo $meta['user_cnic']; ?></td>
								<td><a href="scheme-detail.php?scheme_id=<?php echo $scheme['id']; ?>"><?php echo $scheme['title']; ?></a></td>
								<td><button class="btn btn-sm btn-link activate_user" data-aid="<?php echo $result['id']; ?>"><?php if($result['active_status'] == 1) echo "Active"; else echo "Inactive"; ?></button></td>
								<td>
									<div class="btn-group">
										<a href="user-detail.php?id=<?php echo $id; ?>" class="btn btn-success"><i class="fas fa-search"></i></a>
										<a href="user-edit.php?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
										<button data-did="<?php echo $id; ?>" class="btn btn-danger delete-user"><i class="fas fa-trash"></i></button>
										<?php
										
										$draw_query = mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$user_scheme_id'");
                                        $draw_total = mysqli_num_rows($draw_query);
                                        $next_draw = $draw_total + 1;

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
										
										?>
                                        
										<button data-payviewid="<?php echo $id; ?>" class="btn btn-info view_payment_btn">View Payment</button>
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
				<div id="modal-dialog"></div>
			</div>
		</div>
	</section>
	<!-- Main End -->
	<!-- Footer Start -->
	<?php include "footer.php"; ?>
	<!-- Footer End -->
	<?php include "js.php"; ?>
	<script src="printArea.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
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












