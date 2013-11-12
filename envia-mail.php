<?php
if( isset($_POST['email']) && !empty($_POST['message']) ){
	
	$emailTo = 'paulsoberanes@gmail.com';//$_POST['email'];
	$message = $_POST['message'];
	$store   = $_POST['store'];
	
	$email_content = "
	<html>
	<head>
		<meta charset='utf-8'>
	</head>
	<body>
		<div style='font-family: Helvetica Neue;width: 500px;margin: 0 auto;color: white;'>
			<div style='padding: 10px 30px;background: #04B8F9;'>
				<h1 style='font-size: 24px;margin: 0;color: white;'>Hola ".$store."</h1>
				<p style='font-style: italic;margin: 0;color: white;'>Este es un mensaje de la aplicaci&oacute;n Store Locator.</p>
			</div>
			<div style='position: relative;min-height: 15px;background: whitesmoke;color: black;padding: 30px;text-align: justify;margin: 0 auto;'>
				".$message."
			</div>
		</div>
	</body>
	</html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		
		if( mail($emailTo, "Mensaje de Store Locator Facebook App", $email_content,$headers) ){
			echo 1;
		}else{
			echo 0;
		}
		
}else{
	echo 2;
}
