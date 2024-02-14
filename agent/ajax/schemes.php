<?php

include "../include/include.inc.php";

$output = '';
$query = mysqli_query($conn, "SELECT * FROM scheme");
if(mysqli_num_rows($query) > 0) {
	while($result = mysqli_fetch_assoc($query)) {
		$id = $result['id'];
		$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$id'");
		if(mysqli_num_rows($meta_query) > 0) {
			while($meta_result = mysqli_fetch_assoc($meta_query)) {
				$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
			}
		}
		$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE scheme_id='$id'"));
		$output .= '<tr>';
		$output .= '<td><a href="">'.$result['title'].'</a></td>';
		$output .= '<td>'.$meta['draw_place'].'</td>';
		$output .= '<td>'.$meta['no_of_draws'].'</td>';
		$output .= '<td><a href="scheme-detail.php?scheme_id='.$id.'">'.$totalUsers.'</a></td>';
		$output .= '<td>'.$meta['installment_per_month'].'</td>';
		$output .= '<td><div class="btn-group"><a href="scheme-detail.php?scheme_id='.$id.'" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a><a href="scheme-edit.php?scheme_id='.$id.'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><button type="button" data-did="'.$id.'" class="btn delete-scheme btn-danger btn-sm"><i class="fas fa-trash"></i></button></div></td>';
		$output .= '</tr>';
	}
} else {
	$output .= "<tr><td colspan='6' class='text-center'>No Record Found</td></tr>";
}

echo $output;

?>