<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di inserimento commenti
 * \details		controller di inserimento commenti
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

/**
 * \fn		comment()
 * \brief   salva un commento
 * \todo    testare con sessione
 */
function sendMailForNotification($address, $subject, $html) {
    global $controllers;
    require_once SERVICES_DIR . 'mail.service.php';
    $mail = mailService();
    $mail->AddAddress($address);
    $mail->Subject = $subject;
    $mail->MsgHTML($html);
    $resMail = $mail->Send();
    if ($resMail instanceof phpmailerException) {
	$this->response(array('status' => $controllers['NOMAIL']), 403);
    }
    $mail->SmtpClose();
    unset($mail);
    return true;
}

?>