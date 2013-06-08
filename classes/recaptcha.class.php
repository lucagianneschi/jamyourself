<?php
/*! \par Info Generali:
 *  \author    
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     
 *  \details   
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:user">API</a>
 */

define('UTILITY_DIR', '../utilities/');
include_once UTILITY_DIR.'recaptchalib.php';

class Recaptcha {
	
	private $privateKey;
	private $publicKey;
		
	public function __construct() {
		$this->privateKey = '6Lei6NYSAAAAAOXsGrRhJxUqdFGt03jcqaABdJMn';
		$this->publicKey  = '6Lei6NYSAAAAAENpHWBBkHtd0ZbfAdRAtKMcvlaQ';
	}
	
	public function getRecaptchaHtml() {
		return recaptcha_get_html($this->publicKey);
	}
	
	public function checkRecaptchaAnswer($remoteAddress, $fieldChallenge, $fieldResponse) {
		return recaptcha_check_answer ($this->privateKey,
										$remoteAddress,
										$fieldChallenge,
										$fieldResponse);
	}
	
}

?>