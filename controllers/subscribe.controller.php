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
 * invia mail ad indirizzo predefinito per tenere elenco di subscriber
 * 
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class SubscribeController extends REST {

    /**
     * invia mail ad indirizzo predefinito
     */
    public function subscribe() {
	global $controllers;
	$mail = checkEmail($this->request['email']);
	if (!isset($this->request['email']) || is_null($this->request['email']) || strlen($this->request['email']) == 0 || !$mail) {
	    $this->response(array("status" => $controllers['INVALIDEMAIL']), 401);
	}
	$html = $this->request['email'];
	$res_send_email = sendMailForNotification(SUB_ADD, SUB_SBJ, $html);
	if ($res_send_email) {
	    $this->response(array("status" => $controllers['SUBSCRIPTIONOK']), 200);
	} else {
	    $this->response(array("status" => $controllers['SUBSCRIPTIONERROR']), 503);
	}
    }

}

?>