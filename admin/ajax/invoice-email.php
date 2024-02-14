<?php

$invoice = '
			<style>
				.table {
					width: 100%;
					margin-bottom: 1rem;
					color: #212529;
				}
				.table th,
				.table td {
					padding: 0.75rem;
					vertical-align: top;
					border-top: 1px solid #dee2e6;
				}

				.table thead th {
					vertical-align: bottom;
					border-bottom: 2px solid #dee2e6;
				}

				.table tbody + tbody {
					border-top: 2px solid #dee2e6;
				}

				.table-sm th,
				.table-sm td {
					padding: 0.3rem;
				}
				.table-striped tbody tr:nth-of-type(odd) {
					background-color: rgba(0, 0, 0, 0.05);
				}

				.table-hover tbody tr:hover {
					color: #212529;
					background-color: rgba(0, 0, 0, 0.075);
				}
				.table .thead-dark th {
					color: #fff;
					background-color: #343a40;
					border-color: #454d55;
				}
				@media (max-width: 767.98px) {
					.table-responsive-md {
						display: block;
						width: 100%;
						overflow-x: auto;
				    	-webkit-overflow-scrolling: touch;
					}
				}
			</style>
			<table class="table table-striped table-hover table-sm">
				<tr>
					<td>Scheme:</td>
					<td>{site_name}</td>
					<td>User Membership:</td>
					<td>{membership_no}</td>
				</tr>
				<tr>
					<td>Name:</td>
					<td>{user_name}</td>
					<td>CNIC:</td>
					<td>{user_cnic}</td>
				</tr>
				<tr>
					<td>Mobile:</td>
					<td>{user_phone}</td>
					<td>Email:</td>
					<td>{user_email}</td>
				</tr>
				<tr>
					<td>Installment Permonth:</td>
					<td>Rs: {installment_per_month}<td>
					<td>Total Installment:</td>
					<td>{no_of_draws}</td>
				</tr>
				<tr>
					<td colspan="2">Dues / Additional</td>
					<td colspan="2">Rs: {dues}</td>
				</tr>
			</table>
			<table class="table table-striped table-hover table-sm">
				<thead class="thead-dark">
					<tr>
						<th>Date</th>
						<th>Installment#</th>
						<th>Amount</th>
						<th>Additional / Remaining</th>
						<th>Collector</th>
					</tr>
				</thead>
				<tfoot class="thead-dark">
					<tr>
						<th>Date</th>
						<th>Installment#</th>
						<th>Amount</th>
						<th>Additional / Remaining</th>
						<th>Collector</th>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td>{payment_date}</td>
						<td>{installment_num}</td>
						<td>{payment}<td>
						<td>{additional_dues{</td>
						<td>{collector_person}</td>
					</tr>
				</tbody>
			</table>';

?>