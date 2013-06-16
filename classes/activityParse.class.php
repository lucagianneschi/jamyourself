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

        $parseObj->album = toParsePointer($activity->getAlbum());	

        $parseObj->comment = toParsePointer($activity->getComment());        

        $parseObj->event = toParsePointer($activity->getEvent());

        $parseObj->fromUser = toParsePointer($activity->getFromUser());

        $parseObj->image = toParsePointer($activity->getImage());

        $parseObj->playlist = toParsePointer($activity->getPlaylist());

        $parseObj->question = toParsePointer($activity->getQuestion());
					
        $parseObj->read = $activity->getRead();

        $parseObj->record = toParsePointer($activity->getRecord());

        $parseObj->song = toParsePointer($activity->getSong());

        $parseObj->status = $activity->getStatus();

        $parseObj->toUser = toParsePointer($activity->getToUser());
										
        $parseObj->type = $activity->getType();

        $parseObj->userStatus = toParsePointer($activity->getUserStatus());

        $parseObj->video = toParsePointer($activity->getVideo());

        //caso update
        if ($activity->getObjectId() != null) {

            try {
                $ret = $parseObj->update($activity->getObjectId());

                $activity->setUpdatedAt($ret->updatedAt);
            } catch (ParseLibraryException $e) {

                return false;
            }
        } else {
            //caso save
            try {
                $ret = $parseObj->save();

                $activity->setObjectId($ret->objectId);

                $activity->setCreatedAt($ret->createdAt);

                $activity->setUpdatedAt($ret->createdAt);
            } catch (ParseLibraryException $e) {

                return false;
            }
        }

        return $activity;
    }

    /**
     * 
     * @param string $activityId
     * @return boolean|Activity
     */
    public function getActivity($objectId){
        $result = (new parseRestClient())->get($objectId);
        return $this->parseToActivity($result);
    }

    public function getActivities(){
        $activities = null;
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
    }

    /**
     * 
     * @param stdClass $parseObj
     * @return boolean|Activity
     */
    public function parseToActivity(stdClass $parseObj) {

        if ($parseObj == null)
            return false;

        $activity = new activity(); //
        //String:objectId su Parse 															
        if (isset($parseObj->objectId))
            $activity->setObjectId($parseObj->objectId);

        //BOOL:Indica se l'istanza della classe è attiva 									
        if (isset($parseObj->active))
            $activity->setActive($parseObj->active);

        //accepted BOOL: da definire	
        if (isset($parseObj->accepted))
            $activity->setAccepted($parseObj->accepted);

        //Album (Parse Object): Istanza della classe Album associata all'activity 			
        if (isset($parseObj->album)) {
            $parseAlbum = new AlbumParse();
            $parseAlbumPointer = $parseObj->album;
            $parseAlbum->wherePointer("album", "Activity", $parseAlbumPointer->objectId);
            $album = $parseAlbum->getAlbum();
            $activity->setAlbum($album);
        }

        //Comment (Parse Object): Istanza della classe Comment associata all'activity		
        if (isset($parseObj->comment)) {
            $parseComment = new CommentParse();
            $parseCommentPointer = $parseObj->comment;
            $parseComment->wherePointer("comment","Activity",$parseCommentPointer->objectId);
            $comment = $parseComment->getComment();
            $activity->setComment($comment);
        }

        //User:Utente che effettua l'azione 											
        if (isset($parseObj->fromUser)) {
            $parseUser = new userParse();
            $parseUserPointer = $parseObj->fromUser;
            $parseUser->wherePointer("fromUser","Activity",$parseUserPointer->objectId);
            $fromUser = $parseUser->getUser();
            $activity->setFromUser($fromUser);
        }

        //Event (Parse Object): Istanza della classe Event associata all'activity           
        if (isset($parseObj->event)) {
            $parseEvent = new EventParse();
            $parseEventPointer = $parseObj->event;
            $parseEvent->wherePointer("event","Activity",$parseEventPointer->objectId);
            $event = $parseEvent->getEvent();
            $activity->setEvent($event);
        }

        //Image (Parse Object): Istanza della classe Image associata all'activity           
        if (isset($parseObj->image)) {
            $parseImage = new ImageParse();
            $parseImagePointer = $parseObj->image;
            $parseImage->wherePointer("image","Activity",$parseImagePointer->objectId);
            $image = $parseImage->getImage();
            $activity->setImage($image);
        }

        //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     
        if (isset($parseObj->playlist)) {
            $parsePlaylist = new PlaylistParse();
            $parsePlaylistPointer = $parseObj->playlist;
            $parsePlaylist->wherePointer("playlist","Activity",$parsePlaylistPointer->objectId);
            $playlist = $parsePlaylist->getPlaylist();
            $activity->setPlaylist($playlist);
        }

        //Question (Parse Object): Istanza della classe Question associata all'activity     
        if (isset($parseObj->question)) {
            $parseQuestion = new QuestionParse();
            $parseQuestionPointer = $parseObj->question;
            $parseQuestion->wherePointer("question","Activity",$parseQuestionPointer->objectId);
            $question = $parseQuestion->getQuestion();
            $activity->setQuestion($question);
        }

        //BOOL:Indica se l'istanza della classe è stata letta o meno 						
        if (isset($parseObj->read))
            $activity->setRead($parseObj->read);

        //Record (Parse Object): Istanza della classe Record associata all'activity 		     
        if (isset($parseObj->record)) {
            $parseRecord = new RecordParse();
            $parseRecordPointer = $parseObj->record;
            $parseRecord->wherePointer("record","Activity",$parseRecordPointer->objectId);
            $record = $parseRecord->getRecord();
            $activity->setRecord($record);
        }

        //Song (Parse Object): Istanza della classe Song associata all'activity 			
        if (isset($parseObj->song)) {
            $parseSong = new SongParse();
            $parseSongPointer = $parseObj->song;
            $parseSong->wherePointer("song","Activity",$parseSongPointer->objectId);
            $song = $parseSong->getSong();
            $activity->setSong($song);
        }

        //string:Indica lo status di un'attività del tipo richiesta-accettazione/rifiuto   
        if (isset($parseObj->stutus))
            $activity->setStatus($parseObj->status);

        //User:Utente che riceve l'azione 													
        if (isset($parseObj->toUser)) {
            $parseUser = new userParse();
            $toUserParse = $parseObj->toUser;
            $parseUser->wherePointer("toUser","Activity",$toUserParse->objectId);
            $toUser = $parseUser->getUser();
            $activity->setToUser($toUser);
        }

        //string:Indica la tipologia di attività 											
        if (isset($parseObj->type))
            $activity->setType($parseObj->type);

        //Status(Parse Object): Istanza della classe Status associata all'activity 			
        if (isset($parseObj->userStatus)) {
            $parseUserStatus = new StatusParse();
            $parseUserStatusPointer = $parseObj->userStatus;
            $parseUserStatus->wherePointer("userStatus","Activity",$parseUserStatusPointer->objectId);
            $userStatus = $parseUserStatus->getStatus();
            $activity->setUserStatus($userStatus);
        }


        //Video (Parse Object):Istanza della classe Video associata all'activity            
        if (isset($parseObj->video)) {
            $parseVideo = new VideoParse();
            $parseVideoPointer = $parseObj->video;
            $parseVideo->wherePointer("video","Activity",$parseVideoPointer->objectId);
            $video = $parseVideo->getVideo();
            $activity->setVideo($video);
        }

        //DateTime:Data di inserimento attività 											
        if (isset($parseObj->createdAt)) {
            $createdAt = new DateTime($parseObj->createdAt);
            $activity->setCreatedAt($createdAt);
        }

        //DateTime:Data di ultimo update attività 											
        if (isset($parseObj->updatedAt)) {
            $updatedAt = new DateTime($parseObj->updatedAt);
            $activity->setUpdatedAt($updatedAt);
        }

        //ACL:access control list, determina le politiche di accesso alla classe 			
        if (isset($parseObj->ACL)) {
            $ACL = null;
            $activity->setACL($ACL);
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
