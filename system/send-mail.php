<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/plugins/PHPMailer/PHPMailerAutoload.php');

function kirim_email($email, $filename, $link, $broken=true) {
	$mail 	= new PHPMailer;
	$mail_body = 'Hi, <strong>'.$email.'</strong><br/><br/>';
	if($broken !== false) {
		$mail_body .= 'Kami menemukan bahwa file Anda <i><a href="'.$link.'">'.$filename.'</a></i> mengalami kerusakan, sehingga pengguna lain tidak bisa mendownloadnya.<br/>';
	} else {
		$mail_body .= 'Kami mencurigai bahwa file Anda <i><a href="'.$link.'">'.$filename.'</a></i> mengalami kerusakan. ukuran file yang dirasa kurang valid karena kurang dari <b>1KB</b>.<br/>';
	}
	$mail_body .= 'Dimohon untuk diperbaiki segera, demi menjaga kenyamanan pendownload situs Anda. ^_^<br/><br/>';
	$mail_body .= 'Salam,<br/>';
	$mail_body .= 'Admin - YuuDrive';
/*
	$message  = file_get_contents('mail/template.html');
	$message = str_replace('%email%', $email, $message);
	$message = str_replace('%link%', $link, $message);
	$message = str_replace('%filename%', $filename, $message);
*/
	$mail->From = "noreply@yuudrive.me";
	$mail->FromName = "YuuDrive.me";
	$mail->addAddress($email);
	$mail->isHTML(true);
	$mail->Subject = "Broken File - yuudrive.com";
	$mail->Body  = $mail_body;
	return $mail->send();
}
?>