<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.2
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento notifiche utente
 * \details		Recupera le notifiche da mostrare nell'header
 * \par			Commenti:
 * \warning
 * \bug
 * \todo			
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

/**
 * \brief	ActionsCounterBox 
 * \details	counter for activity INVITED
 * \todo	inserire nella whereOr le activity corrette
 */
class ActionCounterBox {

    public $counter;

    /**
     * \fn	init()
     * \brief	Init ActionsBoxCounter instance
     * \return	actionsBoxCounter
     */
    public function init() {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$value = array(array('type' => 'LOVEDALBUM'), array('type' => 'LOVEDCOMMENT'), array('type' => 'LOVEDEVENT'), array('type' => 'LOVEDIMAGE'), array('type' => 'LOVEDRECORD'), array('type' => 'LOVEDSONG'), array('type' => 'LOVEDVIDEO'),
	    array('type' => 'COMMENTEDONALBUM'), array('type' => 'COMMENTEDONPOST'), array('type' => 'COMMENTEDONEVENTREVIEW'), array('type' => 'COMMENTEDONRECORDREVIEW'), array('type' => 'COMMENTEDONEVENT'), array('type' => 'COMMENTEDONIMAGE'), array('type' => 'COMMENTEDONRECORD'), array('type' => 'COMMENTEDONVIDEO'));
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $currentUserId);
	$activity->whereOr($value);
	$activity->where('status', 'P');
	$activity->where('read', false);
	$activity->where('active', true);
	$this->counter = $activity->getCount();
    }

}

/**
 * \brief	ActionsListBox 
 * \details	lista di activies per cui si ha notifica
 * \todo	
 */
class ActionListBox {

    public $actions;
    public $error;

    /**
     * \fn	init()
     * \brief	Init ActionListBox instance
     * \return	actionsListBox
     */
    public function init() {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$value = array(array('type' => 'LOVEDALBUM'), array('type' => 'LOVEDCOMMENT'), array('type' => 'LOVEDEVENT'), array('type' => 'LOVEDIMAGE'), array('type' => 'LOVEDRECORD'), array('type' => 'LOVEDSONG'), array('type' => 'LOVEDVIDEO'),
	    array('type' => 'COMMENTEDONALBUM'), array('type' => 'COMMENTEDONPOST'), array('type' => 'COMMENTEDONEVENTREVIEW'), array('type' => 'COMMENTEDONRECORDREVIEW'), array('type' => 'COMMENTEDONEVENT'), array('type' => 'COMMENTEDONIMAGE'), array('type' => 'COMMENTEDONRECORD'), array('type' => 'COMMENTEDONVIDEO'));
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $currentUserId);
	$activity->whereOr($value);
	$activity->where('status', 'P');
	$activity->where('read', false);
	$activity->where('active', true);
	$activity->whereInclude('fromUser,album,comment,event,image,record,song,video');
	$activities = $activity->getActivities();
	if ($activities instanceof Error) {
	    $this->error = $activities->getErrorMessage();
	    $this->actions = array();
	    return;
	} elseif (is_null($activities)) {
	    $this->error = null;
	    $this->actions = array();
	    return;
	} else {
	    $this->error = null;
	    $actions = array();
	    foreach ($activities as $act)
		if (!is_null($act->getFromUser()) &&
			(!is_null($act->getAlbum()) || !is_null($act->getComment())) || !is_null($act->getEvent()) || !is_null($act->getImage()) || !is_null($act->getRecord()) || !is_null($act->getSong()) || !is_null($act->getVideo())) {
		    array_push($actions, $act);
		}
	}
	$this->actions = $actions;
    }

}

/**
 * \class   EventListBox
 * \brief   class for list of events in header
 */
class EventListBox {

    public $error;
    public $events;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "notificationBox.config.json"), false);
    }

    /**
     * \fn	init()
     * \brief	class for quering events for header
     */
    public function init() {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $currentUserId);
	$activity->where('type', 'INVITED');
	$activity->where('read', false);
	$activity->where('status', 'P');
	$activity->where('active', true);
	$activity->setLimit($this->config->limitForMessageList);
	$activity->orderByDescending('createdAt');
	$activity->whereInclude('fromUser,event');
	$activities = $activity->getActivities();
	if ($activities instanceof Error) {
	    $this->error = $activities->getErrorMessage();
	    $this->events = array();
	    return;
	} elseif (is_null($activities)) {
	    $this->error = null;
	    $this->events = array();
	    return;
	} else {
	    $this->error = null;
	    $events = array();
	    foreach ($activities as $act)
		if (!is_null($act->getFromUser()) && !is_null($act->getEvent())) {
		    array_push($events, $act);
		}
	}
	$this->events = $events;
    }

}

