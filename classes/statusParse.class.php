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

class StatusParse {

    private $parseQuery;

    public function __construct() {

        $this->parseQuery = new ParseQuery("Status");
    }

    public function getStatus() {
        $status = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $ret = $result->results[0];
            if ($ret) {
                //recupero l'utente
                $status = $this->parseToStatus($ret);
            }
        }
        return $status;
    }

    public function getStatuses() {
        $statuses = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $statuses = array();
            foreach (($result->results) as $status) {
                $statuses [] = $this->parseToStatus($status);
            }
        }
        return $statuses;
    }

    public function saveStatus(Status $status) {

        $parse = new parseObject("Status");
        $parse->active = $status->getActive();
        if ($status->getCommentators() != null && count($status->getCommentators()) > 0) {
            $arrayPointer = array();
            foreach ($status->getCommentators() as $user) {
                $pointer = $parse->dataType("pointer", array("_User"), $user->getObjectId());
                array_push($arrayPointer, $pointer);
            }
            $parse->commentators = $user->dataType("relation", $arrayPointer);
        } else {
            $parse->commentators = null;
        }
        if ($status->getComments() != null && count($status->getComments()) > 0) {
            $arrayPointer = array();
            foreach ($status->getComments() as $comment) {
                $pointer = $parse->dataType("pointer", array("Comment"), $comment->getObjectId());
                array_push($arrayPointer, $pointer);
            }
            $parse->comments = $comment->dataType("relation", $arrayPointer);
        } else {
            $parse->comments = null;
        }
        $parse->counter = $status->getCounter();
        if (($event = $status->getEvent()) != null) {
            $pointerParse = $parse->dataType("pointer", array("Event"), $event->getObjectId());
            $parse->event = $pointerParse;
        } else {
            $parse->event = null;
        }
        if (($fromUser = $parse->getFromUser()) != null) {
            $pointerParse = $parse->dataType("pointer", array("_User"), $fromUser->getObjectId());
            $parse->fromUser = $pointerParse;
        } else {
            $parse->fromUser = null;
        }
        if (($image = $parse->getImage()) != null) {
            $pointerParse = $parse->dataType("pointer", array("Image"), $image->getObjectId());
            $parse->image = $pointerParse;
        } else {
            $parse->image = null;
        }
        if (($geoPoint = $parse->getLocation()) != null) {
            $parseLocation = $parse->dataType("geopoint",array($geoPoint->latitude, $geoPoint->longitude));
            $parse->location = $parseLocation;
        } else {
            $parse->location = null;
        }
        $parse->loveCounter = $status->getLoveCounter();
        if ($status->getLovers() != null && count($status->getLovers()) > 0) {
            $arrayPointer = array();
            foreach ($status->getLovers() as $user) {
                $pointer = $parse->dataType("pointer", array("_User"), $user->getObjectId());
                array_push($arrayPointer, $pointer);
            }
            $parse->lovers = $user->dataType("relation", $arrayPointer);
        } else {
            $parse->lovers = null;
        }
        if (($song = $status->getSong()) != null) {
            $pointerParse = $parse->dataType("pointer", array("Song"), $image->getObjectId());
            $parse->song = $pointerParse;
        } else {
            $parse->song = null;
        }
        if ($status->getTaggedUsers() != null && count($status->getTaggedUsers()) > 0) {
            $arrayPointer = array();
            foreach ($status->getTaggedUsers() as $user) {
                $pointer = $parse->dataType("pointer", array("_User"), $user->getObjectId());
                array_push($arrayPointer, $pointer);
            }
            $parse->taggedUsers = $user->dataType("relation", $arrayPointer);
        } else {
            $parse->taggedUsers = null;
        }
        $parse->text = $status->getText();
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $parse->setACL($acl);

        //se esiste l'objectId vuol dire che devo aggiornare
        //se non esiste vuol dire che devo salvare
        if (( $status->getObjectId()) != null) {
            //update
            try {
                //update
                $result = $parse->update($status->getObjectId());

                //aggiorno l'update
                $status->setUpdatedAt(new DateTime($result->updatedAt, new DateTimeZone("America/Los_Angeles")));
            } catch (Exception $e) {
                $error = new error();
                $error->setErrorClass(__CLASS__);
                $error->setErrorCode($e->getCode());
                $error->setErrorMessage($e->getMessage());
                $error->setErrorFunction(__FUNCTION__);
                $error->setErrorFunctionParameter(func_get_args());
                $errorParse = new errorParse();
                $errorParse->saveError($error);
            }
        } else {

            try {
                //salvo
                $result = $parse->save();

                //aggiorno i dati per la creazione
                $status->setObjectId($result->objectId);
                $status->setCreatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
                $status->setUpdatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
            } catch (Exception $e) {
                $error = new error();
                $error->setErrorClass(__CLASS__);
                $error->setErrorCode($e->getCode());
                $error->setErrorMessage($e->getMessage());
                $error->setErrorFunction(__FUNCTION__);
                $error->setErrorFunctionParameter(func_get_args());
                $errorParse = new errorParse();
                $errorParse->saveError($error);
            }
        }

        //restituisco status aggiornato
        return $status;
    }

    public function deleteStatus(Status $status) {
        $status->setActive(false);
        if ($this->save($status))
            return true;
        else
            return false;
    }
    public function parseToStatus(stdClass $parseObj) {

        if ($parseObj == null)
            return null;  //se non ho ricevuto niente...


//lo status da restituire
        $status = new status();

        //recupero objectId
        if (isset($parseObj->objectId))
            $status->setObjectId($parseObj->objectId);
        //recupero Active
        if (isset($parseObj->active))
            $status->setActive($parseObj->active);
        //array di puntatori ad User
        if (isset($parseObj->commentators)) {
            $parseQueryUser = new UserParse();
            $parseQueryUser->whereRelatedTo('commentators', 'Status', $parseObj->objectId);
            $status->setCommentators($parseQueryUser->getUsers());
        } else {
            $status->commentators = null;
        }
        if (isset($parseObj->comments)) {
            $parseQueryComments = new CommentParse();
            $parseQueryComments->whereRelatedTo('comments', 'Status', $parseObj->objectId);
            $status->setComments($parseQueryComments->getComments());
        } else{
            $status->comments = null;
        }
        if (isset($parseObj->counter)){
            $status->setCounter($parseObj->counter);
        } else {
            $status->counter = 0;
        }
        if (isset($parseObj->event)) {
            $parseQueryEvent = new ImageParse();
            $parseQueryEvent->whereEqualTo("objectId", $parseObj->event);
            $status->setEvent($parseQueryEvent);
        } else {
            $status->event = null;
        }
        if (isset($parseObj->fromUser)) {
            $parseQueryUser = new UserParse();
            $parseQueryUser->whereEqualTo("objectId", $parseObj->fromUser);
            $status->setFromUser($parseQueryUser);
        }  else {
            $status->fromUser = null;
        }
        if (isset($parseObj->image)) {
            $parseQueryImage = new ImageParse();
            $parseQueryImage->whereEqualTo("objectId", $parseObj->image);
            $status->setImage($parseQueryImage);
        } else {
            $status->image = null;
        }
        if (isset($parseObj->location)) {
                $geoParse = $parseObj->location;
                $tempObj = new parseObject("temp");
                $location = $tempObj->dataType("geopoint", array($geoParse->latitude, $geoParse->longitude));
                $status->setLocation($location);
        } else {
            $status->location = null;
        }
        //recupero il loveCounter
        if (isset($parseObj->loveCounter)){
        $status->setCounter($parseObj->loveCounter);
        } else {
            $status->loveCounter = 0;
        }
        if (isset($parseObj->lovers)) {
            $parseQueryUser = new UserParse();
            $parseQueryUser->whereRelatedTo('lovers', 'Status', $parseObj->objectId);
            $status->setLovers($parseQueryUser->getUsers());
        } else {
            $status->lovers = null;
        }
        if (isset($parseObj->song)) {
            $parseQuerySong = new ImageParse();
            $parseQuerySong->whereEqualTo("objectId", $parseObj->song);
            $status->setSong($parseQuerySong);
        }else {
            $status->song = null;
        }
        if (isset($parseObj->text))
            $status->setText($parseObj->text);
        if (isset($parseObj->taggedUsers)) {
            $parseQueryUser = new UserParse();
            $parseQueryUser->whereRelatedTo('taggedUsers', 'Status', $parseObj->objectId);
            $status->setTaggedUsers($parseQueryUser->getUsers());
        } else {
            $status->taggedUsers = null;
        }
        //creo la data di tipo DateTime per createdAt e updatedAt
        if (isset($parseObj->createdAt))
            $status->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
        if (isset($parseObj->updatedAt))
            $status->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $status->setACL($acl);
        return $status;
    }

}

?>