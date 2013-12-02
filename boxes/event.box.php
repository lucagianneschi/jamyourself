<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright		Jamyourself.com 2013 * \par			Info Classe: * \brief		box caricamento info event * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view * \par			Commenti: * \warning * \bug * \todo		sistemare il campo featuring, uso whereInclude	 * */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';require_once CLASSES_DIR . 'event.class.php';require_once CLASSES_DIR . 'eventParse.class.php';/** * \brief	EventBox class  * \details	box class to pass info to the view  */class EventBox {    public $config;    public $error;    public $eventArray;    public $fromUserInfo;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/event.config.json"), false);    }    /**     * \fn	initForMediaPage($objectId)     * \brief	Init EventBox instance for Media Page     * \param	$objectId for event     * \return	eventBox     */    public function initForMediaPage($objectId) {	$eventP = new EventParse();	$eventP->where('objectId', $objectId);	$eventP->where('active', true);	$eventP->whereInclude('fromUser');	$eventP->setLimit($this->config->limitEventForMediaPage);	$events = $eventP->getEvents();	if ($events instanceof Error) {	    $this->error = $events->getErrorMessage();	    $this->eventArray = array();	    $this->fromUserInfo = null;	    return;	} elseif (is_null($events)) {	    $this->error = null;	    $this->eventArray = array();	    $this->fromUserInfo = null;	    return;	} else {	    $this->error = null;	    $this->eventArray = $events[0];	    $this->fromUserInfo = (is_null($events[0]->getFromUser())) ? null : $events[0]->getFromUser();	}    }    /**     * \fn	initForPersonalPage($objectId)     * \brief	Init EventBox instance for Personal Page     * \param	$objectId for user that owns the page     * \todo         * \return	eventBox     */    public function initForPersonalPage($objectId) {	$this->fromUserInfo = null;	$event = new EventParse();	$event->wherePointer('fromUser', '_User', $objectId);	$event->where('active', true);	$event->setLimit($this->config->limitEventForPersonalPage);	$event->orderByDescending('eventDate');	$events = $event->getEvents();	if ($events instanceof Error) {	    $this->error = $events->getErrorMessage();	    $this->eventArray = array();	    return;	} elseif (is_null($events)) {	    $this->error = null;	    $this->eventArray = array();	    return;	} else {	    $this->error = null;	    $this->eventArray = $events;	}    }}?>