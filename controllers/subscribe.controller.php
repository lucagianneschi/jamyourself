<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once SERVICES_DIR . 'utils.service.php';

/**
 * SubscribeController class
 * effettua sottoscrizione per nuova versione
 * 
 * @author Stefano Muscas
 * @version		0.2
 * @since		2014-03-12
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class SubscribeController extends REST {

    /**
     * Invia mail ad indirizzo predefinito
     */
    public function subscribe() {
	global $controllers;

	if (!isset($this->request['email']) || is_null($this->request['email']) || strlen($this->request['email']) == 0 || !$this->checkEmail($this->request['email'])) {
	    $this->response(array("status" => $controllers['INVALIDEMAIL']), 401);
	}
	$html = $this->request['email'];
	require_once CONTROLLERS_DIR . "utilsController.php";
	$res_send_email = sendMailForNotification(SUB_ADD, SUB_SBJ, $html);
	if ($res_send_email) {
	    $this->response(array("status" => $controllers['SUBSCRIPTIONOK']), 200);
	} else {
	    $this->response(array("status" => $controllers['SUBSCRIPTIONERROR']), 503);
	}
    }

    /**
     * Verifica coerenza della mail
     */
    private function checkEmail($email) {
	if (strlen($email) > 50)
	    return false;
	if (stripos($email, " ") !== false)
	    return false;
	if (!(stripos($email, "@") !== false))
	    return false;
	if (!(filter_var($email, FILTER_VALIDATE_EMAIL)))
	    return false;
	return true;
    }

}

?>