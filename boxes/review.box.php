<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright		Jamyourself.com 2013 * \par			Info Classe: * \brief		box caricamento review event * \details		Recupera le informazioni sulla review dell'event, le inserisce in un array da passare alla view * \par			Commenti: * \warning * \bug * \todo		 */
if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';require_once CLASSES_DIR . 'comment.class.php';require_once CLASSES_DIR . 'commentParse.class.php';/** * \brief	ReviewBox class * \details	box class to pass info to the view */class ReviewBox {    public $config;    public $error;    public $reviewArray;    public $mediaInfo;
    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {		$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/review.config.json"), false);    }
    /**     * \fn	initForMediaPage($objectId, $className, $limit, $skip)     * \brief	Init ReviewBox instance for Media Page     * \param	$objectId of the review to display information, Event or Record class     * \param   $className, $limit, $skip,$currentUserId     * \return	reviewBox     * \todo	     */    public function initForMediaPage($objectId, $className, $limit, $skip) {		$reviewArray = array();		$this->mediaInfo = null;		$review = new CommentParse();		if ($className == 'Event') {			$review->wherePointer('event', $className, $objectId);			$review->where('type', 'RE');		} else {			$review->wherePointer('record', $className, $objectId);			$review->where('type', 'RR');		}		$review->where('active', true);		$review->whereInclude('fromUser');		$review->setLimit((is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $this->config->limitForMediaPage : $limit);		$review->setSkip((is_null($skip) && is_int($skip)) ? 0 : $skip);		$review->orderByDescending('createdAt');		$reviews = $review->getComments();		if ($reviews instanceof Error) {			$this->error = $reviews->getErrorMessage();			$this->reviewArray = array();			return;		} elseif (is_null($reviews)) {			$this->error = null;			$this->reviewArray = array();			return;		} else {			foreach ($reviews as $review) {			if (!is_null($review->getFromUser()))				array_push($reviewArray, $review);			}		}		$this->error = null;		$this->reviewArray = $reviewArray;    }    /**     * \fn	initForPersonalPage($objectId, $type, $className)     * \brief	Init ReviewBox instance for Personal Page     * \param	$objectId of the user who owns the page, $type of user, $className Record or Event class     * \param   $type, $className     * \todo	     * \return	reviewBox     */    function initForPersonalPage($objectId, $type, $className) {		$reviewArray = array();		$this->mediaInfo = null;		$reviewP = new CommentParse();		$reviewP->where('active', true);		if ($type == 'SPOTTER' && $className == 'Event') {			$field = 'fromUser';			$reviewP->where('type', 'RE');			$reviewP->whereInclude('event,event.fromUser');		} elseif ($type == 'SPOTTER' && $className == 'Record') {			$field = 'fromUser';			$reviewP->where('type', 'RR');			$reviewP->whereInclude('record,record.fromUser');		} elseif ($type != 'SPOTTER' && $className == 'Event') {			$field = 'toUser';			$reviewP->where('type', 'RE');			$reviewP->whereInclude('event,fromUser');		} elseif ($type != 'SPOTTER' && $className == 'Record') {			$field = 'toUser';			$reviewP->where('type', 'RR');			$reviewP->whereInclude('record,fromUser');		}		$reviewP->wherePointer($field, '_User', $objectId);		$reviewP->setLimit($this->config->limitForPersonalPage);		$reviewP->orderByDescending('createdAt');		$reviews = $reviewP->getComments();		if ($reviews instanceof Error) {			$this->error = $reviews->getErrorMessage();			$this->reviewArray = array();			return;		} elseif (is_null($reviews)) {			$this->error = null;			$this->reviewArray = array();			return;		} else {			foreach ($reviews as $review) {			if ($type == 'SPOTTER' && $className == 'Event' && !is_null($review->getEvent()) && !is_null($review->getEvent()->getFromUser())) {				array_push($reviewArray, $review);			} elseif ($type == 'SPOTTER' && $className == 'Record' && !is_null($review->getRecord()) && !is_null($review->getRecord()->getFromUser())) {				array_push($reviewArray, $review);			} elseif ($type != 'SPOTTER' && $className == 'Event' && !is_null($review->getEvent()) && !is_null($review->getFromUser())) {				array_push($reviewArray, $review);			} elseif ($type != 'SPOTTER' && $className == 'Record' && !is_null($review->getRecord()) && !is_null($review->getFromUser())) {				array_push($reviewArray, $review);			}			}			$this->error = null;			$this->reviewArray = $reviewArray;		}    }    /**     * \fn	initForUploadReviewPage($objectId, $className)     * \brief	Init REviewBox instance for Upload Review Page     * \param	$objectId for the event or record, $className Record or Event     * \todo         * \return	reviewBox     */    public function initForUploadReviewPage($objectId, $className, $limit = 1) {		$this->reviewArray = array();		$mediaInfo = array();		if ($className == 'Event') {			require_once CLASSES_DIR . 'event.class.php';			require_once CLASSES_DIR . 'eventParse.class.php';			$event = new EventParse();			$event->where('objectId', $objectId);			$event->where('active', true);			$event->whereInclude('fromUser');			$event->setLimit((is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $this->config->limitForUploadReviewPage : $limit);			$event->orderByDescending('createdAt');			$events = $event->getEvents();			if ($events instanceof Error) {				$this->error = $events->getErrorMessage();				$this->reviewArray = array();				return;			} elseif (is_null($events)) {				$this->error = null;				$this->reviewArray = array();				return;			} else {				foreach ($events as $event) {					if (!is_null($event->getFromUser()))					array_push($mediaInfo, $event);				}				$this->error = null;				$this->mediaInfo = $mediaInfo;			}		} else {			require_once CLASSES_DIR . 'record.class.php';			require_once CLASSES_DIR . 'recordParse.class.php';			$record = new RecordParse();			$record->where('objectId', $objectId);			$record->where('active', true);			$record->setLimit((is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $this->config->limitForUploadReviewPage : $limit);			$record->orderByDescending('createdAt');			$record->whereInclude('fromUser');			$records = $record->getRecords();			if ($records instanceof Error) {				$this->error = $records->getErrorMessage();				$this->reviewArray = array();				return;			} elseif (is_null($records)) {				$this->error = null;				$this->reviewArray = array();				return;			} else {				foreach ($records as $record) {					if (!is_null($record->getFromUser()))					array_push($mediaInfo, $record);				}			}		}		$this->error = null;		$this->mediaInfo = $mediaInfo;    }}?>