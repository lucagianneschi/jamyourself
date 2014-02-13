<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright		Jamyourself.com 2013 * \par			Info Classe: * \brief		box caricamento ultime activities dell'utente * \details		Recupera le informazioni delle ultime activities dell'utente * \par			Commenti: * \warning * \bug * \todo * */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';/** * \brief	ActivitySongBox  class  * \details	box class to pass info to the view  */class ActivitySongBox {    public $config;    public $error;    public $songArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/activity.config.json"), false);    }    /**     * \fn	init($objectId)     * \brief	Init ActivitySongBox instance for Personal Page     * \param	$objectId for user that owns the page     */    public function init($objectId) {	$songArray = array();	require_once CLASSES_DIR . 'activity.class.php';	require_once CLASSES_DIR . 'activityParse.class.php';	$activityP = new ActivityParse();	$activityP->wherePointer('fromUser', '_User', $objectId);	$activityP->where('type', 'SONGLISTENED');	$activityP->where('active', true);	$activityP->setLimit($this->config->limitSongListenedForPersonalPage);	$activityP->whereInclude('record.fromUser,song');	$activityP->orderByDescending('createdAt');	$activities = $activityP->getActivities();	if ($activities instanceof Error) {	    $this->config = null;	    $this->error = $activities->getErrorMessage();	    $this->songArray = array();	    return;	} elseif (is_null($activities)) {	    $this->config = null;	    $this->error = null;	    $this->songArray = array();	    return;	} else {	    foreach ($activities as $activity) {		if (!is_null($activity->getRecord()) && !is_null($activity->getRecord()->getFromUser()) && !is_null($activity->getSong()))		    array_push($songArray, $activity);	    }	}	$this->error = null;	$this->songArray = $songArray;    }}/** * \brief	ActivityEventBox class  * \details	box class to pass info to the view  */class ActivityEventBox {    public $config;    public $error;    public $eventArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/activity.config.json"), false);    }    /**     * \fn	init($objectId)     * \brief	Init ActivityEventBox instance for Personal Page     * \param	$objectId for user that owns the page     */    public function init($objectId) {	require_once CLASSES_DIR . 'activity.class.php';	require_once CLASSES_DIR . 'activityParse.class.php';	$eventArray = array();	$activityP = new ActivityParse();	$activityP->setLimit($this->config->limitEventConfirmedForPersonalPage);	$activityP->wherePointer('fromUser', '_User', $objectId);	$activityP->where('type', 'INVITED');	$activityP->where('status', 'A');	$activityP->where('active', true);	$activityP->whereInclude('event');	$activityP->orderByDescending('createdAt');	$activities = $activityP->getActivities();	if ($activities instanceof Error) {	    $this->config = null;	    $this->error = $activities->getErrorMessage();	    $this->eventArray = array();	    return;	} elseif (is_null($activities)) {	    $this->config = null;	    $this->error = null;	    $this->eventArray = array();	    return;	} else {	    foreach ($activities as $activity) {		if (!is_null($activity->getEvent()))		    array_push($eventArray, $activity);	    }	    $this->error = null;	    $this->eventArray = $eventArray;	}    }}?>