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
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
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
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
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
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
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
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
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
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
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
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
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
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
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
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
    }

}

?>