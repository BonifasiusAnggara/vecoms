<?php 
try {							
	$body = "
	<li style='padding:5px; color:#F15757;'><span class='divider'><b>&gt;</b></span><i class='fa fa-car'></i> Mobil dengan Plat No <b>$row[plat_no]</b>, masa berlaku STNK nya sudah mau habis !! kurang $row[stnk] hari lagi</li>";
	$mail = new PHPMailer(true);
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	$mail->Host = "smtp.gmail.com";
	$mail->Username = "bonifasius.frengki.anggara@gmail.com";
	$mail->password = "";
	$mail->AddReplyTo("bonifasius.frengki.anggara@gmail.com");
	$mail->SetFrom = "bonifasius.frengki.anggara@gmail.com";
	$mail->FromName = "Frengki Anggara";
	$to = "frengki.anggara@enseval.com";
	$mail->AddAddress($to);
	$mail->Subject = "Kematian STNK";
	$mail->MsgHTML($body);
	$mail->IsHTML(true);
	$mail->Send();
} catch (phpmailerException $e) {
	echo $e->errorMessage();
}
?>