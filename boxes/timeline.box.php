<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event
 * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo	        corretta gestione di skip e limit sia per query interna che esterna		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'utilsBox.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';

/**
 * \brief	TimelineBox class 
 * \details	box class to pass info to the view for timelinePage
 */
class TimelineBox {

    public $activitesArray;
    public $config;
    public $error;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/timeline.config.json"), false);
    }

    /**
     * \fn	init
     * \brief	timeline init
     * \param	$limit, $skip
     * \todo    
     */
    public function init($limit = DEFAULTQUERY, $skip = null) {
        $currentUserId = sessionChecker();
        if (is_null($currentUserId)) {
            global $boxes;
            $this->errorManagement($boxes['ONLYIFLOGGEDIN']);
            return;
        }
        $activities = array();
        $currentUser = $_SESSION['currentUser'];
        $actArray = $this->createActivityArray($currentUser->getType());
        if (($currentUser->getType() == SPOTTER)) {
            $ciclesFollowing = ceil($currentUser->getFollowingCounter() / 1000);
            $ciclesFriendship = ceil($currentUser->getFriendshipCounter() / 1000);
            if ($ciclesFollowing == 0 && $ciclesFriendship == 0) {
                $this->errorManagement();
                return;
            }
            $partialActivities = $this->query('following', $currentUser->getObjectId(), $ciclesFollowing, $actArray, $limit, $skip);
            $partialActivities1 = $this->query('friendship', $currentUser->getObjectId(), $ciclesFriendship, $actArray, $limit, $skip);
            $activities = array_merge($partialActivities, $partialActivities1);
        } else {
            $cicles = ceil($currentUser->getCollaborationCounter() / 1000);
            if ($cicles == 0) {
                $this->errorManagement();
                return;
            }
            $activities = $this->query('collaboration', $currentUser->getObjectId(), $cicles, $actArray, $limit, $skip);
        }
        $this->error = (count($activities) == 0) ? 'NOACTIVITIES' : null;
        $this->activitesArray = $activities;
    }

    /**
     * \fn	query($field, $currentUserId, $cicles, $limit = null, $skip = null)
     * \brief	private funtion for query
     * \param	$limit, $skip per la query estena, ccioè sulle activities
     * \todo    
     */
    private function query($field, $currentUserId, $cicles, $actArray, $limit = null, $skip = null) {
        $activities = array();
        for ($i = 0; $i < $cicles; ++$i) {
            $parseQuery = new parseQuery('Activity');
            $pointer = $parseQuery->dataType('pointer', array('_User', $currentUserId));
            $related = $parseQuery->dataType('relatedTo', array($pointer, $field));
            $select = $parseQuery->dataType('query', array('_User', array('$relatedTo' => $related), 'objectId', 1000 * $i, 1000));
            $parseQuery->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $limit : 1000);
            $parseQuery->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);
            $parseQuery->whereSelect('fromUser', $select);
            $parseQuery->whereInclude('comment.fromUser,fromUser');
            $parseQuery->where('active', true);
            $parseQuery->whereContainedIn('type', $actArray);
            $res = $parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $partialActivities = $this->activitiesChecker($res);
            }
            array_push($activities, $partialActivities);
        }
        return $activities;
    }

    private function activitiesChecker($res) {
        $activities = array();
        require_once CLASSES_DIR . 'activityParse.class.php';
        foreach ($res->results as $obj) {
            $actP = new ActivityParse();
            $activity = $actP->parseToActivity($obj);
//            "COMMENTEDONIMAGE",
//            "COMMENTEDONEVENT",
//            "COMMENTEDONEVENTREVIEW",
//            "COMMENTEDONRECORD",
//            "COMMENTEDONRECORDREVIEW",
//            "COMMENTEDONPOST",
//            "COMMENTEDONVIDEO",
//            "CREATEDALBUM",
//            "CREATEDEVENT",
//            "CREATEDRECORD",
//            "NEWLEVEL",
//            "NEWBADGE",
//            "POSTED",
//            "SHAREDIMAGE",
//            "SHAREDSONG"
            $addedPhoto = ($activity->getType() == 'ADDEDPHOTO' && !is_null($activity->getImage() && !is_null($activity->getImage()->getFromUser())));
            $addedSong = ($activity->getType() == 'ADDEDSONG' && !is_null($activity->getSong() && !is_null($activity->getSong()->getFromUser())));
            $commentedOnAlbum = ($activity->getType() == 'COMMENTEDONALBUM' && !is_null($activity->getAlbum() && !is_null($activity->getAlbum()->getFromUser())));
            $commentedOnEvent = ($activity->getType() == 'COMMENTEDONEVENT' && !is_null($activity->getEvent() && !is_null($activity->getEvent()->getFromUser())));
            
            $posted = ($activity->getType() == 'POSTED' && !is_null($activity->getComment()) && !is_null($activity->getComment()->getfromUser()));
            $collaborationRequest = ($activity->getType() == 'COLLABORATIONREQUEST' && !is_null($activity->getFromUser()) && $activity->getStatus('A') &&!is_null($activity->getToUser()) );
            $friendshipRequest = ($activity->getType() == 'FRIENDSHIPREQUEST' && !is_null($activity->getFromUser()) && $activity->getStatus('A') &&!is_null($activity->getToUser()) );
            $following = ($activity->getType() == 'FOLLOWING' && !is_null($activity->getFromUser()) &&!is_null($activity->getToUser()) );
            
            if ($addedPhoto || $addedSong || $commentedOnAlbum || $posted || $collaborationRequest)
                $activities[$activity->getCreatedAt()->format('YmdHis')] = $activity;
        }
        return $activities;
    }

    /**
     * \fn	createActivityArray($userType)
     * \brief	private funtion for creating the activity type array based on the user type
     * \param	$userType
     * \todo    
     */
    private function createActivityArray($userType) {
        $sharedActivities = $this->config->sharedActivities;
        switch ($userType) {
            case 'SPOTTER':
                $specificActivities = $this->config->spotterActivities;
                break;
            case 'VENUE':
                $specificActivities = $this->config->venueActivities;
                break;
            case 'JAMMER':
                $specificActivities = $this->config->jammerActivities;
                break;
        }
        $actArray = array_merge($sharedActivities, $specificActivities);
        return $actArray;
    }

    /**
     * \fn	errorManagement($errorMessage = null)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessage
     */
    private function errorManagement($errorMessage = null) {
        $this->error = $errorMessage;
        $this->activitesArray = array();
    }

}
?>