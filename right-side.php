<div class="col-lg-4">
	<div class="card mb-3">
		<div class="card-header bg-dark text-white">
			<h5 class="card-title">Login</h5>
		</div>
		<div class="card-body">
			<form class="form" id="login_form">
				<div id="login_form_msg" class="mb-3"></div>
				<div class="form-group">
					<!--<label>Username:</label>-->
					<input type="text" id="username" required class="form-control" placeholder="Enter Username" name="username">
					<div id="username_msg"></div>
				</div>
				<div class="form-group">
					<!--<label>Password:</label>-->
					<input type="password" id="password" required class="form-control" placeholder="Enter Password" name="password">
					<div id="password_msg"></div>
				</div>
				<button class="btn btn-dark" id="loginBtn" type="submit" name="loginBtn">Login</button>
			</form>
		</div>
	</div>
	<div class="card mb-3">
		<div class="card-header bg-dark text-white">
			<h5 class="card-title">Latest Winner</h5>
		</div>
		<div class="card-body">
			<?php

			$winner_query = mysqli_query($conn, "SELECT * FROM draw ORDER BY time_created DESC LIMIT 3");
			if(mysqli_num_rows($winner_query) > 0) {
				while($winner_result = mysqli_fetch_assoc($winner_query)) {
					$winner_user_id = $winner_result['user_id'];
					$winner_scheme_id = $winner_result['scheme_id'];
					$user_meta_query = "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$winner_user_id'";
					$conn->set_charset('utf8');
					$user_meta_run = mysqli_query($conn, $user_meta_query);
					if(mysqli_num_rows($user_meta_run) > 0) {
					    while($user_meta_result = mysqli_fetch_assoc($user_meta_run)) {
					        $user_meta[$user_meta_result['meta_key']] = $user_meta_result['meta_value'];
					    }
					}
					$scheme_query = mysqli_query($conn, "SELECT * FROM scheme WHERE id='$winner_scheme_id'");
					if(mysqli_num_rows($scheme_query) > 0) {
						$scheme_result = mysqli_fetch_assoc($scheme_query);
					}
					$media_query = mysqli_query($conn, "SELECT * FROM media WHERE user_id='$winner_user_id' && scheme_id='$winner_scheme_id' && media_for='2'");
					if(mysqli_num_rows($media_query) > 0) {
						$media_result = mysqli_fetch_assoc($media_query);
					}
			?>
			<div class="card mb-3">
				<div class="row no-gutters">
					<div class="col-4">
						<img class="card-img h-100" src="<?php echo $media_result['media_path']; ?>">
					</div>
					<div class="col-8 pl-1" style="font-size: 14px;">
						<h6 class="card-title text-center"><?php echo $user_meta['user_name']; ?></h6>
						<p class="mb-0"><b>Membership: <?php echo $user_meta['user_shipno']; ?></b></p>
						<p class="mb-0"><b>Scheme:</b> <?php echo $scheme_result['title']; ?></p>
						<p class="mb-0"><b>Draw:</b> <?php echo $winner_result['draw_number']; ?></p>
						<p class="mb-0"><b>Prize:</b> <?php echo $winner_result['draw_prize']; ?></p>
						<p class="mb-0"><b>Draw Date:</b> <?php echo $winner_result['draw_date']; ?></p>
					</div>
				</div>
			</div>
			<?php
				}
			}

			?>
		</div>
	</div>
</div>