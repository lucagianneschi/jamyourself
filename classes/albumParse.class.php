<?php

/* ! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Album
 *  \details   Classe raccoglitore per immagini
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:album">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:album">API</a>
 */

class AlbumParse {

    private $parseQuery;

    function __construct() {

        $this->parseQuery = new ParseQuery("Album");
    }

    function save(Album $album) {

        //creo un'istanza dell'oggetto della libreria ParseLib
        $parseObj = new parseObject("Album");

        //inizializzo le properties

        $parseObj->active = $album->getActive();

        if ($album->getCommentators() == null || count($album->getCommentators()) == 0)
            $parseObj->commentators = null;
        else {
            $parseObj->commentators = toParseRelation($album->getCommentators());
        }

        if ($album->getComments() == null || count($album->getComments()) == 0)
            $parseObj->comments = null;
        else {
            $parseObj->comments = toParseRelation($album->getComments());
        }

        $parseObj->counter = $album->getCounter();

        $parseObj->cover = $album->getCover();

//        if($album->getCoverFile() == null ) $album->coverFile = null;
//        else {
//            
//        }
        $parseObj->description = $album->getDescription();

        if ($album->getFeaturing() == null)
            $album->featuring = null;
        else {
            $album->featuring = toParseRelation($album->getFeaturing());
        }

        if ($album->getFromUser() == null)
            $parseObj->fromUser = null;
        else {
            $parseObj->fromUser = toParsePointer($album->getFromUser());
        }
        if ($album->getImages() == null)
            $parseObj->images = null;
        else {
            $parseObj->images = toParsePointer($album->getImages());
        }
        if ($album->getLocation() == null)
            $parseObj->location = null;
        else {
            $parseObj->location = toParseGeoPoint($album->getLocation());
        }
        $parseObj->loveCounter = $album->getLoveCounter();

        if ($album->getLovers() == null || count($album->getLovers()) == 0)
            $parseObj->lovers = null;
        else {
            $parseObj->lovers = toParseRelation($album->getLovers());
        }
        if ($album->getTags() == null || count($album->getTags()) == 0)
            $parseObj->tags = null;
        else
            $parseObj->tags = $album->getTags();

        $parseObj->thumbnailCover = $album->getThumbnailCover();

        $parseObj->title = $album->getTitle();

        $album->getACL() == null ? $parseObj->ACL = null : $parseObj->ACL = toParseACL($album->getACL()->acl);

        if ($album->getObjectId() != null) {

            try {
                //aggiornamento
                $ret = $parseObj->update($album->getObjectId());

                $album->setUpdatedAt($ret->updatedAt, new DateTimeZone("America/Los_Angeles"));
            } catch (ParseLibraryException $e) {

                return false;
            }
        } else {
            //salvataggio
            try {

                $ret = $parseObj->save();

                $album->setObjectId($ret->objectId);

                $album->setCreatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));

                $album->setUpdatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
            } catch (ParseLibraryException $e) {

                return false;
            }
        }

        return $album;
    }

    /**
     * 
     * @param Album $album
     * @return boolean
     */
    function delete(Album $album) {
        if ($album) {
            $album->setActive(false);

            if ($this->save($album))
                return true;
            else
                return false;
        }
        else
            return false;
    }

    function getAlbum($objectId) {
        $result = parseObject::get($objectId);
        return $this->parseToAlbum($result);
    }

    public function getAlbums() {
        $albums = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $albums = array();
            foreach ($result->results as $album) {
                if ($album) {
                    $albums[] = $this->parseToAlbum($album);
                }
            }
        }
        return $albums;
    }

    function parseToAlbum(stdClass $parseObj) {

        $album = new Album();

        if (isset($parseObj->objectId))
            $album->setObjectId($parseObj->objectId);
        if (isset($parseObj->active))
            $album->setActive($parseObj->active);
        if (isset($parseObj->counter))
            $album->setCounter($parseObj->counter);
        if (isset($parseObj->cover))
            $album->setCover($parseObj->cover);
        /*
          if (isset($parseObj->coverFile))
          $album->setCoverFile($parseObj->coverFile);
         */
        if (isset($parseObj->description))
            $album->setDescription($parseObj->description);

        if (isset($parseObj->featuring)) {

            $parseUser = new UserParse();
            $parseUser->whereRelatedTo(featuring, "Album", $parseObj->objectId);
            $featuring = $parseUser->getUsers();

            $album->setFeaturing($featuring);
        }

        if (isset($parseObj->fromUser)) {
            $parseUser = new UserParse();
            $pointer = $parseObj->fromUser;
            $fromUser = $parseUser->getUserById($pointer->getObjectId());
            $album->setFromUser($fromUser);
        }

        if (isset($parseObj->location)) {
            //recupero il GeoPoint
            $geoParse = $parseObj->location;
            $geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
            $album->setLocation($geoPoint);
        }

        if (isset($parseObj->loveCounter))
            $album->setLoveCounter($parseObj->loveCounter);


        if (isset($parseObj->thumbnailCover))
            $album->setThumbnailCover($parseObj->thumbnailCover);

        if (isset($parseObj->tag))
            $album->setTag($parseObj->tag);

        if (isset($parseObj->title))
            $album->setTitle($parseObj->title);

        if (isset($parseObj->createdAt)) {

            $createdAt = new DateTime($parseObj->createdAt);

            $album->setCreatedAt($createdAt);
        }

        if (isset($parseObj->updatedAt)) {
            $updatedAt = new DateTime($parseObj->updatedAt);

            $album->setUpdatedAt($updatedAt);
        }
        if (isset($parseObj->ACL)) {
            $ACL = null;
            $album->setACL($ACL);
        }

        return $album;
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
