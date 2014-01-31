<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di login e logout
 * \details		effettua operazioni di login e logut utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		terminare la funzione logout e socialLogin
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

/**
 * \brief	SubscribeController class 
 * \details	controller di richiesta di sottoscrizione dalla home
 */
class SubscribeController extends REST {

    public function subscribe() {
        global $controllers;

        if (!isset($this->request['email']) || is_null($this->request['email']) || strlen($this->request['email']) == 0 || !$this->checkEmail($this->request['email'])) {
            $this->response(array("status" => $controllers['INVALIDEMAIL']), 401);
        }
        $subject = "Benvenuto in Jamyourself!";
        $html = "Benvenuto in Jamyourself!";
        require_once CONTROLLERS_DIR . "utilsController.php";
        $res_send_email = sendMailForNotification($this->request['email'], $subject, $html);
        if($res_send_email){
            $this->response(array("status" => $controllers['SUBSCRIPTIONOK']), 200);            
        }else{
            $this->response(array("status" => $controllers['SUBSCRIPTIONERROR']), 200);            
        }
    }

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