/**
 * \brief	InvitedCounterBox 
 * \details	counter for activity INVITED
 */
class InvitedCounterBox {

    public $counter;

    /**
     * \fn	init()
     * \brief	Init InvitedBoxCounter instance
     * \return	invitedBoxCounter
     */
    public function init() {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $currentUserId);
	$activity->where('type', 'INVITED');
	$activity->where('read', false);
	$activity->where('status', 'P');
	$activity->where('active', true);
	$this->counter = $activity->getCount();
    }

}

/**
 * \brief	MessageCounterBox 
 * \details	counter for activity MESSAGESENT
 */
class MessageCounterBox {

    public $counter;

    /**
     * \fn	init()
     * \brief	Init MessageBoxCounter instance
     * \return	messageBoxCounter
     */
    public function init() {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $currentUserId);
	$activity->where('type', 'MESSAGESENT');
	$activity->where('status', 'P');
	$activity->where('read', false);
	$activity->where('active', true);
	$this->counter = $activity->getCount();
    }

}

/**
 * \brief	MessageListBox
 * \details	class for querying messages for header
 */
class MessageListBox {

    public $error;
    public $messages;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "notificationBox.config.json"), false);
    }

    /**
     * \fn	init()
     * \brief	Init MessageListBox instance
     * \return	messageListBox
     */
    public function init() {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $currentUserId);
	$activity->where('type', 'MESSAGESENT');
	$activity->where('read', false);
	$activity->where('status', 'P');
	$activity->where('active', true);
	$activity->setLimit($this->config->limitForEventList);
	$activity->orderByDescending('createdAt');
	$activity->whereInclude('comment,fromUser');
	$activities = $activity->getActivities();
	if ($activities instanceof Error) {
	    $this->error = $activities->getErrorMessage();
	    $this->messages = array();
	    return;
	} elseif (is_null($activities)) {
	    $this->error = null;
	    $this->messages = array();
	    return;
	} else {
	    $this->error = null;
	    $messages = array();
	    foreach ($activities as $act)
		if (!is_null($act->getFromUser()) && !is_null($act->getComment())) {
		    array_push($messages, $act);
		}
	}
	$this->messages = $messages;
    }

}

/**
 * \brief	RelationCounterBox
 * \details	counter for activity FRIENDSHIPREQUEST, COLLABORATIONREQUEST & FOLLOWING
 */
class RelationCounterBox {

    public $counter;

    /**
     * \fn	init()
     * \brief	Init MessageBoxCounter instance
     * \return	messageBoxCounter
     */
    public function init($type) {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $currentUserId);
	if ($type == 'SPOTTER') {
	    $activity->where('type', 'FRIENDSHIPREQUEST');
	} else {
	    $value = array(array('fromUser' => 'COLLABORATIONREQUEST'), array('fromUser' => 'FOLLOWING'));
	    $activity->whereOr($value);
	}
	$activity->where('status', 'P');
	$activity->where('read', false);
	$activity->where('active', true);
	$this->counter = $activity->getCount();
    }

}

/**
 * \brief	RelationListBox
 * \details	class for querying relations for header
 */
class RelationListBox {

    public $error;
    public $relations;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "notificationBox.config.json"), false);
    }

    /**
     * \fn	init()
     * \brief	Init RelationListBox instance
     * \return	relationListBox 
     */
    public function init($type) {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $currentUserId);
	if ($type == 'SPOTTER') {
	    $activity->where('type', 'FRIENDSHIPREQUEST');
	} else {
	    $activityTypes = array(array('type' => 'COLLABORATIONREQUEST'), array('type' => 'FOLLOWING'));
	    $activity->whereOr($activityTypes);
	}
	$activity->where('read', false);
	$activity->where('status', 'P');
	$activity->where('active', true);
	$activity->setLimit($this->config->limitForRelationList);
	$activity->orderByDescending('createdAt');
	$activity->whereInclude('fromUser');
	$activities = $activity->getActivities();
	if ($activities instanceof Error) {
	    $this->error = $activities->getErrorMessage();
	    $this->relations = array();
	    return;
	} elseif (is_null($activities)) {
	    $this->error = null;
	    $this->relations = array();
	    return;
	} else {
	    $this->error = null;
	    $relations = array();
	    foreach ($activities as $act)
		if (!is_null($act->getFromUser())) {
		    array_push($relations, $act);
		}
	}
	$this->relations = $relations;
    }

}

?>