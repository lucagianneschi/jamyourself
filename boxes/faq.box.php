<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento FAQ
 * \details		Recupera le informazioni delle FAQ
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'faq.class.php';
require_once CLASSES_DIR . 'faqParse.class.php';

/**
 * \brief	FaqBox class 
 * \details	box class to pass info to the view for FAQ page
 */
class FaqBox {

    public $config;
    public $error;
    public $faqArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/comment.config.json"), false);
    }

    /**
     * \fn	initForFaqPage($limit,$lang,$field,$direction)
     * \brief	Init FaqBox instance for Faq Page
     * \param	$limit, number of paq to display; $lang, language of the text to display; $field for ordering instances; $direction ascending (true) or descending (false)
     * \return	faqBox
     */
    public function init($lang, $field, $limit, $direction = true) {
	$faqP = new FaqParse();
	$faqP->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $limit : $this->config->defaultLimit);
	$faqP->where('lang', $lang);
	($direction == true) ? $faqP->orderByAscending($field) : $faqP->orderByDescending($field);
	$faqs = $faqP->getFaqs();
	if ($faqs instanceof Error) {
	    $this->error = $faqs->getErrorMessage();
	    $this->faqArray = array();
	    return;
	} elseif (is_null($faqs)) {
	    $this->error = null;
	    $this->faqArray = array();
	    return;
	} else {
	    $this->error = null;
	    $this->faqArray = $faqs;
	}
    }

}

?>