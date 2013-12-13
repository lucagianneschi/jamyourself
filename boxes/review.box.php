<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright		Jamyourself.com 2013 * \par			Info Classe: * \brief		box caricamento review event * \details		Recupera le informazioni sulla review dell'event, le inserisce in un array da passare alla view * \par			Commenti: * \warning * \bug * \todo		 */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';require_once CLASSES_DIR . 'comment.class.php';require_once CLASSES_DIR . 'commentParse.class.php';/** * \brief	ReviewBox class * \details	box class to pass info to the view */class ReviewBox {    public $config;    public $error;    public $mediaInfo;    public $reviewArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/review.config.json"), false);    }    /**     * \fn	initForMediaPage($objectId, $className, $limit, $skip)     * \brief	Init ReviewBox instance for Media Page     * \param	$objectId of the review to display information, Event or Record class     * \param   $className, $limit, $skip,$currentUserId     * \todo	     */    public function initForMediaPage($objectId, $className, $limit = null, $skip = null) {        $reviewArray = array();        $this->mediaInfo = array();        $review = new CommentParse();        if ($className == 'Event') {            $review->wherePointer('event', $className, $objectId);            $review->where('type', 'RE');        } else {            $review->wherePointer('record', $className, $objectId);            $review->where('type', 'RR');        }        $review->where('active', true);        $review->whereInclude('fromUser');        $review->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && $limit <= MAX ) ? $limit : DEFAULTQUERY);        $review->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);        $review->orderByDescending('createdAt');        $reviews = $review->getComments();        if ($reviews instanceof Error) {            $this->error = $reviews->getErrorMessage();            $this->reviewArray = array();            return;        } elseif (is_null($reviews)) {            $this->error = null;            $this->reviewArray = array();            return;        } else {            foreach ($reviews as $review) {                if (!is_null($review->getFromUser()))                    array_push($reviewArray, $review);            }        }        $this->error = null;        $this->reviewArray = $reviewArray;    }    /**     * \fn	initForPersonalPage($objectId, $type, $className)     * \brief	Init ReviewBox instance for Personal Page     * \param	$objectId of the user who owns the page, $type of user, $className Record or Event class     * \param   $type, $className     */    function initForPersonalPage($objectId, $type, $className, $limit = null, $skip = null) {        $reviewArray = array();        $this->mediaInfo = array();        $reviewP = new CommentParse();        $reviewP->where('active', true);        if ($type == 'SPOTTER' && $className == 'Event') {            $field = 'fromUser';            $reviewP->where('type', 'RE');            $reviewP->whereInclude('event.fromUser');        } elseif ($type == 'SPOTTER' && $className == 'Record') {            $field = 'fromUser';            $reviewP->where('type', 'RR');            $reviewP->whereInclude('record.fromUser');        } elseif ($type != 'SPOTTER' && $className == 'Event') {            $field = 'toUser';            $reviewP->where('type', 'RE');            $reviewP->whereInclude('event,fromUser');        } elseif ($type != 'SPOTTER' && $className == 'Record') {            $field = 'toUser';            $reviewP->where('type', 'RR');            $reviewP->whereInclude('record,fromUser');        }        $reviewP->wherePointer($field, '_User', $objectId);        $reviewP->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $limit : DEFAULTQUERY);        $reviewP->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);        $reviewP->orderByDescending('createdAt');        $reviews = $reviewP->getComments();        if ($reviews instanceof Error) {            $this->error = $reviews->getErrorMessage();            $this->reviewArray = array();            return;        } elseif (is_null($reviews)) {            $this->error = null;            $this->reviewArray = array();            return;        } else {            foreach ($reviews as $review) {                $condition1 = ($type == 'SPOTTER' && $className == 'Event' && !is_null($review->getEvent()) && !is_null($review->getEvent()->getFromUser()));                $condition2 = ($type == 'SPOTTER' && $className == 'Record' && !is_null($review->getRecord()) && !is_null($review->getRecord()->getFromUser()));                $condition3 = ($type != 'SPOTTER' && $className == 'Event' && !is_null($review->getEvent()) && !is_null($review->getFromUser()));                $condition4 = ($type != 'SPOTTER' && $className == 'Record' && !is_null($review->getRecord()) && !is_null($review->getFromUser()));                if ($condition1 || $condition2 || $condition3 || $condition4) {                    array_push($reviewArray, $review);                }            }            $this->error = null;            $this->reviewArray = $reviewArray;        }    }    /**     * \fn	initForUploadReviewPage($objectId, $className)     * \brief	Init REviewBox instance for Upload Review Page     * \param	$objectId for the event or record, $className Record or Event     * \todo         */    public function initForUploadReviewPage($objectId, $className) {        require_once BOXES_DIR . 'utilsBox.php';        $this->reviewArray = array();        $mediaInfo = array();        $currentUserId = sessionChecker();        if (is_null($currentUserId)) {            global $boxes;            $this->errorManagement($boxes['ONLYIFLOGGEDIN']);            return;        }        if ($className == 'Event') {            require_once CLASSES_DIR . 'event.class.php';            require_once CLASSES_DIR . 'eventParse.class.php';            $event = new EventParse();            $event->where('objectId', $objectId);            $event->where('active', true);            $event->whereInclude('fromUser');            $event->setLimit($this->config->limitForUploadReviewPage);            $event->orderByDescending('createdAt');            $events = $event->getEvents();            if ($events instanceof Error) {                $this->error = $events->getErrorMessage();                $this->mediaInfo = null;                return;            } elseif (is_null($events)) {                $this->error = null;                $this->mediaInfo = array();                return;            } else {                foreach ($events as $event) {                    if (!is_null($event->getFromUser()))                        array_push($mediaInfo, $event);                }                $this->error = null;                $this->mediaInfo = $mediaInfo;                return;            }        } else {            require_once CLASSES_DIR . 'record.class.php';            require_once CLASSES_DIR . 'recordParse.class.php';            $record = new RecordParse();            $record->where('objectId', $objectId);            $record->where('active', true);            $record->setLimit($this->config->limitForUploadReviewPage);            $record->orderByDescending('createdAt');            $record->whereInclude('fromUser');            $records = $record->getRecords();            if ($records instanceof Error) {                $this->error = $records->getErrorMessage();                $this->mediaInfo = null;                return;            } elseif (is_null($records)) {                $this->error = null;                $this->mediaInfo = array();                return;            } else {                foreach ($records as $record) {                    if (!is_null($record->getFromUser()))                        array_push($mediaInfo, $record);                }            }        }        $this->error = null;        $this->mediaInfo = $mediaInfo;    }}?>