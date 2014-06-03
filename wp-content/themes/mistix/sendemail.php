<?php
	//Your Email Address
	global $data; 
	$mailTo = htmlspecialchars($_POST['mailto']);
	$successM = htmlspecialchars($_POST['successM']);
	$errorM = htmlspecialchars($_POST['errorM']);
	$error = htmlspecialchars($_POST['error']);	
	$name = htmlspecialchars($_POST['name']);
	$mailFrom = htmlspecialchars($_POST['email']);
	$message_text = htmlspecialchars($_POST['message']);
	$subject = 'New Message from your site';
	$headers = 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= 'From: '.$mailFrom;
	
	$message =  "<html>
					<head>
						<title> $subject </title>
					</head>
				<body>
					<p>----------------------------------------</p>
					<b>Name:</b> $name<br />
					<b>E-mail:</b> $mailFrom<br />
					<b>Message:</b><br />
					<p>$message_text</p>
					<p>----------------------------------------</p>
				</body>
				</html>";
	
	if($error != 'true'){
		mail($mailTo, $subject, $message, $headers);
		echo $successM;
	}
	else {
		echo $errorM;
	}
	
?>