<?php

/* ! \par		Info Generali:
 * @author		Daniele Caldelli
 * @version		1.0
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
    $mail->Host = 'smtp.jamyourself.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@jamyourself.com';
    $mail->Password = 'jam361510';
    $mail->SMTPSecure = 'tls';
    $mail->From = 'noreply@jamyourself.com';
    $mail->FromName = 'Jamyourself';
    $mail->addReplyTo('noreply@jamyourself.com', 'Jamyourself');
    $mail->isHTML(true);
    return $mail;
}

?>