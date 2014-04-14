<?php

/**
 * 
 * contiene i parametri standard di invio mail di Jam
 * 
 * @author Daniele Caldelli
 * @version		0.2
 * @since		2014-03-17
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */


if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mail/class.phpmailer.php';

/**
 * 
 * contiene i parametri standard di invio mail di Jam
 * 
 * @return \PHPMailer
 */
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