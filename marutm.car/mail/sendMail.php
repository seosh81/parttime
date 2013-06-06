<?php

// include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$mail->ContentType = "text/html";
$mail->CharSet = "utf-8";

$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";  
$mail->Host       = "smtp.gmail.com"; // sets the SMTP server
$mail->Port       =  465;
$mail->Username   = "marutm83"; // SMTP account username
$mail->Password   = "m3988898";        // SMTP account password
#$mail->MsgHTML(file_get_contents('content.html'));
$mail->Body = $mail_body;
// $mail->MsgHTML(file_get_contents('template.php'));
// $mail->Body = "hello";

$mail->SetFrom('marutm83@gmail.com', 'marutm');

$mail->Subject    = '자동차 견적 문의';

$address = "marutm83@gmail.com";
$mail->AddAddress($address, "marutm");

foreach($mail_list as $email) {
	$mail->AddCC($email['email'], "name");
}

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
?>
