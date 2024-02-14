<?php 

	$from = 'muhammadsaifullahasif@towaqal.com';  // Mail Created  from your Server
	$to='muhammadsaifullahasif@gmail.com'; // Receiver Email Address
	
	
	$subject='Test Mail -Aicoders';    // Mail Subject
	$headers= "MIME-Version: 1.0\n";
	$headers.="Content-type: text/html; charset=iso-8859-1\n";
	$headers.="From:".$from;
	
	$message = "Welcome To My Yotube Channel Aicodes"; // Message Body
	
	custom_mail($to,$subject,$message,$headers);
	
	
	echo "Mail Sent Successfully";
	 
	 

?>