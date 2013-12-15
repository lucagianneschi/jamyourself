<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright	Jamyourself.com 2013 * \par			Info Classe: * \brief		box Relations * \details		Recupera le ultime relazioni per tipologia di utente * \par			Commenti: * \warning * \bug * \todo		 * */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';require_once SERVICES_DIR . 'debug.service.php';require_once BOXES_DIR . 'utilsBox.php';/** * \brief	CollaboratorsBox class  * \details	box class to pass info to the view for personal page for JAMMER & VENUE  */class CollaboratorsBox {    public $config;    public $error;    public $venueArray;    public $jammerArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/relation.config.json"), false);    }    /**     * \fn	init($objectId)     * \brief	Init CollaboratorsBox      * \param	$objectId for user that owns the page $limit, $skip     * \todo         */    public function init($objectId) {	$venuesArray = array();	$jammersArray = array();    $collaborators = getAllUsersInRelation($objectId, 'collaboration');    if ($collaborators instanceof Error) {	    $this->error = $collaborators->getErrorMessage();	    $this->venueArray = array();	    $this->jammerArray = array();	    return;	} elseif (is_null($collaborators)) {	    $this->error = null;	    $this->venueArray = array();	    $this->jammerArray = array();	    return;	} else {	    foreach ($collaborators as $collaborator) {		($collaborator->getType() == 'VENUE') ? array_push($venuesArray, $collaborator) : array_push($jammersArray, $collaborator);	    }	    $this->error = null;	    $this->venueArray = $venuesArray;	    $this->jammerArray = $jammersArray;	}    }}/** * \brief	FollowersBox class  * \details	box class to pass info to the view for personal page for JAMMER & VENUE  */class FollowersBox {    public $config;    public $error;    public $followersArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/relation.config.json"), false);    }    /**     * \fn	init($objectId)     * \brief	Init FollowersBox      * \param	$objectId for user that owns the page      * \todo         */    public function init($objectId) {	$followers = getRelatedUsers($objectId, 'followers', '_User', false, $this->config->followers, 0);	if ($followers instanceof Error) {	    $this->error = $followers->getErrorMessage();	    $this->followersArray = array();	    return;	} elseif (is_null($followers)) {	    $this->error = null;	    $this->followersArray = array();	    return;	} else {	    $this->error = null;	    $this->followersArray = $followers;	}    }}/** * \brief	FollowingsBox class  * \details	box class to pass info to the view for personal page for SPOTTER  */class FollowingsBox {    public $config;    public $error;    public $venueArray;    public $jammerArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/relation.config.json"), false);    }    /**     * \fn	init($objectId)     * \brief	Init FollowingsBox     * \param	$objectId for user that owns the page      * \todo         */    public function init($objectId) {	$venuesArray = array();	$jammersArray = array();	$followings = getRelatedUsers($objectId, 'following', '_User', false, $this->config->followings, 0);	if ($followings instanceof Error) {	    $this->error = $followings->getErrorMessage();	    $this->venueArray = array();	    $this->jammerArray = array();	    return;	} elseif (is_null($followings)) {	    $this->error = null;	    $this->venueArray = array();	    $this->jammerArray = array();	    return;	} else {        foreach ($followings as $following) {		($following->getType() == 'VENUE') ? array_push($venuesArray, $following) : array_push($jammersArray, $following);	    }	    $this->error = null;	    $this->venueArray = $venuesArray;	    $this->jammerArray = $jammersArray;	}    }}/** * \brief	FriendsBox class  * \details	box class to pass info to the view for personal page for SPOTTER  */class FriendsBox {    public $config;    public $error;    public $friendsArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {		$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/relation.config.json"), false);    }    /**     * \fn	init($objectId)     * \brief	Init FriendsBox     * \param	$objectId for user that owns the page      * \todo         */    public function init($objectId) {		$friends = getRelatedUsers($objectId, 'friendship', '_User', false, $this->config->friends, 0);		if ($friends instanceof Error) {			$this->error = $friends->getErrorMessage();			$this->friendsArray = array();			return;		} elseif (is_null($friends)) {			$this->error = null;			$this->friendsArray = array();			return;		} else {			$this->error = null;			$this->friendsArray = $friends;		}    }}?>