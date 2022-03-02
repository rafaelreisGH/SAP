<?php

require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
	// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
	$mail->SMTPDebug = 0;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'sapcbmmt@gmail.com';
	$mail->Password = 'bombeirosSAP';
	$mail->Port = 587;

	$mail->setFrom('sapcbmmt@gmail.com', 'Admin');
	$mail->addAddress($aux_email, $aux_nome);

	$mail->isHTML(true);
	$mail->Subject = 'Chave de acesso - SAP';
	$mail->Body = '<h1>Chave para acesso inicial no SAP - CBMMT</h1>
    <br><p>Informe a senha provisória encaminhada nesta mensagem para realizar o acesso ao SAP - CBMMT.</p><p>Senha:&nbsp;'.$aux.'
    </p><br><br>';
	$mail->AltBody = 'Chave para acesso inicial no SAP - CBMMT: '.$aux;

	// if($mail->send()) {
	// 	echo 'Email enviado com sucesso';
	// } else {
	// 	echo 'Email nao enviado';
	// }
} catch (Exception $e) {
	echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
}