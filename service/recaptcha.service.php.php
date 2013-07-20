<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe: recaptcha
 *  \brief     gestione recaptcha  
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:user">API</a>
 */

require_once SERVICES_DIR . 'recaptchalib.php';

class Recaptcha {

    private $privateKey;
    private $publicKey;

    /**
     * \fn	void construct()
     * \brief	The constructor instantiate the private & the publick key for the Google recaptcha service
     * \param	$isHtml is a string
     */
    public function __construct() {
        $this->privateKey = '6Lei6NYSAAAAAOXsGrRhJxUqdFGt03jcqaABdJMn';
        $this->publicKey = '6Lei6NYSAAAAAENpHWBBkHtd0ZbfAdRAtKMcvlaQ';
    }

    /**
     * \fn	array checkRecaptchaAnswer($remoteAddress, $fieldChallenge, $fieldResponse)
     * \brief	Return array of string, answers from recaptcha
     * \return	array
     */
    public function checkRecaptchaAnswer($remoteAddress, $fieldChallenge, $fieldResponse) {
        return recaptcha_check_answer($this->privateKey, $remoteAddress, $fieldChallenge, $fieldResponse);
    }

    /**
     * \fn	string getRecaptchaHtml()
     * \brief	Return the publickkey for recaptcha
     * \return	string
     */
    public function getRecaptchaHtml() {
        return recaptcha_get_html($this->publicKey);
    }

}

?>