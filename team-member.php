<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title">Team Members</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
	                
	                $agent_query = mysqli_query($conn, "SELECT * FROM users WHERE role='1' && active_status='1' && delete_status='0'");
	                if(mysqli_num_rows($agent_query) > 0) {
	                    while($agent_result = mysqli_fetch_assoc($agent_query)) {
	                        $agent_display_id = $agent_result['id'];
	                        $agent_display_meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$agent_display_id'");
	                        if(mysqli_num_rows($agent_display_meta_query) > 0) {
	                            while($agent_display_meta_result = mysqli_fetch_assoc($agent_display_meta_query)) {
	                                $agent_display_meta[$agent_display_meta_result['meta_key']] = $agent_display_meta_result['meta_value'];
	                            }
	                        }
	                        $agent_media = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM media WHERE user_id='$agent_display_id' && media_for='2'"));
	                ?>
	                <div class="col-md-4 mb-3">
	                    <div class="card">
	                        <a href="register.php?agent_id=<?php echo $agent_display_id; ?>"><img src="<?php echo $agent_media['media_path']; ?>" class="card-img-top"></a>
	                        <div class="card-body">
	                            <h6 class="card-title"><?php echo $agent_display_meta['user_name']; ?></h6>
	                            <p class="card-text"><?php echo $agent_result['user_phone']; ?></p>
	                            <a href="register.php?agent_id=<?php echo $agent_display_id; ?>" class="btn btn-dark">Register</a>
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
    </div>
</div>