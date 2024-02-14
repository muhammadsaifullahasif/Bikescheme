<?php

include "function.php";

if(isset($_GET['status'])) {
    $status = $_GET['status'];
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
			        <h5 class="card-title">Select Scheme</h5>
			    </div>
			    <div class="card-body">
			        <?php
			        
			        if(isset($_POST['submit'])) {
			            $select_scheme = $_POST['select_scheme'];
			            echo "<script>window.top.location='scheme-detail.php?scheme_id=".$select_scheme."&status=".$status."';</script>";
			        }
			        
			        ?>
			        <form class="form" id="select-scheme-form" method="post">
    			        <div class="form-group">
    			            <select class='custom-select' id='select-scheme' name="select_scheme">
    			                <option value="">Select Scheme</option>
    			                <?php
    			                
    			                $query = mysqli_query($conn, "SELECT * FROM scheme WHERE active_status='1' && delete_status='0'");
    			                if(mysqli_num_rows($query) > 0) {
    			                    if(mysqli_num_rows($query) > 1) {
    			                        while($result = mysqli_fetch_assoc($query)) {
    			                            echo "<option value='".$result['id']."'>".$result['title']."</option>";
    			                        }
    			                    } else {
    			                        $result = mysqli_fetch_assoc($query);
    			                        echo "<script>window.top.location='scheme-detail.php?scheme_id=".$result['id']."&status=".$status."';</script>";
    			                    }
    			                }
    			                
    			                ?>
    			            </select>
    			        </div>
			            <button class="btn btn-dark" type="submit" name="submit">Next</button>
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