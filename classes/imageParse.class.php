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

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';
require_once CLASSES_DIR . 'image.class.php';

class ImageParse {

    private $parseQuery;

    function __construct() {
        $this->parseQuery = new parseQuery("Image");
    }

    function saveImage(Image $image) {

        //recupero le info dell'oggetto
        $parse = new parseObject("Image");

        $parseObj->active = $image->getActive();
        $parseObj->album = toParsePointer("Album", $image->getAlbum());
        $parseObj->commentators = toParseRelation("_User", $image->getCommentators());
        $parseObj->comments = toParseRelation("Comment", $image->getComments());
        $parseObj->counter = $image->getCounter();
        $parseObj->description = $image->getDescription();
        $parseObj->featuring = toParseRelation("_User", $image->getFeaturing());
        $parseObj->file = toParseFile($image->getFile());
        $parseObj->filePath = $image->getFilePath();
        $parseObj->fromUser = toParsePointer("_User", $image->getFromUser());
        $parseObj->location = toParseGeoPoint($image->getLocation());
        $parseObj->loveCounter = $image->getLoveCounter();
        $parseObj->lovers = toParseRelation("_User", $image->getLovers());
        if ($image->getTags() != null && count($image->getTags()) > 0)
            $parseObj->tags = $image->getTags();
        else
            $parseObj->tags = null;

        $parseObj->ACL = toParseACL($image->getACL());

        if (( $image->getObjectId()) != null) {

            //update
            try {
                //update
                $result = $parse->update($image->getObjectId());

                //aggiorno l'update
                $image->setUpdatedAt(fromParseDate($result->updatedAt));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        } else {

            try {
                //salvo                
                $result = $parse->save();

                //aggiorno i dati per la creazione
                $image->setObjectId($result->objectId);
                $image->setCreatedAt(fromParseDate($result->createdAt));
                $image->setUpdatedAt(fromParseDate($result->createdAt));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        }

        //restituisco image aggiornato
        return $image;
    }

    public function deleteImage($objectId) {
        try {
            $parseObject = new parseObject('Image');
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function getImage($objectId) {
        try {
            $query = new parseObject("Image");
            $result = $query->get($objectId);
            return $this->parseToImage($result);
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function getImages() {
        $images = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $images = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $image = $this->parseToImage($obj);
                        $images[$image->getObjectId()] = $image;
                    }
                }
            }
            return $images;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    function parseToImage(stdClass $parseObj) {
        try {
            $image = new Image();

            $image->setObjectId($parseObj->objectId);
            $image->setActive($parseObj->active);
            $image->setAlbum(fromParsePointer($parseObj->album));
            $image->setCommentators(fromParseRelation("Image", "commentators", $parseObj->objectId, "_User"));
            $image->setComments(fromParseRelation("Image", "comments", $parseObj->objectId, "Comment"));
            $image->setCounter($parseObj->counter);
            $image->setDescription($parseObj->description);
            $image->setFeaturing(fromParseRelation("Image", "featuring", $parseObj->objectId, "_User"));
            //$image->setFile(fromParseFile($parseObj->file));
            $image->setFilePath($parseObj->filePath);
            $image->setFromUser(fromParsePointer($parseObj->fromUser));
            $image->setLocation(fromParseGeoPoint($parseObj->location));
            $image->setLoveCounter($parseObj->loveCounter);
            $image->setLovers(fromParseRelation("Image", "lovers", $parseObj->objectId, "_User"));
            //$image->setTags($parseObj->tags);
            $image->setCreatedAt(fromParseDate($parseObj->createdAt));
            $image->setUpdatedAt(fromParseDate($parseObj->updatedAt));
            $image->setACL(fromParseACL($parseObj->ACL));

            return $image;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
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
