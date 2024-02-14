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
					<h5 class="card-title float-left">Manage Gifts</h5>
					<a href="" class="btn btn-dark float-right">Add New</a>
				</div>
				<div class="card-body">
					<div class="card card-body mb-3 p-2">
						<div class="row mb-3">
							<div class="col-md-6">
								<span>Sort by: </span>
								<select class="custom-select" style="width: 10rem;">
									<option>Name</option>
								</select>
								<select class="custom-select" style="width: 10rem;">
									<option>Assending</option>
								</select>
								<select class="custom-select" style="width: 5rem;">
									<option>25</option>
									<option>50</option>
									<option>100</option>
									<option>All</option>
								</select>
							</div>
							<div class="col-md-6 text-right">
								<p>Showing 1 - 19 of 19</p>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<ul class="nav nav-dark nav-sm bg-dark">
									<li class="nav-item"><a href="" class="nav-link text-white">All</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">0-9</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">A</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">B</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">C</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">D</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">E</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">F</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">G</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">H</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">I</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">J</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">K</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">L</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">M</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">N</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">O</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">P</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">Q</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">R</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">S</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">T</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">U</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">V</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">W</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">X</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">Y</a></li>
									<li class="nav-item"><a href="" class="nav-link text-white">Z</a></li>
								</ul>
							</div>
						</div>
					</div>
					<table class="mb-3 table table-sm table-striped table-hover table-responsive-md">
						<thead class="thead-dark">
							<tr>
								<td>#</td>
								<td>Prize Name</td>
								<td>Prize Type</td>
								<td>Prize For</td>
								<td>Options</td>
							</tr>
						</thead>
						<tfoot class="thead-dark">
							<tr>
								<td>#</td>
								<td>Prize Name</td>
								<td>Prize Type</td>
								<td>Prize For</td>
								<td>Options</td>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<td>1</td>
								<td>Prize name goes here...</td>
								<td>Bumper Prize</td>
								<td>User</td>
								<td>
									<a href="" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
									<a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
								</td>
							</tr>
						</tbody>
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
</body>
</html>