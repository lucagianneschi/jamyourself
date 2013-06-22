<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Playslist
 *  \details   Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:activity">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:activity">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';

require_once CLASSES_DIR . 'imageParse.class.php';
require_once CLASSES_DIR . 'image.class.php';

require_once CLASSES_DIR . 'playlistParse.class.php';
require_once CLASSES_DIR . 'playlist.class.php';

require_once CLASSES_DIR . 'questionParse.class.php';
require_once CLASSES_DIR . 'question.class.php';

require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'record.class.php';

require_once CLASSES_DIR . 'songParse.class.php';
require_once CLASSES_DIR . 'song.class.php';

require_once CLASSES_DIR . 'statusParse.class.php';
require_once CLASSES_DIR . 'status.class.php';

require_once CLASSES_DIR . 'videoParse.class.php';
require_once CLASSES_DIR . 'video.class.php';

class ActivityParse {

    private $parseQuery;

    public function __construct() {

        $this->parseQuery = new ParseQuery("Activity");
    }

    /**
     * Salva un Activity nel DB di parse
     * @param Activity $activity
     */
    public function save(Activity $activity) {

        //creo un'istanza dell'oggetto della libreria ParseLib
        $parseObj = new parseObject("Activity");

        $parseObj->accepted = $activity->getAccepted();

        $parseObj->active = $activity->getActive();

        $parseObj->album = toParsePointer("Album", $activity->getAlbum());

        $parseObj->comment = toParsePointer("Comment", $activity->getComment());

        $parseObj->event = toParsePointer("Event", $activity->getEvent());

        $parseObj->fromUser = toParsePointer("_User", $activity->getFromUser());

        $parseObj->image = toParsePointer("Image", $activity->getImage());

        $parseObj->playlist = toParsePointer("Playlist", $activity->getPlaylist());

        $parseObj->question = toParsePointer("Question", $activity->getQuestion());

        $parseObj->read = $activity->getRead();

        $parseObj->record = toParsePointer("Record", $activity->getRecord());

        $parseObj->song = toParsePointer("Song", $activity->getSong());

        $parseObj->status = $activity->getStatus();

        $parseObj->toUser = toParsePointer("_User", $activity->getToUser());

        $parseObj->type = $activity->getType();

        $parseObj->userStatus = toParsePointer("_User", $activity->getUserStatus());

        $parseObj->video = toParsePointer("Video", $activity->getVideo());

        $parseObj->ACL = toParseACL($activity->getACL());

        //caso update
        if ($activity->getObjectId() != null) {

            try {
                $ret = $parseObj->update($activity->getObjectId());
                $activity->setUpdatedAt(fromParseDate($ret->updatedAt));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        } else {
            //caso save
            try {
                $ret = $parseObj->save();
                $activity->setObjectId($ret->objectId);
                $activity->setCreatedAt(fromParseDate($ret->createdAt));
                $activity->setUpdatedAt(fromParseDate($ret->createdAt));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        }
        return $activity;
    }

    public function deleteActivity($activity) {
        $activity->setActive(false);
        return $this->save($activity);
    }

    /**
     * 
     * @param string $activityId
     * @return boolean|Activity
     */
    public function getActivity($objectId) {
        try {
            $parseRestClient = new parseRestClient();
            $result = $parseRestClient->get($objectId);
            return $this->parseToActivity($result);
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function getActivities() {
        $activities = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $activities = array();
                foreach ($result->results as $activity) {
                    if ($activity) {
                        $activities[] = $this->parseToActivity($activity);
                    }
                }
            }
            return $activities;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * 
     * @param stdClass $parseObj
     * @return boolean|Activity
     */
    public function parseToActivity(stdClass $parseObj) {

        if ($parseObj == null || !isset($parseObj->objectId))
            return false;

        $activity = new activity();

        try {

            $activity->setObjectId($parseObj->objectId);

            $activity->setActive($parseObj->active);

            $activity->setAccepted($parseObj->accepted);

            $activity->setAlbum(fromParsePointer($parseObj->album));

            $activity->setComment(fromParsePointer($parseObj->comment));

            $activity->setFromUser(fromParsePointer($parseObj->fromUser));

            $activity->setEvent(fromParsePointer($parseObj->event));

            $activity->setImage(fromParsePointer($parseObj->image));

            $activity->setPlaylist(fromParsePointer($parseObj->playlist));

            $activity->setQuestion(fromParsePointer($parseObj->question));

            $activity->setRead($parseObj->read);

            $activity->setRecord(fromParsePointer($parseObj->record));

            $activity->setSong(fromParsePointer($parseObj->song));

            $activity->setStatus($parseObj->status);

            $activity->setToUser(fromParsePointer($parseObj->toUser));

            $activity->setType($parseObj->type);

            $activity->setUserStatus(fromParsePointer($parseObj->userStatus));

            $activity->setVideo(fromParsePointer($parseObj->video));

            $activity->setCreatedAt(fromParseDate($parseObj->createdAt));

            $activity->setUpdatedAt(fromParseDate($parseObj->updatedAt));

            $activity->setACL(fromParseACL($parseObj->ACL));
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
        return $activity;
    }

//*************************************************************************/    
//     
//     Metodi tipici delle classi parse
//     
//*************************************************************************/
    public function getCount() {
        $this->parseQuery->getCount();
    }

    public function setLimit($int) {
        $this->parseQuery->setLimit($int);
    }

    public function setSkip($int) {
        $this->parseQuery->setSkip($int);
    }

    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    public function orderByAscending($value) {
        $this->parseQuery->orderByAscending($value);
    }

    public function orderByDescending($value) {
        $this->parseQuery->orderByDescending($value);
    }

    public function whereInclude($value) {
        $this->parseQuery->whereInclude($value);
    }

    public function where($key, $value) {
        $this->parseQuery->where($key, $value);
    }

    public function whereEqualTo($key, $value) {
        $this->parseQuery->whereEqualTo($key, $value);
    }

    public function whereNotEqualTo($key, $value) {
        $this->parseQuery->whereNotEqualTo($key, $value);
    }

    public function whereGreaterThan($key, $value) {
        $this->parseQuery->whereGreaterThan($key, $value);
    }

    public function whereLessThan($key, $value) {
        $this->parseQuery->whereLessThan($key, $value);
    }

    public function whereGreaterThanOrEqualTo($key, $value) {
        $this->parseQuery->whereGreaterThanOrEqualTo($key, $value);
    }

    public function whereLessThanOrEqualTo($key, $value) {
        $this->parseQuery->whereLessThanOrEqualTo($key, $value);
    }

    public function whereContainedIn($key, $value) {
        $this->parseQuery->whereContainedIn($key, $value);
    }

    public function whereNotContainedIn($key, $value) {
        $this->parseQuery->whereNotContainedIn($key, $value);
    }

    public function whereExists($key) {
        $this->parseQuery->whereExists($key);
    }

    public function whereDoesNotExist($key) {
        $this->parseQuery->whereDoesNotExist($key);
    }

    public function whereRegex($key, $value, $options = '') {
        $this->parseQuery->whereRegex($key, $value, $options = '');
    }

    public function wherePointer($key, $className, $objectId) {
        $this->parseQuery->wherePointer($key, $className, $objectId);
    }

    public function whereInQuery($key, $className, $inQuery) {
        $this->parseQuery->whereInQuery($key, $className, $inQuery);
    }

    public function whereNotInQuery($key, $className, $inQuery) {
        $this->parseQuery->whereNotInQuery($key, $className, $inQuery);
    }

    public function whereRelatedTo($key, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($key, $className, $objectId);
    }

}

?>
