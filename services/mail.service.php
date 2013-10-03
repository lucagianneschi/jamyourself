<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		estensione della classe PHPMailer 
 * \details		contiene i parametri standard di invio mail di Jam
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		settare i parametri corretti per invio mail
 *
 */
require ROOT_DIR . 'config.php';
require SERVICES_DIR . 'mail/class.phpmailer.php';

/**
 * \brief	MailService class 
 * \details	extend  PHPMailer
 */
class MailService extends PHPMailer {
    // Set default variables for all new objects
	var $AltBody  = 'To view the message, please use an HTML compatible email viewer!'; //mettere questo valore dentro i file di lingua
    var $From     = 'info@jamyourself.com';
    var $FromName = "Jamyourself.com - Meritocratic Music Social Network";
    var $Host     = 'smtp.gmail.com'; //sostituire con il server di posta in uscita di Jam
    var $Mailer   = "smtp"; 
	var $Password = "password"; // SMTP account username
	var $ReplyTo  = 'info@jamyourself.com';
	var $Username = "yourname@yourdomain"; // SMTP account username	
}
?>
