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

require_once CLASSES_DIR . 'imageParse.class.php';
require_once CLASSES_DIR . 'image.class.php';

class AlbumParse {

    private $parseQuery;

    function __construct() {

        $this->parseQuery = new ParseQuery("Album");
    }

    function saveAlbum(Album $album) {

        //creo un'istanza dell'oggetto della libreria ParseLib
        $parseObj = new parseObject("Album");

        $parseObj->active = $album->getActive();
        $parseObj->commentators = toParseRelation("_User", $album->getCommentators());
        $parseObj->comments = toParseRelation("Comments", $album->getComments());
        $parseObj->counter = $album->getCounter();
        $parseObj->cover = $album->getCover();
        $parseObj->coverFile = toParseFile($album->getCoverFile());
        $parseObj->description = $album->getDescription();
        $parseObj->featuring = toParseRelation("_User", $album->getFeaturing());
        $parseObj->fromUser = toParsePointer("_User", $album->getFromUser());
        $parseObj->images = toParseRelation("Image", $album->getImages());
        $parseObj->location = toParseGeoPoint($album->getLocation());
        $parseObj->loveCounter = $album->getLoveCounter();
        $parseObj->lovers = toParseRelation("_User", $album->getLovers());
        if ($album->getTags() != null && count($album->getTags()) > 0)
            $parseObj->tags = $album->getTags();
        else
            $parseObj->tags = null;
        $parseObj->thumbnailCover = $album->getThumbnailCover();
        $parseObj->title = $album->getTitle();
        $parseObj->ACL = toParseACL($album->getACL());
        //caso update
        if ($album->getObjectId() != null) {

            try {
                $ret = $parseObj->update($album->getObjectId());
                $album->setUpdatedAt(fromParseDate($ret->updatedAt));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        } else {
            //caso save
            try {
                $ret = $parseObj->save();
                $album->setObjectId($ret->objectId);
                $album->setCreatedAt(fromParseDate($ret->createdAt));
                $album->setUpdatedAt(fromParseDate($ret->createdAt));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        }

        return $album;
    }

    public function deleteAlbum($objectId, $imagesId) {
        try {
            $parseObject = new parseObject('Album');
            $parseObject->active = false;
            $parseObject->update($objectId);

            if ($imagesId && count($imagesId) > 0) {
                $parseImage = new ImageParse();

                foreach ($imagesId as $imageId) {
                        $parseImage->deleteImage($imageId);
                    }
                
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    function getAlbum($objectId) {
        try {
            $query = new parseObject("Album");
            $result = $query->get($objectId);
            return $this->parseToAlbum($result);
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function getAlbums() {
        $albums = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $albums = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $album = $this->parseToAlbum($obj);
                        $albums[$album->getObjectId()] = $album;
                    }
                }
            }
            return $albums;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    function parseToAlbum(stdClass $parseObj) {

        $album = new Album();

        try {
            $album->setObjectId($parseObj->objectId);
            $album->setActive($parseObj->active);
            $album->setCommentators(fromParseRelation("Album", "commentators", $parseObj->objectId, "_User"));
            $album->setComments(fromParseRelation("Album", "comments", $parseObj->objectId, "Comment"));
            $album->setCounter($parseObj->counter);
            $album->setCover($parseObj->cover);
            //$album->setCoverFile(fromParseFile($parseObj->coverFile));
            $album->setDescription($parseObj->description);
            $album->setFeaturing(fromParseRelation("Album", "featuring", $parseObj->objectId, "_User"));
            $album->setFromUser(fromParsePointer($parseObj->fromUser));
            $album->setImages(fromParseRelation("Album", "images", $parseObj->objectId, "Image"));
            $album->setLocation(fromParseGeoPoint($parseObj->location));
            $album->setLoveCounter($parseObj->loveCounter);
            $album->setLovers(fromParseRelation("Album", "lovers", $parseObj->objectId, "_User"));
            $album->setTags($parseObj->tags);
            $album->setThumbnailCover($parseObj->thumbnailCover);
            $album->setTitle($parseObj->title);
            $album->setCreatedAt(fromParseDate($parseObj->createdAt));
            $album->setUpdatedAt(fromParseDate($parseObj->updatedAt));
            $album->setACL(fromParseACL($parseObj->ACL));
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args ());
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
