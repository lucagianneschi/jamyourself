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
 * \todo	        corretta gestione di skip e limit sia per query interna che esterna, correggere whereInclude		
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
        $currentUser = $_SESSION['currentUser'];
        $actArray = $this->createActivityArray($currentUser->getType());
        if (($currentUser->getType() == SPOTTER)) {
            $ciclesFollowing = ceil($currentUser->getFollowingCounter() / MAX);
            $ciclesFriendship = ceil($currentUser->getFriendshipCounter() / MAX);
            if ($ciclesFollowing == 0 && $ciclesFriendship == 0) {
                $this->errorManagement();
                return;
            }
            $partialActivities = $this->query('following', $currentUser->getObjectId(), $ciclesFollowing, $actArray, $limit, $skip);
            $partialActivities1 = $this->query('friendship', $currentUser->getObjectId(), $ciclesFriendship, $actArray, $limit, $skip);
            $activities = array_merge($partialActivities, $partialActivities1);
            $this->error = (count($activities) == 0) ? 'NOACTIVITIES' : null;
            //manca da fare ordinamento 
            $this->activitesArray = $activities;
            return;
        } else {
            $cicles = ceil($currentUser->getCollaborationCounter() / MAX);
            if ($cicles == 0) {
                $this->errorManagement();
                return;
            }
            $activities = $this->query('collaboration', $currentUser->getObjectId(), $cicles, $actArray, $limit, $skip);
        };
        $this->error = (count($activities) == 0 || !ksort($activities)) ? 'TIMELINERROR' : null;
        $this->activitesArray = $activities;
    }

    /**
     * \fn	query($field, $currentUserId, $cicles, $limit = null, $skip = null)
     * \brief	private funtion for query
     * \param	$limit, $skip per la query estena, ccioè sulle activities
     * \todo    mettere i corretti whereInclude in funzione delle tipologie di activities
     */
    private function query($field, $currentUserId, $cicles, $actArray, $limit, $skip) {
        $activities = array();
        for ($i = 0; $i < $cicles; ++$i) {
            $parseQuery = new parseQuery('Activity');
            $pointer = $parseQuery->dataType('pointer', array('_User', $currentUserId));
            $related = $parseQuery->dataType('relatedTo', array($pointer, $field));
            $select = $parseQuery->dataType('query', array('_User', array('$relatedTo' => $related), 'objectId', MAX * $i, MAX));
            $parseQuery->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : DEFAULTQUERY);
            $parseQuery->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);
            $parseQuery->whereSelect('fromUser', $select);
            $parseQuery->whereInclude('album.fromUser,event.fromUser,comment.fromUser,comment.toUser,record.fromUser,song.fromUser,video.fromUser,fromUser,toUser');
            $parseQuery->where('active', true);
            $parseQuery->whereContainedIn('type', $actArray);
            $res = $parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $partialActivities = $this->activitiesChecker($res);
            }
            $activities = $activities+$partialActivities;
        }
        return $activities;
    }

    /**
     * \fn	activitiesChecker($res)
     * \brief	private funtion for check if the activity on DB is correct
     * \param	$res, resul for the query
     * \retun   $activities array, filtered array with correct activities
     * \todo    fare controllo con i corretti whereInclude     
     */
    private function activitiesChecker($res) {
        $activities = array();
        require_once CLASSES_DIR . 'activityParse.class.php';
        foreach ($res->results as $obj) {
            $actP = new ActivityParse();
            $activity = $actP->parseToActivity($obj);
            $addedPhoto = ($activity->getType() == 'IMAGEUPLOADED' && !is_null($activity->getImage() && !is_null($activity->getImage()->getFromUser())));
            $addedSong = ($activity->getType() == 'SONGUPLOADED' && !is_null($activity->getSong() && !is_null($activity->getSong()->getFromUser())));
            $collaborationRequest = ($activity->getType() == 'COLLABORATIONREQUEST' && !is_null($activity->getFromUser()) && $activity->getStatus('A') && !is_null($activity->getToUser()) );
            $commentedOnAlbum = ($activity->getType() == 'COMMENTEDONALBUM' && !is_null($activity->getAlbum() && !is_null($activity->getAlbum()->getFromUser()) && !is_null($activity->getComment()) && !is_null($activity->getComment()->getFromUser()))); //serve toUser??
            $commentedOnEvent = ($activity->getType() == 'COMMENTEDONEVENT' && !is_null($activity->getEvent() && !is_null($activity->getEvent()->getFromUser()) && !is_null($activity->getComment()) && !is_null($activity->getComment()->getFromUser()))); //serve toUser??
            $commentedOnImage = ($activity->getType() == 'COMMENTEDONIMAGE' && !is_null($activity->getImage() && !is_null($activity->getImage()->getFromUser()) && !is_null($activity->getComment()) && !is_null($activity->getComment()->getFromUser()))); //serve toUser??
            $commentedOnEventReview = ($activity->getType() == 'COMMENTEDONEVENTREVIEW' && !is_null($activity->getEvent()) && !is_null($activity->getEvent()->getFromUser()) && !is_null($activity->getComment()) && !is_null($activity->getComment()->getFromUser()));  //serve toUser??
            $commentedOnRecord = ($activity->getType() == 'COMMENTEDONRECORD' && !is_null($activity->getRecord()) && !is_null($activity->getRecord()->getFromUser()) && !is_null($activity->getComment()) && !is_null($activity->getComment()->getFromUser())); //serve toUser??
            $commentedOnRecordReview = ($activity->getType() == 'COMMENTEDONRECORDREVIEW' && !is_null($activity->getRecord()) && !is_null($activity->getRecord()->getFromUser()) && !is_null($activity->getComment()) && !is_null($activity->getComment()->getFromUser())); //serve toUser??
            $commentedOnPost = ($activity->getType() == 'COMMENTEDONPOST' && !is_null($activity->getComment()) && !is_null($activity->getComment()->getFromUser()));
            $commentedOnVideo = ($activity->getType() == 'COMMENTEDONVIDEO' && !is_null($activity->getVideo()) && !is_null($activity->getVideo()->getFromUser()));
            $createdAlbum = (($activity->getType() == 'ALBUMCREATED' || $activity->getType() == 'DEFAULTALBUMCREATED' ) && !is_null($activity->getAlbum() && !is_null($activity->getAlbum()->getFromUser())));
            $createdEvent = ($activity->getType() == 'EVENTCREATED' && !is_null($activity->getEvent() && !is_null($activity->getEvent()->getFromUser())));
            $createdRecord = (($activity->getType() == 'RECORDCREATED' || $activity->getType() == 'DEFAULTRECORDCREATED') && !is_null($activity->getRecord() && !is_null($activity->getRecord()->getFromUser())));
            $friendshipRequest = ($activity->getType() == 'FRIENDSHIPREQUEST' && !is_null($activity->getFromUser()) && $activity->getStatus('A') && !is_null($activity->getToUser()) );
            $following = ($activity->getType() == 'FOLLOWING' && !is_null($activity->getFromUser()) && !is_null($activity->getToUser()) );
            $invited = ($activity->getType() == 'INVITED' && !is_null($activity->getEvent()) && !is_null($activity->getEvent()->getFromUser()) && $activity->getStatus('A') && !is_null($activity->getFromUser()));
            $newLevel = ($activity->getType() == 'NEWLEVEL' && !is_null($activity->getFromUser()));
            $newBadge = ($activity->getType() == 'NEWBADGE' && !is_null($activity->getFromUser()));
            $newEventReview = ($activity->getType() == 'NEWEVENTREVIEW' && !is_null($activity->getComment()) && !is_null($activity->getComment()->getFromUser()) && !is_null($activity->getEvent()) && !is_null($activity->getEvent()->getFromUser()));
            $newRecordReview = ($activity->getType() == 'NEWRECORDREVIEW' && !is_null($activity->getComment()) && !is_null($activity->getComment()->getFromUser()) && !is_null($activity->getRecord()) && !is_null($activity->getRecord()->getFromUser()));
            $posted = ($activity->getType() == 'POSTED' && !is_null($activity->getComment()) && !is_null($activity->getComment()->getfromUser()));
            $sharedImage = ($activity->getType() == 'SHAREDIMAGE' && !is_null($activity->getFromUser()));
            $sharedSong = ($activity->getType() == 'SHAREDSONG' && !is_null($activity->getFromUser()));
            $testArray = array($addedPhoto, $addedSong, $collaborationRequest, $commentedOnAlbum, $commentedOnEvent, $commentedOnEventReview, $commentedOnImage, $commentedOnPost, $commentedOnRecord, $commentedOnRecordReview, $commentedOnVideo, $createdAlbum, $createdEvent, $createdRecord, $friendshipRequest, $following, $invited, $newBadge, $newEventReview, $newLevel, $newRecordReview, $posted, $sharedImage, $sharedSong);
            if (in_array(true, $testArray))
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