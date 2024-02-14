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
					<h5 class="card-title float-left">Manage Scheme</h5>
					<a href="scheme-add.php" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<th>Title</th>
								<th>City</th>
								<th>Installment</th>
								<th>Total Active User</th>
								<th>Amount</th>
								<th>Options</th>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<th>Title</th>
								<th>City</th>
								<th>Installment</th>
								<th>Total Active User</th>
								<th>Amount</th>
								<th>Options</th>
							</tr>
						</tfoot>
						<tbody id="scheme_display"></tbody>
					</table>
				</div>
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
			function scheme_display() {
				$.ajax({
					url: 'ajax/schemes.php',
					type: 'POST',
					success: function(result) {
						$('#scheme_display').html(result);
					}
				});
			}
			scheme_display();
			$(document).on('click', '.delete-scheme', function(){
				if(confirm('Are you sure to delete scheme?')) {
					var did = $(this).data('did');
					$.ajax({
						url: 'ajax/scheme-delete.php',
						type: 'POST',
						data: {id:did},
						success: function(result) {
							if(result == 1) {
								scheme_display();
							} else {
								alert('Please Try Again');
							}
						}
					});
				}
			});
		});
	</script>
</body>
</html>