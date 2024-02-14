<?php

include "function.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $x = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM scheme WHERE id='$id'"));
    if($x > 1) {
        header("location:draws.php");
        die();
    }
} else {
    header("location:draws.php");
    die();
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
			<div class="row">
			    <div class="col-12 mb-3">
			        <?php
			        
			        if(isset($_POST['save_draw'])) {
			            $user_id = mysqli_real_escape_string($conn, $_POST['scheme_user']);
			            $gift_id = mysqli_real_escape_string($conn, $_POST['scheme_gift']);
			            $gift_type_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM gifts WHERE id='$gift_id'"));
			            $gift_type = $gift_type_query['prize_type'];
			            $scheme_gift_name = $gift_type_query['name'];
			            $draw_number_query = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM draw WHERE scheme_id='$id'"));
			            $draw_number = $draw_number_query+1;
			            $draw_month = date('m');
			            $scheme_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM scheme_meta WHERE scheme_id='$id'");
			            while($scheme_meta_result = mysqli_fetch_assoc($scheme_meta_query)) {
			                $scheme_meta[$scheme_meta_result['meta_key']] = $scheme_meta_result['meta_value'];
			            }
			            $draw_date_time = $scheme_meta['draw_date_time'];
			            $draw_time = strtotime($draw_date_time);
			            $draw_date = date('d-m-Y', $draw_time);
			            if($draw_number_query < $scheme_meta['no_of_draws']) {
    			            if($draw_time <= time()) {
	    		                $query = mysqli_query($conn, "INSERT INTO draw(scheme_id, user_id, draw_date, draw_prize, draw_number, draw_month, time_created) VALUES('$id', '$user_id', '$draw_date', '$scheme_gift_name', '$draw_number', '$draw_month', '$time_created')");
	    		                if($gift_type == 1) {
	    		                    $update_user = mysqli_query($conn, "UPDATE users SET enroll_status='0' WHERE id='$user_id'");
	    		                }
	    		                if($query) {
	    		                    echo "<div class='alert alert-success'>Draw is Successfully Added</div>";
	    		                } else {
	    		                    echo "<div class='alert alert-danger'>Draw is not Added Please Try Again</div>";
	    		                }
		    	            } else {
		    	                echo "<div class='alert alert-danger'>Current Time is not matched with Draw Time</div>";
		    	            }
			            } else {
			                echo "<div class='alert alert-danger'>No More Draws Lefts</div>";
			            }
			        }
			        
			        ?>
			        <form class="form" method="post">
			            <div class="form-group">
			                <label>Select Users</label>
			                <select class="custom-select" name="scheme_user" required>
			                    <option value="">Select Users</option>
			                    <?php
			                        
			                    $scheme_users_query = mysqli_query($conn, "SELECT * FROM users WHERE role='2' && scheme_id='$id' && enroll_status='1'");
			                    if(mysqli_num_rows($scheme_users_query) > 0) {
			                        while($scheme_users_result = mysqli_fetch_assoc($scheme_users_query)) {
			                            $scheme_users_id = $scheme_users_result['id'];
			                            $scheme_user_meta_query = mysqli_query($conn, "SELECT * FROM user_meta WHERE user_id='$scheme_users_id'");
			                            while($scheme_user_meta_result = mysqli_fetch_assoc($scheme_user_meta_query)) {
			                                $scheme_user_meta[$scheme_user_meta_result['meta_key']] = $scheme_user_meta_result['meta_value'];
			                            }
			                            echo "<option value='".$scheme_users_id."'>".$scheme_user_meta['user_shipno']." == ".$scheme_user_meta['user_name']."</option>";
			                        }
			                    }
			                        
			                    ?>
			                </select>
			            </div>
			            <div class="form-group">
			                <label>Select Gift:</label>
			                <select class="custom-select" name="scheme_gift">
			                    <option value="">Select Gift</option>
			                    <?php
			                    
			                    $scheme_gift_query = mysqli_query($conn, "SELECT * FROM gifts WHERE for_id='$id' && active_status='1'");
			                    if(mysqli_num_rows($scheme_gift_query) > 0) {
			                        while($scheme_gift_result = mysqli_fetch_assoc($scheme_gift_query)) {
			                            echo "<option value='".$scheme_gift_result['id']."'>".$scheme_gift_result['name']."</option>";
			                        }
			                    }
			                    
			                    ?>
			                </select>
			            </div>
			            <button type='submit' name='save_draw' class='btn btn-dark'>Save Manual Draw</button>
			        </form>
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

















