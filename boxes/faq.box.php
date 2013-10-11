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
require_once BOXES_DIR . 'utilsBox.php';

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
     * \brief	construct for the AFaqInfo class
     * \param	$answer, $area, $position, $question, $tags
     */
    function __construct($answer, $area, $position, $question, $tags) {
	global $boxes;
	is_null($answer) ? $this->answer = $boxes['NODATA'] : $this->answer = $answer;
	is_null($area) ? $this->area = $boxes['NODATA'] : $this->area = $area;
	is_null($position) ? $this->position = 1000 : $this->position = $position;
	is_null($question) ? $this->question = $boxes['NODATA'] : $this->question = $question;
	is_null($tags) ? $this->tags = $boxes['NOTAG'] : $this->tags = $tags;
    }

}

/**
 * \brief	FaqBox class 
 * \details	box class to pass info to the view for FAQ page
 */
class FaqBox {

    public $faqArray;

    /**
     * \fn	initForFaqPage($limit,$lang,$field,$direction)
     * \brief	Init FaqBox instance for Faq Page
     * \param	$limit, number of paq to display; $lang, language of the text to display; $field for ordering istances; $direction ascending or descending
     * \return	faqBox
     */
    public function initForFaqPage($limit, $lang, $field, $direction) {
	$activityBox = new FaqBox();
	$array = array();

	$faqP = new FaqParse();
	$faqP->setLimit($limit);
	$faqP->where('active', true);
	if ($direction == 'true') {
	    $faqP->orderByDescending($field);
	} else {
	    $faqP->orderByAscending($field);
	}
	$faqs = $faqP->getFaqs();
	if (get_class($faqs) == 'Error') {
	    return $faqs;
	} else {
	    foreach ($faqs as $faq) {
		if ($lang == 'en') {
		    //prendo la question e la answer in inglese
		    $answer = parse_decode_string($faq->getAnswer());
		    $question = parse_decode_string($faq->getQuestion());
		} else {
		    //prendo la question e la answer in italiano
		    $answer = parse_decode_string($faq->getAnswer());
		    $question = parse_decode_string($faq->getQuestion());
		}
		$area = parse_decode_string($faq->getArea());
		$position = $faq->getPosition();
		$tags = array();
		if (count($faq->getTags()) > 0 && $faq->getTags() != null) {
		    foreach ($faq->getTags() as $tag) {
			$tag = parse_decode_string($tag);
			array_push($tags, $tag);
		    }
		}
		$faqInfo = new FaqInfo($answer, $area, $position, $question, $tags);
		array_push($array, $faqInfo);
	    }
	    $activityBox->faqArray = $array;
	}
	return $activityBox;
    }

}

?>