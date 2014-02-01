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
    $mail->Host = 'smtp.gmail.com';	
    $mail->SMTPAuth = true;
    $mail->Port = 465;
    $mail->Username = 'jamyourself@gmail.com';      #TODO SMTP account username di Jam
    $mail->Password = 'jam351610';	 #TODO SMTP account password di Jam
    $mail->SMTPSecure = true;
    $mail->From = 'info@jamyourself.com';
    $mail->FromName = 'Jamyourself: Meritocratic Social Music Network';
    $mail->addReplyTo('info@jamyourself.com', 'Jamyourself: Meritocratic Social Music Network'); 
    $mail->isHTML(true);
    return $mail;
}

?>