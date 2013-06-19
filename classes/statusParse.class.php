<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Stutus Class
 *  \details   Classe status dello User, raccoglie uno stato dell'utente, posso collegarci immagine o song
 *
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:status">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:status">API</a>
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';

require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

require_once CLASSES_DIR . 'image.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';

require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';

require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';


class StatusParse {

    private $parseQuery;

    public function __construct() {

        $this->parseQuery = new ParseQuery("Status");
    }



    public function deleteStatus($objectId) {
        try {
            $parseObject = new parseObject('Status');
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
             return throwError($e,__CLASS__ , __FUNCTION__, func_get_args);
        }
    }
	
	public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getStatus($objectId) {
        try {
            $parseObject = new parseObject('Status');
            $res = $parseObject->get($objectId);
            $status = $this->parseToStatus($res);
            return $status;
        } catch (Exception $e) {
             return throwError($e,__CLASS__ , __FUNCTION__, func_get_args);
        }
    }

	public function getStatuses() {
	try{
        $statuses = array();
        $res = $this->parseQuery->find();
        foreach ($res->results as $obj) {
            $status = $this->parseToStatus($obj);
            $statuses[$status->getObjectId()] = $status;
        }
        return $statuses;
    } catch (Exception $e) {
             return throwError($e,__CLASS__ , __FUNCTION__, func_get_args);
        }
	}

    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    public function parseToStatus(stdClass $parseObj) {
		try{
            $status = new Status();
            $status->setObjectId($parseObj->objectId);
            $status->setActive($parseObj->active);
            $commentators = fromParseRelation('commentators', 'Status', $parseObj->objectId,'_User');
		    $status->setCommentators($commentators);
            $comments = fromParseRelation('comments', 'Status', $parseObj->objectId,'Comment');
		    $status->setComments($comments);
            $status->setCounter($parseObj->counter);
		    $event = fromParsePointer('Event',$parseObj->event);
		    $status->setEvent($event);
            $fromUser = fromParsePointer('_User',$parseObj->fromUser);
		    $status->setFromUser($fromUser);
            $image = fromParsePointer('Image',$parseObj->image);
		    $status->setImage($image);
            $parseGeoPoint = new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude);
			$status->setLocation($parseGeoPoint->location);//location o no?
            $status->setLoveCounter($parseObj->loveCounter);
			$lovers = fromParseRelation('lovers', 'Status', $parseObj->objectId,'_User');
		    $status->setLovers($lovers);
            $song = fromParsePointer('Song',$parseObj->song);
		    $status->setSong($song);
            $status->setText($parseObj->text);
			$taggedUsers = fromParseRelation('taggedUsers', 'Status', $parseObj->objectId,'_User');
			$status->setLovers($taggedUsers);
            if ($parseObj->createdAt)
				$status->setCreatedAt(new DateTime($parseObj->createdAt));
			if ($parseObj->updatedAt)
				$status->setUpdatedAt(new DateTime($parseObj->updatedAt));
			if ($parseObj->ACL)
				$status->setACL($parseObj->ACL);
            return $status;
    } catch(Exception $e) {
			return throwError($e,__CLASS__ , __FUNCTION__, func_get_args);
		}
	}

    public function saveStatus(Status $status) {
            $parseObject = new parseObject('Status');
          
              $status->getActive() === null ? $parseObject->active = null : $parseObject->active = $status->getActive();
              $parseObj->commentators = toParseRelation('_User',$status->getCommentators());
		      $parseObj->comments = toParseRelation('Comment',$status->getComments());
              $status->getCounter() == null ? $parseObject->counter = null : $parseObject->counter = $status->getCounter();
              $parseObj->event = toParsePointer('Event',$status->getEvent());
              $parseObj->featuring = toParseRelation('_User',$status->getFeaturing());
              $parseObj->fromUser = toParsePointer('_User',$status->getFromUser()); 
              $parseObj->image = toParsePointer('Image',$status->getImage());
              $status->getImageFile() == null ? $parseObject->imageFile = null : $parseObject->imageFile = $status->getImageFile();
              $parseObj->location = toParseGeopoint($status->getLocation());
              $status->getLoveCounter() == null ? $parseObject->loveCounter = null : $parseObject->loveCounter = $status->getLoveCounter();
              $parseObj->lovers = toParseRelation('_User,'$status->getLovers());
              $parseObj->song = toParsePointer('Song',$status->getSong());
              $parseObj->taggedUsers = toParseRelation('_User,'$status->getTaggedUsers());
              $status->getText() == null ? $parseObject->text = null : $parseObject->text = $status->getText();
              $parseObj->ACL = toParseACL($status->getACL());
			  if ($status->getObjectId() != null) {
			try{
				$ret = $parseObj->update($status->getObjectId());
				$status->setUpdatedAt($ret->updatedAt, new DateTimeZone("America/Los_Angeles"));
				}
			} catch (Exception $e){
		        return throwError($e,__CLASS__ , __FUNCTION__, func_get_args);
		} else {
			try{
				$ret = $parseObj->save();
				$status->setObjectId($ret->objectId);
				$status->setCreatedAt();
				$status->setUpdatedAt();
			}
		catch(Exception $e) {
		        return throwError($e,__CLASS__ , __FUNCTION__, func_get_args);
		    }
        }
		return $status;
    }

    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    public function where($field, $value) {
        $this->parseQuery->where($field, $value);
    }

    public function whereContainedIn($field, $values) {
        $this->parseQuery->whereContainedIn($field, $values);
    }

    public function whereEqualTo($field, $value) {
        $this->parseQuery->whereEqualTo($field, $value);
    }

    public function whereExists($field) {
        $this->parseQuery->whereExists($field);
    }

    public function whereGreaterThan($field, $value) {
        $this->parseQuery->whereGreaterThan($field, $value);
    }

    public function whereGreaterThanOrEqualTo($field, $value) {
        $this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
    }

    public function whereLessThan($field, $value) {
        $this->parseQuery->whereLessThan($field, $value);
    }

    public function whereLessThanOrEqualTo($field, $value) {
        $this->parseQuery->whereLessThanOrEqualTo($field, $value);
    }

    public function whereNotContainedIn($field, $array) {
        $this->parseQuery->whereNotContainedIn($field, $array);
    }

    public function whereNotEqualTo($field, $value) {
        $this->parseQuery->whereNotEqualTo($field, $value);
    }

    public function whereNotExists($field) {
        $this->parseQuery->whereDoesNotExist($field);
    }

    public function wherePointer($field, $className, $objectId) {
        $this->parseQuery->wherePointer($field, $className, $objectId);
    }
}
?>