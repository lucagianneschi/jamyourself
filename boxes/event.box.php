<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event
 * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'db.service.php';

/**
 * \brief	EventBox class
 * \details	box class to pass info to the view
 */
class EventBox {

    public $error = null;
    public $eventArray = array();

    /**
     * \fn	init($id)
     * \brief	Init EventBox instance for Personal Page
     * \param	$id for user that owns the page
     * \todo    inserire orderby
     */
    public function init($id, $limit = 3, $skip = 0, $upload = false) {
        if ($upload == true) {
            require_once SERVICES_DIR . 'utils.service.php';
            $currentUserId = sessionChecker();
            if (is_null($currentUserId)) {
                $this->error = ONLYIFLOGGEDIN;
                return;
            }
        }
        
        $mysql = new MySQL();
        $events = selectEvents($id, null, array('createdat' => 'DESC'), $limit, $skip);
        $eventArray = $events;
        if ($events instanceof Error) {
            $this->error = //TODO
        }
    }

    /**
     * \fn	initForMediaPage($id)
     * \brief	Init EventBox instance for Media Page
     * \param	$id for event
     */
    public function initForMediaPage($id) {
        $connectionService = new ConnectionService();
        $connectionService->connect();
        if (!$connectionService->active) {
            $this->error = $connectionService->error;
            return;
        } else {
            $sql = "SELECT e.id id_e,
                           e.active,
                           e.address,
                           e.attendeecounter,
                           e.cancelledcounter,
                           e.city,
                           e.commentcounter,
                           e.counter,
                           e.cover,
                           e.description,
                           e.eventdate,
                           e.fromuser,
                           e.genre,
                           e.invitedcounter,
                           e.latitude,
                           e.longitude,
                           e.locationname,
                           e.lovecounter,
                           e.reviewcounter,
                           e.refusedcounter,
                           e.sharecounter,
                           e.thumbnail thumbnail_e,
                           e.title,
                           e.createdat,
                           e.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail thumbnail_u,
                           u.type
                      FROM event e, user u
                     WHERE e.id = " . $id . "
                       AND e.fromuser = u.id";
            $results = mysqli_query($connectionService->connection, $sql);
            while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
                $rows[] = $row;
            $events = array();
            foreach ($rows as $row) {
                require_once 'event.class.php';
                require_once 'user.class.php';
                $event = new Event();
                $event->setId($row['id_e']);
                $event->setActive($row['active']);
                $event->setAddress($row['address']);
                $event->setAttendeecounter($row['attendeecounter']);
                $event->setCancelledcounter($row['cancelledcounter']);
                $event->setCity($row['city']);
                $event->setCommentcounter($row['commentcounter']);
                $event->setCounter($row['counter']);
                $event->setCover($row['cover']);
                $event->setCreatedat($row['createdat']);
                $event->setDescription($row['description']);
                $event->setEventdate($row['eventdate']);
                $fromuser = new User($row_user['type']);
                $fromuser->setId($row_user['id_u']);
                $fromuser->setThumbnail($row_user['thumbnail_u']);
                $fromuser->setUsername($row_user['username']);
                $event->setFromuser($fromuser);
                $event->setGenre($row['genre']);
                $event->setInvitedCounter($row['invitedCounter']);
                $event->setLatitude($row['latitude']);
                $event->setLocationname($row['locationname']);
                $event->setLongitude($row['longitude']);
                $event->setLovecounter($row['lovecounter']);
                $event->setRefusedcounter($row['refusedcounter']);
                $event->setReviewcounter($row['reviewcounter']);
                $event->setSharecounter($row['sharecounter']);
                $event->setTag($row['tag']);
                $event->setThumbnail($row['thumbnail_e']);
                $event->setTitle($row['title']);
                $event->setUpdatedat($row['updatedat']);
                $events[$row['id_e']] = $event;
            }
            $connectionService->disconnect();
            if (!$results) {
                return;
            } else {
                $this->eventArray = $results;
            }
        }
    }

    /**
     * \fn	init($city = null, $type = null, $eventDate = null, $limit = null, $skip = null)
     * \brief	Init EventFilter instance for TimeLine
     * \param	$city = null, $type = null, $eventDate = null, $limit = null, $skip = null;
     * \todo    reimplementare $tags al momento in cui vengono implementati nella vista stream
     */
    public function initForStream($lat = null, $long = null, $city = null, $country = null, $tags = null, $eventDate = null, $limit = null, $skip = null, $distance = null, $unit = 'km', $field = 'loveCounter') {
        require_once SERVICES_DIR . 'utils.service.php';
        $currentUserId = sessionChecker();
        if (is_null($currentUserId)) {
            $this->error = ONLYIFLOGGEDIN;
            return;
        }
    }

}

?>