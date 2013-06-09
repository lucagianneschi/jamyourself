<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Stutus Parse Class
 *  \details   Classe Parse dedicata allo status dello User
 *
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:status">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:status">API</a>
 */

class UserParse {

    private $parseQuery;

    public function __construct() {
        $this->parseQuery = new ParseQuery("_User");
    }

    public function getUser($objectId) {
        $res = $this->parseQuery->get($objectId);
        $user = $this->parseToUser($res);
        return $user;
    }

    public function getUsers() {
        $users = array();
        $res = $this->parseQuery->find();
        foreach ($res->results as $obj) {
            $users[] = $this->parseToUser($obj);
        }
        return $users;
    }

    /**
     * Effettua la registrazione dell'utente
     * fondamentali esistano e effettuo il salvataggio nel DB
     *
     */
    function saveUser(User $user) {

        if ($user == null)
            return null;

        $parseUser = new parseUser();


        //inizializzo l'utente a seconda del profilo
        if ($user->getType() == "JAMMER") {

            if ($user->getCollaboration() != null && count($user->getCollaboration()) > 0) {
                $arrayPointer = array();
                foreach ($user->getCollaboration() as $collaboration) {
                    $pointer = $parseUser->dataType('pointer', array('_User', $collaboration->getObjectId()));
                    $arrayPointer[] = $pointer;
                }
                $parseUser->collaboration = $parseUser->dataType("relation", $arrayPointer);
            } else {
                $parseUser->collaboration = null;
            }

            if ($user->getEvents() != null && count($user->getEvents()) > 0) {
                $arrayPointer = array();
                foreach ($user->getEvents() as $event) {
                    $pointer = $parseUser->dataType('pointer', array('Event', $event->getObjectId()));
                    $arrayPointer[] = $pointer;
                }
                $parseUser->events = $parseUser->dataType("relation", $arrayPointer);
            } else {
                $parseUser->events = null;
            }

            $parse->jammerType = $user->getJammerType();

            if ($user->getMembers() != null && count($user->getMembers()) > 0) {
                $parse->members = $user->getMembers();
            } else {
                $parse->members = null;
            }

            if ($user->getRecords() != null && count($user->getRecords()) > 0) {
                $arrayPointer = array();
                foreach ($user->getRecords() as $record) {
                    $pointer = $parseUser->dataType('pointer', array('Record', $record->getObjectId()));
                    $arrayPointer[] = $pointer;
                }
                $parseUser->records = $parseUser->dataType("relation", $arrayPointer);
            } else {
                $parseUser->records = null;
            }

            if ($user->getSongs() != null && count($user->getSongs()) > 0) {
                $arrayPointer = array();
                foreach ($user->getSongs() as $song) {
                    $pointer = $parseUser->dataType('pointer', array('Song', $song->getObjectId()));
                    $arrayPointer[] = $pointer;
                }
                $parseUser->songs =  $parseUser->dataType("relation", $arrayPointer);
            } else {
                $parseUser->songs = null;
            }

            
        }


        if ($user->getType() == "SPOTTER") {

            //formatto l'anno di nascita
            if ($user->getBirthDay() != null) {
                //birthDay e' un tipo DateTime
                $user->birthDay = $parseUser->dataType('date', $user->getBirthDay()->format('r'));
            } else {
                $user->birthDay() = null;
            }

            $parseUser->facebookId = $user->getFacebookId();

            ###################### QUI ######################

            $parse->firstname = $user->getFirstname();

            if ($user->getFollowing() != null || count($user->getFollowing()) > 0) {
                foreach ($user->getFollowing() as $user) {
                    $parse->following->__op = "AddRelation";
                    $parse->following->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user->getObjectId())));
                }
            } else {
                $parse->following = null;
            }

            if ($user->getFriendship() != null || count($user->getFriendship()) > 0) {
                foreach ($user->getFriendship() as $user) {
                    $parse->friendship->__op = "AddRelation";
                    $parse->friendship->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user->getObjectId())));
                }
            } else {
                $parse->friendship = null;
            }

            $parse->lastname = $user->getLastname();
            $parse->sex = $user->getSex();
        }

        if ($user->getType() == "VENUE") {
            $parse->address = $user->getAddress();

            if ($user->getCollaboration() != null || count($user->getCollaboration()) > 0) {
                foreach ($user->getCollaboration() as $collaborator) {
                    $parse->collaboration->__op = "AddRelation";
                    $parse->collaboration->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($collaborator->getObjectId())));
                }
            } else {
                $parse->collaboration = null;
            }

            if ($user->getEvents() != null || count(getEvents()) > 0) {
                foreach ($user->getEvents() as $event) {
                    $parse->events->__op = "AddRelation";
                    $parse->events->objects = array(array("__type" => "Pointer", "className" => "Event", "objectId" => ($event->getObjectId())));
                }
            } else {
                $parse->collaboration = null;
            }

            $parse->localType = $user->getLocalType();
        }

        //poi recupero i dati fondamentali (che appartengono a tutti gli utenti)
        $parse->username = $user->getUsername();
        //$parse->password = $user->getPassword(); VANNO MESSI?
        //$parse->authData; = $user->getAuthData;(); VANNO MESSI?
        $parse->ID = $user->getID();
        $parse->active = $user->getActive();


        if ($user->getAlbums() != null || count(getAlbums()) > 0) {
            foreach ($user->getAlbums() as $album) {
                $parse->albums->__op = "AddRelation";
                $parse->albums->objects = array(array("__type" => "Pointer", "className" => "Album", "objectId" => ($album->getObjectId())));
            }
        } else {
            $parse->albums = null;
        }


        $parse->background = $user->getBackground();
        $parse->city = $user->getCity();

        if ($user->getComments() != null || count(getComments()) > 0) {
            foreach ($user->getComments() as $comment) {
                $parse->comments->__op = "AddRelation";
                $parse->comments->objects = array(array("__type" => "Pointer", "className" => "Comment", "objectId" => ($comment->getObjectId())));
            }
        } else {
            $parse->comments = null;
        }

        $parse->country = $user->getCountry();
        $parse->description = $user->getDescription();
        $parse->email = $user->getEmail();
        $parse->fbPage = $user->getFbPage();

        if ($user->getGeoCoding()) {
            $geo = $user->getGeoCoding();
            $parse->geoCoding = $geo->location;
        }

        if ($user->getImages() != null || count(getImages()) > 0) {
            foreach ($user->getImages() as $image) {
                $parse->images->__op = "AddRelation";
                $parse->images->objects = array(array("__type" => "Pointer", "className" => "Image", "objectId" => ($image->getObjectId())));
            }
        } else {
            $parse->images = null;
        }


        $parse->level = $user->getLevel();
        $parse->levelValue = $user->getLevelValue();

        if ($user->getLoveSongs() != null || count(getLoveSongs()) > 0) {
            foreach ($user->getLoveSongs() as $song) {
                $parse->loveSongs->__op = "AddRelation";
                $parse->loveSongs->objects = array(array("__type" => "Pointer", "className" => "Song", "objectId" => ($song->getObjectId())));
            }
        } else {
            $parse->loveSongs = null;
        }

        if ($user->getMusic() != null || count($user->getMusic()) > 0) {
            $parse->music = $user->getMusic();
        } else {
            $parse->music = null;
        }

        if ($user->getPlaylists() != null || count(getPlaylists()) > 0) {
            foreach ($user->getPlaylists() as $playlist) {
                $parse->playlists->__op = "AddRelation";
                $parse->playlists->objects = array(array("__type" => "Pointer", "className" => "Playlist", "objectId" => ($playlist->getObjectId())));
            }
        } else {
            $parse->playlists = null;
        }


        $parse->premium = $user->getPremium();
        $parse->premiumExpirationDate = $user->getPremiumExpirationDate();
        $parse->profilePicture = $user->getProfilePicture();
        $parse->profileThumbnail = $user->getProfileThumbnail();
        $parse->settings = $user->getSettings();

        if ($user->getStatuses() != null || count(getStatuses()) > 0) {
            foreach ($user->getStatuses() as $status) {
                $parse->statuses->__op = "AddRelation";
                $parse->statuses->objects = array(array("__type" => "Pointer", "className" => "Status", "objectId" => ($status->getObjectId())));
            }
        } else {
            $parse->statuses = null;
        }

        $parse->twitterPage = $user->getTwitterPage();
        $parse->type = $user->getType();

        if ($user->getVideos() != null || count($user->getVideos()) > 0) {
            foreach ($user->getVideos() as $video) {
                $parse->videos->__op = "AddRelation";
                $parse->videos->objects = array(array("__type" => "Pointer", "className" => "Video", "objectId" => ($video->getObjectId())));
            }
        } else {
            $parse->videos = null;
        }

        $parse->website = $user->getWebsite();
        $parse->youtubeChannel = $user->getYoutubeChannel();

        if ($user->getObjectId() != null) {

            //update

            try {

                $ret = $parse->update($user->getObjectId(), $user->getSessionToken());

                /** esempio di risposta:
                 *  $ret->updatedAt "2013-05-04T15:03:03.151Z";
                 */
                $user->setUpdatedAt(new DateTime($ret->updatedAt, new DateTimeZone("America/Los_Angeles")));
            } catch (ParseLibraryException $error) {
                return false;
            }
        } else {
            //registrazione

            $parse->password = $user->getPassword();

            try {

                $ret = $parse->signup($user->getUsername(), $user->getPassword());

                /**
                 * Esempio di risposta: un oggetto di tipo stdObj cos� fatto:
                 * $ret->emailVerified = true/false
                 * $ret->createdAt = "2013-05-04T12:04:45.535Z"
                 * $ret->objectId = "OLwLSZQtNF"
                 * $ret->sessionToken = "qeutglxlz2k7cgzm3vgc038bf"
                 */
                $user->setEmailVerified($ret->emailVerified);
                $user->setSessionToken($ret->sessionToken);
                $user->setCreatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
                $user->setUpdatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
                $user->setObjectId($ret->objectId);
                //$user->setACL($ret->ACL);
            } catch (ParseLibraryException $error) {
                return false;
            }
        }
        return $user;
    }

    /**
     * Effettua il login dell'utente fornendo un utente che deve avere qualche parametro impostato, dopodich� creo uno User specifico
     * e lo restituisco.
     */
    function login(User $user) {

        //o la mail o lo username!
        if (($user == null) || ( $user->getUsername() == null || $user->getEmail() == null ) && $user->getPassword() == null)
            return false;
        $parse = new parseUser();

        //login tramite username o email
        if ($user->getUsername() == null)
            $parse->username = $this->getUserIdByMail($user->getEmail());
        else
            $parse->username = $user->getUsername();

        $parse->password = $user->getPassword();

        try {

            $ret = $parse->login();

            if ($ret) {

                $user = $this->parseToUser($ret);
            }
        } catch (ParseLibraryException $e) {

            return false;
        }

        return $user;
    }

    /**
     * La funzione di Logout non ha effetti nel DB, probabilmente
     * si dovr� agire probabilmente sulle Activity
     *
     */
    function logout() {

        if (isset($_SESSION['user_id'])) {

            unset($_SESSION['user_id']);

            //al logout devo sempre distruggere la sessione

            session_destroy();
        }
    }

    /**
     * Inizializza un oggetto Utente recuperandolo tramite l'id
     */
    function getUserById($user_id) {

        $user = null;

        $this->parseQuery->where('objectId', $user_id);

        $result = $this->parseQuery->find();

        if (is_array($result->results) && count($result->results) > 0) {

            $ret = $result->results[0];

            if ($ret) {

                //recupero l'utente
                $user = $this->parseToUser($ret);
            }
        }

        return $user;
    }

    /**
     * Restituisce un array di utenti recuperati tramite un array di id passato per argomento
     * @param array $userArray
     * @return multitype:
     */
    function getUserArrayById(array $userArray) {

        $array = array();

        foreach ($userArray as $user_id) {
            array_push($array, $this->getUserById($user_id));
        }

        return $array;
    }

    /**
     * Cancellazione utente: imposta il flag active a false
     * @param User $user l'utente da cancellare
     * @return boolean true in caso di successo, false in caso di fallimento
     */
    function delete(User $user) {

        //solo l'utente corrente pu� cancellare se stesso
        if ($user) {
            $user->setActive(false);

            if ($this->save($user))
                return true;
            else
                return false;
        }
        else
            return false;
    }

    /*     * Restituisce lo username di un utente
     * in base alla sua mail
     * (serve per il login differenziato)
     */

    function getUserIdByMail($email) {

        $this->parseQuery->where('email', $email);

        $result = $this->parseQuery->find();

        if (is_array($result->results) && count($result->results) > 0) {

            $ret = $result->results[0];

            if ($ret) {

                //poi recupero i dati fondamentali (che appartengono a tutti gli utenti)

                if (isset($ret->username))
                    return $ret->username;
            }
        }

        return false;
    }

    /**
     * Recupera un utente in base al suo username
     * @param string $username
     * @return Ambigous <NULL, User>
     */
    public function getUserByUsername($username) {

        $user = null;

        $this->parseQuery->where('username', $username);

        $result = $this->parseQuery->find();

        if (is_array($result->results) && count($result->results) > 0) {

            $ret = $result->results[0];

            if ($ret) {

                //poi recupero i dati fondamentali (che appartengono a tutti gli utenti)

                $user = $this->parseToUser($ret);
            }
        }

        return $user;
    }

    public function parseToUser(stdClass $parseObj) {

        $user = null;

        if ($parseObj && isset($parseObj->type)) {

            //inizializzo l'utente a seconda del profilo

            switch ($parseObj->type) {
                case "SPOTTER":

                    $user = new Spotter();

                    if (isset($parseObj->birthDay))
                        $user->setBirthDay(new DateTime($parseObj->birthDay->iso, new DateTimeZone("America/Los_Angeles")));
                    if (isset($parseObj->facebookId))
                        $user->setFacebookId($parseObj->facebookId);
                    if (isset($parseObj->firstname))
                        $user->setFirstname($parseObj->firstname);
                    if (isset($parseObj->following))
                        $user->setFollowing($parseObj->following); //MODIFICARE
                    if (isset($parseObj->friendship))
                        $user->setFriendship($parseObj->friendship); //MODIFICARE
                    if (isset($parseObj->lastname))
                        $user->setLastname($parseObj->lastname);
                    if (isset($parseObj->sex))
                        $user->setSex($parseObj->sex);
                    break;

                case "JAMMER":

                    $user = new Jammer();

                    if (isset($parseObj->collaboration))
                        $user->setCollaboration($parseObj->collaboration); //MODIFICARE
                    if (isset($parseObj->events))
                        $user->setEvents($parseObj->events);
                    if (isset($parseObj->members))
                        $user->setMembers($parseObj->members);
                    if (isset($parseObj->records))
                        $user->setRecords($parseObj->records); //MODIFICARE
                    if (isset($parseObj->songs))
                        $user->setSongs($parseObj->songs); //MODIFICARE
                    if (isset($parseObj->jammerType))
                        $user->setJammerType($parseObj->jammerType);
                    break;

                case "VENUE":

                    $user = new Venue();

                    /* visto che deve essere un geopoint */ //questo è sbagliato! dalla stringa si ricavano le coordinate e si mettono dentro la property geoCoding!
                    //MODIFICARE!
                    if (isset($parseObj->address)) {
                        //recupero il GeoPoint
                        $geoParse = $parseObj->address;
                        $geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
                        //aggiungo lo status
                        $user->setAddress($geoPoint);
                    }

                    if (isset($parseObj->collaboration))
                        $user->setCollaboration($parseObj->collaboration); //MODIFICARE
                    if (isset($parseObj->events))
                        $user->setEvents($parseObj->events); //MODIFICARE
                    if (isset($parseObj->localType))
                        $user->setLocalType($parseObj->localType);

                    break;
            }

            //poi recupero i dati fondamentali (che appartengono a tutti gli utenti)
            if (isset($parseObj->objectId))
                $user->setObjectId($parseObj->objectId);
            if (isset($parseObj->username))
                $user->setUsername($parseObj->username);
            //if( isset($parseObj->password ) )$user->setPassword($parseObj->password); VA MESSO??
            //if( isset($parseObj->authData ) )$user->setAuthData($parseObj->authData); VA MESSO??
            if (isset($parseObj->emailVerified))
                $user->setEmailVerified($parseObj->emailVerified);
            if (isset($parseObj->ID))
                $user->setID($parseObj->ID); //RIMUOVERE DOPO ALLINEAMENTO DB
            if (isset($parseObj->active))
                $user->setActive($parseObj->active);
            if (isset($parseObj->albums))
                $user->setAlbums($parseObj->albums); //MODIFICARE
            if (isset($parseObj->background))
                $user->setBackground($parseObj->background);
            if (isset($parseObj->city))
                $user->setCity($parseObj->city);
            if (isset($parseObj->country))
                $user->setCountry($parseObj->country);
            if (isset($parseObj->description))
                $user->setDescription($parseObj->description);
            if (isset($parseObj->email))
                $user->setEmail($parseObj->email);
            if (isset($parseObj->fbPage))
                $user->setFbPage($parseObj->fbPage);
            if (isset($parseObj->geoCoding)) {
                //recupero il GeoPoint
                $geoParse = $parseObj->geoCoding;
                $geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
                //aggiungo lo status
                $user->setGeoCoding($geoPoint);
            }
            if (isset($parseObj->images))
                $user->setImages($parseObj->images); //MODIFICARE
            if (isset($parseObj->level))
                $user->setLevel($parseObj->level);
            if (isset($parseObj->levelValue))
                $user->setLevelValue($parseObj->levelValue);
            if (isset($parseObj->loveSongs))
                $user->setLoveSongs($parseObj->loveSongs);
            if (isset($parseObj->music))
                $user->setMusic($parseObj->music);
            if (isset($parseObj->playlists))
                $user->setPlaylists($parseObj->playlists); //MODIFICARE
            if (isset($parseObj->premium))
                $user->setPremium($parseObj->premium);
            if (isset($parseObj->premiumExpirationDate))
                $user->setPremiumExpirationDate($parseObj->premiumExpirationDate);
            if (isset($parseObj->profilePicture))
                $user->setProfilePicture($parseObj->profilePicture);
            if (isset($parseObj->profileThumbnail))
                $user->setProfileThumbnail($parseObj->profileThumbnail);
            if (isset($parseObj->settings))
                $user->setSettings($parseObj->settings);
            if (isset($parseObj->statuses))
                $user->setStatuses($parseObj->statuses); //MODIFICARE
            if (isset($parseObj->twitterPage))
                $user->setTwitterPage($parseObj->twitterPage);
            if (isset($parseObj->website))
                $user->setWebsite($parseObj->website);
            if (isset($parseObj->youtubeChannel))
                $user->setYoutubeChannel($parseObj->youtubeChannel);
            if (isset($parseObj->sessionToken))
                $user->setSessionToken($parseObj->sessionToken);
            if (isset($parseObj->createdAt))
                $user->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
            if (isset($parseObj->updatedAt))
                $user->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
            if (isset($parseObj->ACL))
                $user->setACL($parseObj->ACL); //OK?
        }

        return $user;
    }

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