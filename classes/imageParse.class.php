<?php

/* ! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Image
 *  \details   Classe per la singola immagine caricata dall'utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:image">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:image">API</a>
 */

class ImageParse {

    private $parseQuery;

    function __construct() {
        $this->parseQuery = new parseQuery("Image");
    }

    function save(Image $image) {

        //recupero le info dell'oggetto
        $parse = new parseObject("Image");


        if ($parse->active)
            $parse->active = $image->getActive();
        if ($parse->album)
            $parse->album = toParsePointer($image->getAlbum());
        if ($parse->commentators)
            $parse->commentators = toParseRelation($image->getCommentator());
        if ($parse->comments)
            $parse->comments = toParseRelation($image->getComments());
        if ($parse->counter)
            $parse->counter = $image->getCounter();
        if ($parse->description)
            $parse->description = $image->getDescription();
        if ($parse->featuring)
            $parse->featuring = toParseRelation($image->getFeaturing());
//        if ($parse->file)
//            $parse->file = $image->getFile();
        if ($parse->filePath)
            $parse->filePath = $image->getFilePath();
        if ($parse->fromUser)
            $parse->fromUser = toParsePointer($image->getFromUser());
        if ($parse->location)
            $parse->location = toParseGeoPoint($image->getLocation());
        if ($parse->loveCounter)
            $parse->loveCounter = $image->getLoveCounter();
        if ($parse->lovers)
            $parse->lovers = toParseRelation($image->getLovers());
        if ($parse->tags)
            $parse->tags = $image->getTags();
        if ($parse->ACL)
            $parse->ACL = toParseACL($image->getACL());

        if (( $image->getObjectId()) != null) {
            //update
            try {
                //update
                $result = $parse->update($image->getObjectId());

                //aggiorno l'update
                $image->setUpdatedAt(new DateTime($result->updatedAt, new DateTimeZone("America/Los_Angeles")));
            } catch (ParseLibraryException $e) {

                return false;
            }
        } else {

            try {
                //salvo
                $result = $parse->save();

                //aggiorno i dati per la creazione
                $image->setObjectId($result->objectId);
                $image->setCreatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
                $image->setUpdatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
            } catch (ParseLibraryException $e) {

                return false;
            }
        }

        //restituisco image aggiornato
        return $image;
    }

    function delete(Image $image) {
        $image->setActive(false);

        if ($this->save($image))
            return true;
        else
            return false;
    }

    public function getImage($objectId) {
        $result = parseObject::get($objectId);
        return $this->parseToActivity($result);
    }

    public function getImages() {
        $images = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $images = array();
            foreach ($result->results as $image) {
                if ($image) {
                    //recupero l'utente
                    $images[] = $this->parseToImage($image);
                }
            }
        }
        return $images;
    }

    function parseToImage(stdClass $parseObj) {

        if ($parseObj == null)
            return null;

        $image = new Image();

        if (isset($parseObj->objectId))
            $image->setObjectId($parseObj->objectId);
        else
            return null;

        if (isset($parseObj->active))
            $image->setActive($parseObj->active);
        if (isset($parseObj->album))
            $image->setAlbum(AlbumParse::getAlbum($parseObj->album->objectId));

        if (isset($parseObj->commentators)) {
            $parse = new UserParse();
            $parse->whereRelatedTo("commentators", "Image", $parseObj->objectId);
            $image->setCommentator($parse->getUsers());
        }

        if (isset($parseObj->comments)) {
            $parse = new CommentParse();
            $parse->whereRelatedTo("comments", "Image", $parseObj->objectId);
            $image->setComments($parse->getComments());
        }

        if (isset($parseObj->counter))
            $image->setCounter($parseObj->counter);
        if (isset($parseObj->description))
            $image->setDescription($parseObj->description);
        if (isset($parseObj->featuring)) {
            $parse = new UserParse();
            $parse->whereRelatedTo("featuring", "Image", $parseObj->objectId);
            $image->setFeaturing($parse->getUsers());
        }
//        if (isset($parseObj->file)) $image->setFile ();
        if (isset($parseObj->filePath))
            $image->setFilePath($parseObj->filePath);
        if (isset($parseObj->fromUser)) {
            $parse = new UserParse();
            $parse->whereRelatedTo("fromUser", "Image", $parseObj->objectId);
            $image->setFromUser($parse->getUsers());
        }
        if (isset($parseObj->location)) {
            $parseGeoPoint = new parseGeoPoint($res->location->latitude, $res->location->longitude);
            $image->setLocation($parseGeoPoint->location);
        }
        if (isset($parseObj->loveCounter))
            $image->setLoveCounter($parseObj->loveCounter);
        if (isset($parseObj->lovers))
            $image->setLovers($parseObj->lovers);
        if (isset($parseObj->tags) && count($parseObj->tags) > 0)
            $image->setTags($parseObj->tags);
        if (isset($parseObj->createdAt))
            $image->setCreatedAt(new DateTime($parseObj->createdAt));
        if (isset($parseObj->updatedAt))
            $image->setUpdatedAt(new DateTime($parseObj->updatedAt));
        if (isset($parseObj->ACL))
            $image->setACL($parseObj->ACL);
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
