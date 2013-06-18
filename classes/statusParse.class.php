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

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function deleteStatus($objectId) {
        try {
            $parseObject = new parseObject('Status');
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    public function getStatus($objectId) {
        try {
            $parseObject = new parseObject('Status');
            $res = $parseObject->get($objectId);
            $status = $this->parseToStatus($res);
            return $status;
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    public function getStatuses() {
        $statuses = array();
        $res = $this->parseQuery->find();
        foreach ($res->results as $obj) {
            $status = $this->parseToComment($obj);
            $statuses[$status->getObjectId()] = $status;
        }
        return $statuses;
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
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
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
	

        if ($parseObj == null)
            return null;  //se non ho ricevuto niente...

        $status = new Status();
        
        if(isset($parseObj->objectId))
            $status->setObjectId($parseObj->objectId);
        if(isset($parseObj->active))
            $status->setActive($parseObj->active);
        if(isset($parseObj->commentators)){
            $userParse = new UserParse();
            $commentators = $this->$userParse->getRelatedTo('commentators', 'Status', $parseObj->objectId);
            $status->setCommentators($commentators);
        }
        if(isset($parseObj->comments)){
            $commentParse = new CommentParse();
            $comments = $this->$commentParse->getRelatedTo('comments', 'Status', $parseObj->objectId);
            $status->setComments($comments);
        }
        if(isset($parseObj->counter))
            $status->setCounter($parseObj->counter);
        if (isset($parseObj->event))
            $status->setEvent($parseObj->event);
        if (isset($parseObj->fromUser))
            $status->setFromUser($parseObj->fromUser);
        if (isset($parseObj->image))
            $status->setImage($parseObj->image);
        if(isset($parseObj->location)){
            $parseGeoPoint = new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude);
            $status->setLocation($parseGeoPoint->location);
        }
        if(isset($parseObj->loveCounter))
            $status->setLoveCounter($parseObj->loveCounter);
        if(isset($parseObj->lovers)){
            $userParse = new UserParse();
            $lovers = $this->$userParse->getRelatedTo('lovers', 'Status', $parseObj->objectId);
            $status->setLovers($lovers);
        }
        if (isset($parseObj->song))
            $status->setSong($parseObj->song);
        if(isset($parseObj->text))
            $status->setText($parseObj->text);
        if(isset($parseObj->taggedUsers)){
            $userParse = new UserParse();
            $taggedUsers = $this->$userParse->getRelatedTo('taggedUsers', 'Status', $parseObj->objectId);
            $status->setLovers($taggedUsers);
        }
        if (isset($parseObj->createdAt))
            $status->setCreatedAt(new DateTime($parseObj->createdAt));
        if (isset($parseObj->updatedAt))
            $status->setUpdatedAt(new DateTime($parseObj->updatedAt));
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $status->setACL($acl);
        return $status;
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
		        $error = new error();
                $error->setErrorClass(__CLASS__);
                $error->setErrorCode($e->getCode());
                $error->setErrorMessage($e->getMessage());
                $error->setErrorFunction(__FUNCTION__);
                $error->setErrorFunctionParameter(func_get_args());
                $errorParse = new errorParse();
                $errorParse->saveError($error);
                return $error;
		} else {
			try{
				$ret = $parseObj->save();
				$status->setObjectId($ret->objectId);
				$status->setCreatedAt();
				$status->setUpdatedAt();
			}
		catch(Exception $e) {
		        $error = new error();
                $error->setErrorClass(__CLASS__);
                $error->setErrorCode($e->getCode());
                $error->setErrorMessage($e->getMessage());
                $error->setErrorFunction(__FUNCTION__);
                $error->setErrorFunctionParameter(func_get_args());
                $errorParse = new errorParse();
                $errorParse->saveError($error);
                return $error;
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