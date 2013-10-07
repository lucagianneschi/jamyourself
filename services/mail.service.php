<?php
/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		estensione della classe PHPMailer 
 * \details		contiene i parametri standard di invio mail di Jam
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
 
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mail/class.phpmailer.php';

function mailService() {
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host     	= 'smtp.piombino2.it'; 							#TODO sostituire con il server di posta in uscita di Jam
	$mail->SMTPAuth 	= true;
	$mail->Username 	= 'postmaster@piombino2.it'; 					#TODO SMTP account username di Jam
	$mail->Password 	= 'b94cca2c2e'; 								#TODO SMTP account password di Jam
	$mail->SMTPSecure 	= 'tls';
	$mail->From     	= 'noreply@piombino2.it';					#TODO indirizzo da cui si desidera far recapitare le email 
	$mail->FromName 	= 'Scout Piombino2';							#TODO il nome che si vuole far apparire all'arrivo di una email
	$mail->addReplyTo('noreply@piombino2.it', 'Scout Piombino2');	#TODO il nome e la mail a cui l'utente deve rispondere
	$mail->isHTML(true);
	return $mail;
}
?>
