<!-- Announcement Bar Start -->
<section class="bg-light">
	<div class="container-fluid">
		<div class="announcement-container">
			<div class="announcement-img"></div>
			<ul id="announcement">
				<?php
                
                $announcement_query = "SELECT * FROM news WHERE type='2' && active_status='1'";
                $conn->set_charset('utf8');
				$announcement_run = mysqli_query($conn, $announcement_query);
				if(mysqli_num_rows($announcement_run) > 0) {
				    $i = 1;
					while($announcement = mysqli_fetch_assoc($announcement_run)) {
					    $class = '';
					    if($i != 1) {
					        $class = 'hide';
					    }
					    echo "<li class='announcement-text ".$class."' id='announcement_".$i."'>".$announcement['news_text']."</li>";
						$i++;
					}
				}

				?>
			</ul>
		</div>
	</div>
</section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var x = 1;
    	setInterval(function(){
    		updateAnnouncement();
    	}, 5000);
    	function updateAnnouncement() {
    	    x++;
    		$('.announcement-text').hide();
    		$('#announcement_'+x).show();
    // 		x++;
    		if(x == <?php echo mysqli_num_rows($announcement_run); ?>) {
    			x = 0;
    		}
    	}
    });
</script>
<!-- Announcement Bar End -->






