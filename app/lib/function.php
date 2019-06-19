<?php
	function sendmail($emailtujuan,$emailsubject,$content,$attachment = array()){
		global $pathdir;
		require_once("class.phpmailer.php");
		try {
		$mail = new PHPMailer(true); //New instance, with exceptions enabled

		$mail->IsSMTP();                           // tell the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Port       = 587;                    // set the SMTP server port
		$mail->Host       = "smtp.gmail.com"; // SMTP server
		$mail->Username   = "explore@limadigit.com";     // SMTP server username
		$mail->Password   = "5d3xpl0r3";            // SMTP server password

		//$mail->IsSendmail();  // tell the class to use Sendmail
		$mail->SMTPDebug = 1;
		$mail->SMTPSecure = 'tls';
		$mail->AddReplyTo("explore@limadigit.com","Explore");

		$mail->From       = "explore@limadigit.com";
		$mail->FromName   = "Explore";

		$to = $emailtujuan;
		
		$mail->AddAddress($to);

		$mail->Subject  = $emailsubject;

		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->WordWrap   = 80; // set word wrap

		$mail->MsgHTML($content);
		
		if($attachment != "" && !empty($attachment)) {
			foreach($attachment as $value) {
				$mail->AddAttachment($value);
			}
		}

		$mail->IsHTML(true); // send as HTML

		$send = $mail->Send();
		if(!$send) {
			return 'Message could not be sent. <br/> Mailer Error: ' . $mail->ErrorInfo;
		} else {
			return 'Message has been sent';
		}
		}catch (phpmailerException $e){
			echo $mail->ErrorInfo;
			echo $e->errorMessage();
			exit;
		}
	}
	
	
	# contoh dir "music/logfile/"
	# contoh filename "log.txt"
	function createFolder($dir,$filename,$data) {
		if(!is_dir($dir)) mkdir($dir,0755,true);
		file_put_contents($dir.$filename,$data,FILE_APPEND);
	}
?>