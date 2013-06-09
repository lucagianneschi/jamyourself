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

    public function getUser() {
        $user = null;

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

    public function getUsers() {
        $users = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $users = array();
            foreach (($result->results) as $user) {
                $users [] = $this->parseToUser($user);
            }
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
                $parseUser->songs = $parseUser->dataType("relation", $arrayPointer);
            } else {
                $parseUser->songs = null;
            }
        }
        if ($user->getType() == "SPOTTER") {

            //formatto l'anno di nascita
            if ($user->getBirthDay() != null) {
                //birthDay e' un tipo DateTime
                $parseUser->birthDay = $parseUser->dataType('date', $user->getBirthDay()->format('r'));
            } else {
                $parseUser->birthDay = null;
            }
            if ($user->getFacebookId() != null) {
                $parseUser->facebookId = $user->getFacebookId();
            } else {
                $parseUser->facebookId = null;
            }
            if ($user->getFirstname() != null) {
                $parseUser->firstname = $user->getFirstname();
            } else {
                $parseUser->firstname = null;
            }
            if ($user->getFollowing() != null && count($user->getFollowing()) > 0) {
                $arrayPointer = array();
                foreach ($user->getFollowing() as $user) {
                    $pointer = $parseUser->dataType('pointer', array('_User', $user->getObjectId()));
                    $arrayPointer[] = $pointer;
                }
                $parseUser->following = $parseUser->dataType("relation", $arrayPointer);
            } else {
                $parseUser->following = null;
            }

            if ($user->getFriendship() != null && count($user->getFriendship()) > 0) {
                $arrayPointer = array();
                foreach ($user->getFriendship() as $user) {
                    $pointer = $parseUser->dataType('pointer', array('_User', $user->getObjectId()));
                    $arrayPointer[] = $pointer;
                }
                $parseUser->friendship = $parseUser->dataType("relation", $arrayPointer);
            } else {
                $parseUser->friendship = null;
            }
            if ($user->getLastname() != null) {
                $parseUser->lastname = $user->getLastname();
            } else {
                $parseUser->lastname = null;
            }

            $parseUser->sex = $user->getSex();
        }

        if ($user->getType() == "VENUE") {
            $parse->address = $user->getAddress();
            if ($user->getCollaboration() != null && count($user->getCollaboration()) > 0) {
                $arrayPointer = array();
                foreach ($user->getCollaboration() as $collaborator) {
                    $pointer = $parseUser->dataType('pointer', array('_User', $collaborator->getObjectId()));
                    $arrayPointer[] = $pointer;
                }
                $parseUser->collaboration = $parseUser->dataType("relation", $arrayPointer);
            } else {
                $parseUser->collaboration = null;
            }
            if ($user->getEvents() != null && count(getEvents()) > 0) {
                $arrayPointer = array();
                foreach ($user->getEvents() as $event) {
                    $pointer = $parseUser->dataType('pointer', array('Event', $event->getObjectId()));
                    $arrayPointer[] = $pointer;
                }
                $parseUser->events = $parseUser->dataType("relation", $arrayPointer);
            } else {
                $parseUser->events = null;
            }
            if ($user->getLocalType() != null) {
                $parseUser->localType = $user->getLocalType();
            } else {
                $parseUser->localType = null;
            }
        }

        //poi recupero i dati fondamentali (che appartengono a tutti gli utenti)
        $parseUser->username = $user->getUsername();
        //$parse->password = $user->getPassword(); VANNO MESSI?
        //$parse->authData; = $user->getAuthData;(); VANNO MESSI?
        $parseUser->active = $user->getActive();
        if ($user->getAlbums() != null && count(getAlbums()) > 0) {
            $arrayPointer = array();
            foreach ($user->getAlbums() as $album) {
                $pointer = $parseUser->dataType('pointer', array('Album', $album->getObjectId()));
                $arrayPointer[] = $pointer;
            }
            $parseUser->albums = $parseUser->dataType("relation", $arrayPointer);
        } else {
            $parseUser->albums = null;
        }
        if ($user->getBackground() != null) {
            $parseUser->background = $user->getBackground();
        } else {
            $parseUser->background = 'images/default/background.jpg';
        }
        if ($user->getCity() != null) {
            $parseUser->city = $user->getCity();
        } else {
            $parseUser->city = null;
        }
        if ($user->getComments() != null && count(getComments()) > 0) {
            $arrayPointer = array();
            foreach ($user->getComments() as $comment) {
                $pointer = $parseUser->dataType('pointer', array('Comment', $comment->getObjectId()));
                $arrayPointer[] = $pointer;
            }
            $parseUser->comments = $parseUser->dataType("relation", $arrayPointer);
        } else {
            $parseUser->comments = null;
        }
        if ($user->getCountry() != null) {
            $parseUser->country = $user->getCountry();
        } else {
            $parseUser->country = null;
        }
        if ($user->getDescription() != null) {
            $parseUser->description = $user->getDescription();
        } else {
            $parseUser->description = null;
        }
        if ($user->getEmail() != null) {
            $parseUser->email = $user->getEmail();
        } else {
            $parseUser->email = null;
        }
        if ($user->getFbPage() != null) {
            $parseUser->fbPage = $user->getFbPage();
        } else {
            $parseUser->fbPage = null;
        }
        if (($geoPoint = $user->getGeoCoding() ) != null) {
            $parseUser->geoCoding = $geoPoint->location;
        } else {
            $parseUser->geoCoding = null;
        }
        if ($user->getImages() != null && count(getImages()) > 0) {
            $arrayPointer = array();
            foreach ($user->getImages() as $image) {
                $pointer = $parseUser->dataType('pointer', array('Image', $image->getObjectId()));
                $arrayPointer[] = $pointer;
            }
            $parseUser->images = $parseUser->dataType("relation", $arrayPointer);
        } else {
            $parseUser->images = null;
        }
        if ($user->getLevel() != null) {
            $parseUser->level = $user->getLevel();
        } else {
            $parseUser->level = 0;
        }
        if ($user->getLevelValue() != null) {
            $parseUser->levelValue = $user->getLevelValue();
        } else {
            $parseUser->levelValue = 0;
        }
        if ($user->getLoveSongs() != null && count(getLoveSongs()) > 0) {
            $arrayPointer = array();
            foreach ($user->getLoveSongs() as $song) {
                $pointer = $parseUser->dataType('pointer', array('Song', $song->getObjectId()));
                $arrayPointer[] = $pointer;
            }
            $parseUser->loveSongs = $parseUser->dataType("relation", $arrayPointer);
        } else {
            $parseUser->loveSongs = null;
        }
        if ($user->getMusic() != null && count($user->getMusic()) > 0) {
            $parseUser->music = $user->getMusic();
        } else {
            $parseUser->music = null;
        }
        if ($user->getPlaylists() != null && count(getPlaylists()) > 0) {
            $arrayPointer = array();
            foreach ($user->getPlaylists() as $playlist) {
                $pointer = $parseUser->dataType('pointer', array('Playlist', $playlist->getObjectId()));
                $arrayPointer[] = $pointer;
            }
            $parseUser->playlists = $parseUser->dataType("relation", $arrayPointer);
        } else {
            $parseUser->playlists = null;
        }
        if ($user->getPremium() != null) {
            $parseUser->premium = $user->getPremium();
        } else {
            $parseUser->premium = null;
        }
        if ($user->getPremiumExpirationDate() != null) {
            $parseUser->premiumExpirationDate = $user->getPremiumExpirationDate();
        } else {
            $parseUser->premiumExpirationDate = null;
        }
        if ($user->getProfilePicture() != null) {
            $parseUser->profilePicture = $user->getProfilePicture();
        } else {
            $parseUser->profilePicture = null;
        }
        if ($user->getProfilePictureFile() != null) {
            $parseUser->profilePictureFile = $user->getProfilePictureFile();
        } else {
            $parseUser->profilePictureFile = null;
        }
        if ($user->getProfileThumbnail() != null) {
            $parseUser->profileThumbnail = $user->getProfileThumbnail();
        } else {
            $parseUser->profileThumbnail = null;
        }
        if ($user->getSettings() != null) {
            $parseUser->settings = $user->getSettings();
        } else {
            $parseUser->settings = null;
        }
        if ($user->getStatuses() != null && count(getStatuses()) > 0) {
            $arrayPointer = array();
            foreach ($user->getStatuses() as $status) {
                $pointer = $parseUser->dataType('pointer', array('Status', $status->getObjectId()));
                $arrayPointer[] = $pointer;
            }
            $parseUser->statuses = $parseUser->dataType("relation", $arrayPointer);
        } else {
            $parseUser->statuses = null;
        }
        if ($user->getTwitterPage() != null) {
            $parseUser->twitterPage = $user->getTwitterPage();
        } else {
            $parseUser->twitterPage = null;
        }
        if ($user->getType() != null) {
            $parseUser->type = $user->getType();
        }
        if ($user->getVideos() != null && count($user->getVideos()) > 0) {
            $arrayPointer = array();
            foreach ($user->getVideos() as $video) {
                $pointer = $parseUser->dataType('pointer', array('Video', $video->getObjectId()));
                $arrayPointer[] = $pointer;
            }
            $parseUser->videos = $parseUser->dataType("relation", $arrayPointer);
        } else {
            $parseUser->videos = null;
        }
        if ($user->getWebsite() != null) {
            $parseUser->website = $user->getWebsite();
        } else {
            $parseUser->website = null;
        }
        if ($user->getYoutubeChannel() != null) {
            $parseUser->youtubeChannel = $user->getYoutubeChannel();
        } else {
            $parseUser->youtubeChannel = null;
        }
        if ($user->getObjectId() != null) {

            //update

            try {

                $ret = $parseUser->update($user->getObjectId(), $user->getSessionToken());

                /** esempio di risposta:
                 *  $ret->updatedAt "2013-05-04T15:03:03.151Z";
                 */
                $user->setUpdatedAt(new DateTime($ret->updatedAt, new DateTimeZone("America/Los_Angeles")));
            } catch (ParseLibraryException $error) {
                return false;
            }
        } else {
            //registrazione

            $parseUser->password = $user->getPassword();

            try {

                $ret = $parseUser->signup($user->getUsername(), $user->getPassword());

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
    function login($login, $password) {

        //login tramite username o email
        if (filter_var("some@address.com", FILTER_VALIDATE_EMAIL)) {
            // valid address
            $this->parseQuery->where("email", $login);
        } else {
            // invalid address
            $this->parseQuery->where("username", $login);
        }
        $user = $this->getUser();

        if ($user != null) {
            $parse = new parseUser();
            $parse->username = $user->getUsername();
            $parse->password = $password;
            try {
                $ret = $parse->login();
                return $this->parseToUser($ret);
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
        } else {
            return null;
        }
        return $user;
    }

    /**
     * Cancellazione utente: imposta il flag active a false
     * @param User $user l'utente da cancellare
     * @return boolean true in caso di successo, false in caso di fallimento
     */
    function deleteUser(User $user) {

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
                    if (isset($parseObj->following)) {
                        $this->parseQuery->whereRelatedTo("following", "_User", $parseObj->objectId);
                        $user->setFollowing($this->getUsers());
                    }
                    if (isset($parseObj->friendship)) {
                        $this->parseQuery->whereRelatedTo("friendship", "_User", $parseObj->objectId);
                        $user->setFriendship($this->getUsers());
                    }

                    if (isset($parseObj->lastname))
                        $user->setLastname($parseObj->lastname);
                    if (isset($parseObj->sex))
                        $user->setSex($parseObj->sex);
                    break;

                case "JAMMER":

                    $user = new Jammer();

                    if (isset($parseObj->collaboration)) {
                        $this->parseQuery->whereRelatedTo("collaboration", "_User", $parseObj->objectId);
                        $user->setCollaboration($this->getUsers());
                    }
                    if (isset($parseObj->events)) {
                        $parseQueryEvent = new EventParse();
                        $parseQueryEvent->whereRelatedTo("events", "_User", $parseObj->objectId);
                        $user->setEvents($parseQueryEvent->getEvents());
                    }

                    if (isset($parseObj->members))
                        $user->setMembers($parseObj->members);
                    if (isset($parseObj->records)) {
                        $parseQueryRecord = new RecordParse();
                        $parseQueryRecord->whereRelatedTo("records", "_User", $parseObj->objectId);
                        $user->setRecords($parseQueryRecord->getRecords());
                    }

                    if (isset($parseObj->songs)) {
                        $parseQuerySong = new RecordParse();
                        $parseQuerySong->whereRelatedTo("songs", "_User", $parseObj->objectId);
                        $user->setRecords($parseQuerySong->getRecords());
                    }

                    if (isset($parseObj->jammerType))
                        $user->setJammerType($parseObj->jammerType);
                    break;

                case "VENUE":

                    $user = new Venue();

                    /* visto che deve essere un geopoint */ //questo è sbagliato! dalla stringa si ricavano le coordinate e si mettono dentro la property geoCoding!
                    //MODIFICARE!
                    if (isset($parseObj->address)) {
                        $geoParse = $parseObj->address;
                        $tempObj = new parseObject("temp");
                        $address = $tempObj->dataType("geopoint", array($geoParse->latitude, $geoParse->longitude));
                        $user->setAddress($address);
                    }

                    if (isset($parseObj->collaboration)) {
                        $this->whereRelatedTo("collaboration", "_User", $parseObj->objectId);
                        $user->setRecords($this->getUsers());
                    }
                    if (isset($parseObj->events)) {
                        $parseQueryEvent = new EventParse();
                        $parseQueryEvent->whereRelatedTo("events", "_User", $parseObj->objectId);
                        $user->setEvents($parseQueryEvent->getEvents());
                    }
                    if (isset($parseObj->localType))
                        $user->setLocalType($parseObj->localType);

                    break;
            }

            //poi recupero i dati fondamentali (che appartengono a tutti gli utenti)
            if (isset($parseObj->objectId))
                $user->setObjectId($parseObj->objectId);
            if (isset($parseObj->username))
                $user->setUsername($parseObj->username);
            if (isset($parseObj->emailVerified))
                $user->setEmailVerified($parseObj->emailVerified);
            if (isset($parseObj->active))
                $user->setActive($parseObj->active);
            if (isset($parseObj->albums)) {
                $parseQueryAlbum = new AlbumParse();
                $parseQueryAlbum->whereRelatedTo("albums", "_User", $parseObj->objectId);
                $user->setAlbums($parseQueryAlbum->getAlbums());
            }
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
                $tempObj = new parseObject("temp");
                $geoCoding = $tempObj->dataType("geopoint", array($geoParse->latitude, $geoParse->longitude));
                $user->setGeoCoding($geoCoding);
            }
            if (isset($parseObj->images)) {
                $parseQueryImage = new ImageParse();
                $parseQueryImage->whereRelatedTo("images", "_User", $parseObj->objectId);
                $user->setImages($parseQueryImage->getImages());
            }

            if (isset($parseObj->level))
                $user->setLevel($parseObj->level);
            if (isset($parseObj->levelValue))
                $user->setLevelValue($parseObj->levelValue);
            if (isset($parseObj->loveSongs))
                $user->setLoveSongs($parseObj->loveSongs);
            if (isset($parseObj->music))
                $user->setMusic($parseObj->music);
            if (isset($parseObj->playlists)) {
                $parseQueryPlaylist = new PlaylistParse();
                $parseQueryPlaylist->whereRelatedTo("playlists", "_User", $parseObj->objectId);
                $user->setPlaylists($parseQueryPlaylist->getPlaylists());
            }
            if (isset($parseObj->premium))
                $user->setPremium($parseObj->premium);
            if (isset($parseObj->premiumExpirationDate))
                $user->setPremiumExpirationDate(new DateTime($parseObj->premiumExpirationDate, new DateTimeZone("America/Los_Angeles")));
            if (isset($parseObj->profilePicture))
                $user->setProfilePicture($parseObj->profilePicture);
            if (isset($parseObj->profileThumbnail))
                $user->setProfileThumbnail($parseObj->profileThumbnail);
            if (isset($parseObj->settings))
                $user->setSettings($parseObj->settings);
            if (isset($parseObj->statuses)) {
                $parseQueryStatus = new StatusParse();
                $parseQueryStatus->whereRelatedTo("statuses", "_User", $parseObj->objectId);
                $user->setStatuses($parseQueryStatus->getStatuses());
            }

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

                $acl = new parseACL();
                $acl->setPublicReadAccess(true);
                $user->setACL($acl);
            
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