<?php

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