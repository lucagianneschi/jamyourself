<?php

/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Album
 *  \details	Classe raccoglitore per immagini
 *  \par		Commenti:
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
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'classes/' . getLanguage() . '.classes.lang.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';

class AlbumParse {

    private $parseQuery;

    /**
     * \fn		void __construct()
     * \brief	The constructor instantiates a new object of type ParseQuery on the Album class
     */
    function __construct() {
	$this->parseQuery = new ParseQuery('Album');
    }

    /**
     * \fn      void decrementAlbum(string $objectId, string $field, int $value)
     * \brief	Decrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Comment
     * \param	$field		the string that represent the field to decrement
     * \param 	$value		the number that represent the quantity to decrease the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function decrementAlbum($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
        try {
            $parseObject = new parseObject('Album');
            //we use the increment function with a negative value because decrement function still not work
            $parseObject->increment($field, array(0 - $value));
			if ($withArray) {
                if (is_null($fieldArray) || empty($valueArray))
                    return throwError(new Exception('decrementAlbum parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
                $parseObject->removeArray($fieldArray, $valueArray);
            }
            $res = $parseObject->update($objectId);
            return $res->$field;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void deleteAlbum($objectId)
     * \brief	Set unactive a specified Album by objectId
     * \param	$objectId the string that represent the objectId of the Album
     * \return	error in case of exception
     */
    public function deleteAlbum($objectId) {
	if (is_null($objectId))
	    return throwError(new Exception('deleteAlbum parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
	try {
	    $parseObject = new parseObject('Album');
	    $res = $parseObject->get($objectId);
	    $album = $this->parseToAlbum($res);
	    foreach ($album->getImages() as $imageObjectId) {
		$imageParse = new ImageParse();
		$imageParse->deleteImage($imageObjectId);
	    }
	    $album->setActive(false);
	    $this->saveAlbum($album);
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		void getAlbum($objectId)
     * \brief	The function returns the Album object specified
     * \param	$objectId the string that represent the objectId of the Album
     * \return	Album	the Album with the specified $objectId
     * \return	Error	the Error raised by the function
     */
    function getAlbum($objectId) {
	try {
	    $parseObject = new parseObject('Album');
	    $res = $parseObject->get($objectId);
	    return $this->parseToAlbum($res);
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		array getAlbums()
     * \brief	The function returns the Albums objects specified
     * \return	array	an array of Album, if one or more Album are found
     * \return	null	if no Album are found
     * \return	Error	the Error raised by the function
     */
    public function getAlbums() {
	try {
	    $albums = null;
	    $res = $this->parseQuery->find();
	    if (is_array($res->results) && count($res->results) > 0) {
		$albums = array();
		foreach ($res->results as $obj) {
		    $album = $this->parseToAlbum($obj);
		    $albums[$album->getObjectId()] = $album;
		}
	    }
	    return $albums;
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn number getCount()
     * \brief	Returns the number of requests Album
     * \return	number
     */
    public function getCount() {
	return $this->parseQuery->getCount()->count;
    }

    /**
     * \fn		void incrementAlbum(string $objectId, string $field, int $value)
     * \brief	iNcrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Comment
     * \param	$field		the string that represent the field to increment
     * \param 	$value		the number that represent the quantity to increase the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function incrementAlbum($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
        try {
            $parseObject = new parseObject('Album');
            $parseObject->increment($field, array($value));
            if ($withArray) {
                if (is_null($fieldArray) || empty($valueArray))
                    return throwError(new Exception('incrementAlbum parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
                $parseObject->addUniqueArray($fieldArray, $valueArray);
            }
            $res = $parseObject->update($objectId);
            return $res->$field;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void orderBy($field)
     * \brief	Specifies which field need to be ordered of requested Album
     * \param	$field	the field on which to sort
     */
    public function orderBy($field) {
	$this->parseQuery->orderBy($field);
    }

    /**
     * \fn		void orderByAscending($field)
     * \brief	Specifies which field need to be ordered ascending of requested Album
     * \param	$field	the field on which to sort ascending
     */
    public function orderByAscending($field) {
	$this->parseQuery->orderByAscending($field);
    }

    /**
     * \fn		void orderByDescending($field)
     * \brief	Specifies which field need to be ordered descending of requested Album
     * \param	$field	the field on which to sort descending
     */
    public function orderByDescending($field) {
	$this->parseQuery->orderByDescending($field);
    }

    /**
     * \fn		Album parseToAlbum($res)
     * \brief	The function returns a representation of an Album object in Parse
     * \param	$res	represent the Album object returned from Parse
     * \return	Album	the Album object
     * \return	Error	the Error raised by the function
     */
    function parseToAlbum($res) {
	if (is_null($res))
	    return throwError(new Exception('parseToAlbum parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
	try {
	    $album = new Album();
	    $album->setObjectId($res->objectId);
	    $album->setActive($res->active);
	    $album->setCommentCounter($res->commentCounter);
	    $album->setCounter($res->counter);
	    $album->setCover($res->cover);
	    $album->setCoverFile(fromParseFile($res->coverFile,"image/jpeg"));
	    $album->setDescription(parse_decode_string($res->description));
	    $album->setFromUser(fromParsePointer($res->fromUser));
	    $album->setImageCounter($res->imageCounter);
	    $album->setLocation(fromParseGeoPoint($res->location));
	    $album->setLoveCounter($res->loveCounter);
	    $album->setLovers($res->lovers);
	    $album->setShareCounter($res->shareCounter);
	    $album->setTags(parse_decode_array($res->tags));
	    $album->setThumbnailCover($res->thumbnailCover);
	    $album->setTitle(parse_decode_string($res->title));
	    $album->setCreatedAt(fromParseDate($res->createdAt));
	    $album->setUpdatedAt(fromParseDate($res->updatedAt));
	    $album->setACL(fromParseACL($res->ACL));
	    return $album;
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
	return $album;
    }

    /**
     * \fn		Album saveAlbum($album)
     * \brief	This function save an Album object in Parse
     * \param	$album		represent the Album object to save
     * \return	Album		the Album object with the new objectId parameter saved
     * \return	Exception	the Exception raised by the function
     */
    function saveAlbum($album) {
	if (is_null($album->getFromUser()))
	    return throwError(new Exception('saveAlbum parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
	try {
	    $parseAlbum = new parseObject('Album');
            $nullArray = array();
	    is_null($album->getActive()) ? $parseAlbum->active = true : $parseAlbum->active = $album->getActive();
	    is_null($album->getCommentCounter()) ? $parseAlbum->commentCounter = -1 : $parseAlbum->commentCounter = $album->getCommentCounter();
	    is_null($album->getCommentators()) ? $parseAlbum->commentators = null : $parseAlbum->commentators = toParseAddRelation('_User', $album->getCommentators());
	    is_null($album->getComments()) ? $parseAlbum->comments = null : $parseAlbum->comments = toParseAddRelation('Comment', $album->getComments());
	    is_null($album->getCounter()) ? $parseAlbum->counter = -1 : $parseAlbum->counter = $album->getCounter();
	    is_null($album->getCover()) ? $parseAlbum->cover = DEFALBUMCOVER : $parseAlbum->cover = $album->getCover();
	    # TODO
	    # is_null($album->getCoverFile()) ? $parseAlbum->coverFile = null : $parseAlbum->coverFile = toParseFile($album->getCoverFile());
	    is_null($album->getDescription()) ? $parseAlbum->description = null : $parseAlbum->description = parse_encode_string($album->getDescription());
	    is_null($album->getFeaturing()) ? $parseAlbum->featuring = null : $parseAlbum->featuring = toParseAddRelation('_User', $album->getFeaturing());
	    $parseAlbum->fromUser = toParsePointer('_User', $album->getFromUser());
	    is_null($album->getImageCounter()) ? $parseAlbum->imageCounter = -1 : $parseAlbum->imageCounter = $album->getImageCounter();
	    is_null($album->getImages()) ? $parseAlbum->images = null : $parseAlbum->images = toParseAddRelation('Image', $album->getImages());
	    is_null($album->getLocation()) ? $parseAlbum->location = null : $parseAlbum->location = toParseGeoPoint($album->getLocation());
	    is_null($album->getLoveCounter()) ? $parseAlbum->loveCounter = -1 : $parseAlbum->loveCounter = $album->getLoveCounter();
	    is_null($album->getLovers()) ? $parseAlbum->lovers = $nullArray : $parseAlbum->lovers = $album->getLovers();
	    is_null($album->getShareCounter()) ? $parseAlbum->shareCounter = -1 : $parseAlbum->shareCounter = $album->getShareCounter();
	    is_null($album->getTags()) ? $parseAlbum->tags = $nullArray : $parseAlbum->tags = parse_encode_array($album->getTags());
	    is_null($album->getThumbnailCover()) ? $parseAlbum->thumbnailCover = DEFALBUMTHUMB : $parseAlbum->thumbnailCover = $album->getThumbnailCover();
	    is_null($album->getTitle()) ? $parseAlbum->title = null : $parseAlbum->title = parse_encode_string($album->getTitle());
	    is_null($album->getACL()) ? $parseAlbum->ACL = toParseDefaultACL() : $parseAlbum->ACL = toParseACL($album->getACL());
	    if ($album->getObjectId() == '') {
		$res = $parseAlbum->save();
		$album->setObjectId($res->objectId);
		return $album;
	    } else {
		$parseAlbum->update($album->getObjectId());
	    }
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		void setLimit($limit)
     * \brief	Sets the maximum number of Album to return
     * \param	$limit	the maximum number
     */
    public function setLimit($limit) {
	$this->parseQuery->setLimit($limit);
    }

    /**
     * \fn		void setSkip($skip)
     * \brief	Sets the number of how many Album(s) must be discarded initially
     * \param	$skip	the number of Album(s) to skip
     */
    public function setSkip($skip) {
	$this->parseQuery->setSkip($skip);
    }

    /**
     * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
     * \brief	Update a field of the object
     * \param	$objectId		the objectId of the Album to update
     * \param	$field			the field of the Album to update
     * \param	$value			the value to update te field
     * \param	$isRelation		[optional] default = false - define if the field is a relational type
     * \param	$typeRelation	[optional] default = '' - define if the relational update must add or remove the value from the field
     * \param	$className		[optional] default = '' - define the class of the type of object present into the relational field
     */
    public function updateField($objectId, $field, $value, $isRelation = false, $typeRelation = '', $className = '') {
	if (is_null($objectId) || is_null($field))
	    return throwError(new Exception('updateField parameters objectId, field and value must to be set'), __CLASS__, __FUNCTION__, func_get_args());
	if ($isRelation) {
	    if (is_null($typeRelation) || is_null($className))
		return throwError(new Exception('updateField parameters typeRelation and className must to be set for relation update'), __CLASS__, __FUNCTION__, func_get_args());
	    if ($typeRelation == 'add') {
		$parseObject = new parseObject('Album');
		$parseObject->$field = toParseAddRelation($className, $value);
		$parseObject->update($objectId);
	    } elseif ($typeRelation == 'remove') {
		$parseObject = new parseObject('Album');
		$parseObject->$field = toParseRemoveRelation($className, $value);
		$parseObject->update($objectId);
	    } else {
		return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
	    }
	} else {
	    $parseObject = new parseObject('Album');
	    $parseObject->$field = $value;
	    $parseObject->update($objectId);
	}
    }

    /**
     * \fn		void where($field, $value)
     * \brief	Sets a condition for which the field $field must value $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function where($field, $value) {
	$this->parseQuery->where($field, $value);
    }

    /**
     * \fn		void whereContainedIn($field, $value)
     * \brief	Sets a condition for which the field $field must value one or more $value
     * \param	$field	the string which represent the field
     * \param	$value	the array which represent the values
     */
    public function whereContainedIn($field, $values) {
	$this->parseQuery->whereContainedIn($field, $values);
    }

    /**
     * \fn		void whereEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must value $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereEqualTo($field, $value) {
	$this->parseQuery->whereEqualTo($field, $value);
    }

    /**
     * \fn		void whereExists($field)
     * \brief	Sets a condition for which the field $field must be enhanced
     * \param	$field	the string which represent the field
     */
    public function whereExists($field) {
	$this->parseQuery->whereExists($field);
    }

    /**
     * \fn		void whereGreaterThan($field, $value)
     * \brief	Sets a condition for which the field $field must value more than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereGreaterThan($field, $value) {
	$this->parseQuery->whereGreaterThan($field, $value);
    }

    /**
     * \fn		void whereGreaterThanOrEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must value equal or more than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereGreaterThanOrEqualTo($field, $value) {
	$this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
    }

    /**
     * \fn		void whereInclude($field)
     * \brief	Sets a condition for which the field $field, that represent a Pointer, must return all the entire object
     * \param	$field	the string which represent the field
     */
    public function whereInclude($field) {
	$this->parseQuery->whereInclude($field);
    }

    /**
     * \fn		void whereLessThan($field, $value)
     * \brief	Sets a condition for which the field $field must value less than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereLessThan($field, $value) {
	$this->parseQuery->whereLessThan($field, $value);
    }

    /**
     * \fn		void whereLessThanOrEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must value equal or less than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereLessThanOrEqualTo($field, $value) {
	$this->parseQuery->whereLessThanOrEqualTo($field, $value);
    }

    /**
     * \fn		void whereNotContainedIn($field, $value)
     * \brief	Sets a condition for which the field $field must not value one or more $value
     * \param	$field	the string which represent the field
     * \param	$value	the array which represent the values
     */
    public function whereNotContainedIn($field, $array) {
	$this->parseQuery->whereNotContainedIn($field, $array);
    }

    /**
     * \fn		void whereNotEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must not value $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereNotEqualTo($field, $value) {
	$this->parseQuery->whereNotEqualTo($field, $value);
    }

    /**
     * \fn		void whereNotExists($field)
     * \brief	Sets a condition for which the field $field must not be enhanced
     * \param	$field	the string which represent the field
     */
    public function whereNotExists($field) {
	$this->parseQuery->whereDoesNotExist($field);
    }

    /**
     * \fn		void wherePointer($field, $className, $objectId)
     * \brief	Sets a condition for which the field $field must contain a Pointer to the class $className with pointer value $objectId
     * \param	$field		the string which represent the field
     * \param	$className	the string which represent the className of the Pointer
     * \param	$objectId	the string which represent the objectId of the Pointer
     */
    public function wherePointer($field, $className, $objectId) {
	$this->parseQuery->wherePointer($field, $className, $objectId);
    }

    /**
     * \fn		void whereRelatedTo($field, $className, $objectId)
     * \brief	Sets a condition for which to return all the Comment objects present in the field $field of object $objectId of type $className
     * \param	$field		the string which represent the field
     * \param	$className	the string which represent the className
     * \param	$objectId	the string which represent the objectId
     */
    public function whereRelatedTo($field, $className, $objectId) {
	$this->parseQuery->whereRelatedTo($field, $className, $objectId);
    }

}

?>