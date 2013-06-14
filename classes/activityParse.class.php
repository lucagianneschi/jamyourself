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

        //inizializzo le properties
        //accepted BOOL: da definire																	
        $parseObj->accepted = $activity->getAccepted();

        //BOOL:Indica se l'istanza della classe è attiva 									
        $parseObj->active = $activity->getActive();

        //puntatore alla album
        //Album (Parse Object): Istanza della classe Album associata all'activity 			
        if ($activity->getAlbum() != null) {
            $album = $activity->getAlbum();
            $parseObj->album = array("__type" => "Pointer", "className" => "Album", "objectId" => $album->getObjectId());
        }
        else
            $parseObj->album = null;

        //puntatore alla comment
        //Comment (Parse Object): Istanza della classe Comment associata all'activity		

        if ($activity->getComment() != null) {
            $comment = $activity->getComment();
            $parseObj->comment = array("__type" => "Pointer", "className" => "Comment", "objectId" => $comment->getObjectId());
        }
        else
            $parseObj->comment = null;

//puntatore all'evento
        //Event (Parse Object): Istanza della classe Event associata all'activity           
        if ($activity->getEvent() != null) {
            $event = $activity->getEvent();
            $parseObj->event = array("__type" => "Pointer", "className" => "Event", "objectId" => $event->getObjectId());
        }
        else
            $parseObj->event = null;

        //puntatore al fromUser
        //User:Utente che effettua l'azione 												
        if ($activity->getFromUser() != null) {
            $user = $activity->getFromUser();
            $parseObj->fromUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $user->getObjectId());
        }
        else
            $parseObj->fromUser = null;

        //puntatore all'image
        //Image (Parse Object): Istanza della classe Image associata all'activity           
        if ($activity->getImage() != null) {
            $image = $activity->getImage();
            $parseObj->image = array("__type" => "Pointer", "className" => "Image", "objectId" => $image->getObjectId());
        }
        else
            $parseObj->image = null;

        //puntatore alla question
        //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     
        if ($activity->getPlaylist() != null) {
            $playlist = $activity->getPlaylist();
            $parseObj->playlist = array("__type" => "Pointer", "className" => "Playlist", "objectId" => $playlist->getObjectId());
        }
        else
            $parseObj->playlist = null;

        //puntatore alla question
        //Question (Parse Object): Istanza della classe Question associata all'activity     
        if ($activity->getQuestion() != null) {
            $question = $activity->getQuestion();
            $parseObj->question = array("__type" => "Pointer", "className" => "Question", "objectId" => $question->getObjectId());
        }
        else
            $parseObj->question = null;


        //BOOL:Indica se l'istanza della classe è stata letta o meno 						
        $parseObj->read = $activity->getRead();

        //puntatore alla song
        //Record (Parse Object): Istanza della classe Record associata all'activity 		
        if ($activity->getRecord() != null) {
            $record = $activity->getRecord();
            $parseObj->record = array("__type" => "Pointer", "className" => "Record", "objectId" => $record->getObjectId());
        }
        else
            $parseObj->record = null;

        //puntatore alla song
        //Song (Parse Object): Istanza della classe Song associata all'activity 			
        if ($activity->getSong() != null) {
            $song = $activity->getSong();
            $parseObj->song = array("__type" => "Pointer", "className" => "Song", "objectId" => $song->getObjectId());
        }
        else
            $parseObj->song = null;

        //string:Indica lo status di un'attività del tipo richiesta-accettazione/rifiuto    
        $parseObj->status = $activity->getStatus();

        //puntatore al toUser
        //User:Utente che riceve l'azione 													
        if ($activity->getToUser() != null) {
            $user = $activity->getToUser();
            $parseObj->toUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $user->getObjectId());
        }
        else
            $parseObj->toUser = null;

        //Stringa type
        //string:Indica la tipologia di attività 											
        $parseObj->type = $activity->getType();

        //ACL:access control list, determina le politiche di accesso alla classe 			
        //$parseObj->ACL = $activity->getACL();   //perchè non la prendi?????
        //puntatore allo stato
        //Status(Parse Object): Istanza della classe Status associata all'activity 			
        if ($activity->getUserStatus() != null) {
            $status = $activity->getUserStatus();
            $parseObj->userStatus = array("__type" => "Pointer", "className" => "Status", "objectId" => $status->getObjectId());
        }
        else
            $parseObj->userStatus = null;

        //Video (Parse Object):Istanza della classe Video associata all'activity            
        if ($activity->getVideo() != null) {
            $video = $activity->getVideo();
            $parseObj->video = array("__type" => "Pointer", "className" => "Video", "objectId" => $video->getObjectId());
        }
        else
            $parseObj->video = null;

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
    public function getActivity() {

        $activity = false;

        $result = $this->parseQuery->find();

        if (is_array($result->results) && count($result->results) > 0) {

            $ret = $result->results[0];

            if ($ret) {

                //recupero l'utente
                $activity = $this->parseToActivity($ret);
            }
        }

        return $activity;
    }

    public function getActivities() {

        $activities = false;

        $result = $this->parseQuery->find();

        if (is_array($result->results) && count($result->results) > 0) {

            foreach ($result->results as $activity) {
                if ($activity) {

                    //recupero l'utente
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
        $this->_count = 1;
        $this->_limit = 0;
        return $this->find();
    }

    public function setLimit($int) {
        if ($int >= 1 && $int <= 1000) {
            $this->_limit = $int;
        } else {
            $this->throwError('parse requires the limit parameter be between 1 and 1000');
        }
    }

    public function setSkip($int) {
        $this->_skip = $int;
    }

    public function orderBy($field) {
        if (!empty($field)) {
            $this->_order[] = $field;
        }
    }

    public function orderByAscending($value) {
        if (is_string($value)) {
            $this->_order[] = $value;
        } else {
            $this->throwError('the order parameter on a query must be a string');
        }
    }

    public function orderByDescending($value) {
        if (is_string($value)) {
            $this->_order[] = '-' . $value;
        } else {
            $this->throwError('the order parameter on parseQuery must be a string');
        }
    }

    public function whereInclude($value) {
        if (is_string($value)) {
            $this->_include[] = $value;
        } else {
            $this->throwError('the include parameter on parseQuery must be a string');
        }
    }

    public function where($key, $value) {
        $this->whereEqualTo($key, $value);
    }

    public function whereEqualTo($key, $value) {
        if (isset($key) && isset($value)) {
            $this->_query[$key] = $value;
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function whereNotEqualTo($key, $value) {
        if (isset($key) && isset($value)) {
            $this->_query[$key] = array(
                '$ne' => $value
            );
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function whereGreaterThan($key, $value) {
        if (isset($key) && isset($value)) {
            $this->_query[$key] = array(
                '$gt' => $value
            );
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function whereLessThan($key, $value) {
        if (isset($key) && isset($value)) {
            $this->_query[$key] = array(
                '$lt' => $value
            );
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function whereGreaterThanOrEqualTo($key, $value) {
        if (isset($key) && isset($value)) {
            $this->_query[$key] = array(
                '$gte' => $value
            );
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function whereLessThanOrEqualTo($key, $value) {
        if (isset($key) && isset($value)) {
            $this->_query[$key] = array(
                '$lte' => $value
            );
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function whereContainedIn($key, $value) {
        if (isset($key) && isset($value)) {
            if (is_array($value)) {
                $this->_query[$key] = array(
                    '$in' => $value
                );
            } else {
                $this->throwError('$value must be an array to check through');
            }
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function whereNotContainedIn($key, $value) {
        if (isset($key) && isset($value)) {
            if (is_array($value)) {
                $this->_query[$key] = array(
                    '$nin' => $value
                );
            } else {
                $this->throwError('$value must be an array to check through');
            }
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function whereExists($key) {
        if (isset($key)) {
            $this->_query[$key] = array(
                '$exists' => true
            );
        }
    }

    public function whereDoesNotExist($key) {
        if (isset($key)) {
            $this->_query[$key] = array(
                '$exists' => false
            );
        }
    }

    public function whereRegex($key, $value, $options = '') {
        if (isset($key) && isset($value)) {
            $this->_query[$key] = array(
                '$regex' => $value
            );

            if (!empty($options)) {
                $this->_query[$key]['options'] = $options;
            }
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function wherePointer($key, $className, $objectId) {
        if (isset($key) && isset($className)) {
            $this->_query[$key] = $this->dataType('pointer', array($className, $objectId));
        } else {
            $this->throwError('the $key and $className parameters must be set when setting a "where" pointer query method');
        }
    }

    public function whereInQuery($key, $className, $inQuery) {
        if (isset($key) && isset($className)) {
            $this->_query[$key] = array(
                '$inQuery' => $inQuery,
                'className' => $className
            );
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    public function whereNotInQuery($key, $className, $inQuery) {
        if (isset($key) && isset($className)) {
            $this->_query[$key] = array(
                '$notInQuery' => $inQuery,
                'className' => $className
            );
        } else {
            $this->throwError('the $key and $value parameters must be set when setting a "where" query method');
        }
    }

    /**
     * Example - to find users with a particular role id
     * ES: per trovare gli Utenti in relazione con un Album, dove
     * nella tabella album abbiamo una colonna "userRelation"
     * la query si fa su : $query->parseQuery('_User);
     * $query->whereRelatedTo('users', '_Role', $roleId);
     * 
     * @param type $key = nome colonna del tipo relazione
     * @param type $className = classe di cui si cerca la relazione
     * @param type $objectId = id dell'oggetto di cui si cercano le relazioni
     */
    public function whereRelatedTo($key, $className, $objectId) {
        if (isset($key) && isset($className) && isset($objectId)) {
            if ($className === 'Role')
                $className = '_Role';
            if ($className === 'User')
                $className = '_User';
            $pointer = $this->dataType('pointer', array($className, $objectId));
            $this->_query['$relatedTo'] = $this->dataType('relatedTo', array($pointer, $key));
        } else {
            $this->throwError('the $key and $classname and $objectId parameters must be set when setting a "whereRelatedTo" query method');
        }
    }

}

?>
