<section>
	<div id="mainSlider" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<?php

			$slider_query = mysqli_query($conn, "SELECT * FROM media WHERE media_for='6' && media_status='1'");
			if(mysqli_num_rows($slider_query) > 0) {
				$i = 1;
				while($slider_result = mysqli_fetch_assoc($slider_query)) {
			?>
			<div class="carousel-item <?php if($i == 1) echo "active"; ?>">
				<img height="400px" src="<?php echo $slider_result['media_path']; ?>" class="d-block w-100" alt="<?php echo $slider_result['media_alt']; ?>">
			</div>
			<?php
					$i++;
				}
			}

			?>
		</div>
	</div>
</section>