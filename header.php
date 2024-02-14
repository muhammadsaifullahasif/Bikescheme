<header class="bg-light py-3">
	<div class="container-fluid">
		<a href="index.php"><img style="width: 150px;" src="images/logo.png"></a>
		<?php

		session_start();

		if(isset($_SESSION['bikescheme_user_login'])) {
			echo '<a href="account/index.php" class="btn btn-dark float-right">'.$_SESSION['bikescheme_user_login'].'</a>';
		}

		?>
	</div>
</header>