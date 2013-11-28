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
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'faq.class.php';
require_once CLASSES_DIR . 'faqParse.class.php';

/**
 * \brief	FaqInfo class 
 * \details	contains info for faq
 */
class FaqInfo {

    public $answer;
    public $area;
    public $position;
    public $question;
    public $tags;

    /**
     * \fn	__construct($answer, $area, $position, $question, $tags)
     * \brief	construct for the FaqInfo class
     * \param	$answer, $area, $position, $question, $tags
     */
    function __construct($answer, $area, $position, $question, $tags) {
        is_null($answer) ? $this->answer = null : $this->answer = $answer;
        is_null($area) ? $this->area = null : $this->area = $area;
        is_null($position) ? $this->position = 1000 : $this->position = $position;
        is_null($question) ? $this->question = null : $this->question = $question;
        is_null($tags) ? $this->tags = array() : $this->tags = $tags;
    }

}

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
    public function init($limit, $lang, $field, $direction) {
        $array = array();
        $faqP = new FaqParse();
        $faqP->setLimit((is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $this->config->defaultLimit : $limit);
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
            foreach ($faqs as $faq) {
                $answer = $faq->getAnswer();
                $question = $faq->getQuestion();
                $area = $faq->getArea();
                $position = $faq->getPosition();
                $tags = $faq->getTags();
                $faqInfo = new FaqInfo($answer, $area, $position, $question, $tags);
                array_push($array, $faqInfo);
            }
        }
        $this->error = null;
        $this->faqArray = $array;
    }

}

?>