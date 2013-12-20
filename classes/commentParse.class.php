<?php

/* ! \par		Info Generali:
 *  \author		Daniele Caldelli
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Comment
 *  \details	Classe dedicata a POST, REVIEW, COMMENT & MESSAGGI
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:comment">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:comment">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once SERVICES_DIR . 'debug.service.php';

class CommentParse {

    private $parseQuery;

    /**
     * \fn		void __construct()
     * \brief	The constructor instantiates a new object of type ParseQuery on the Comment class
     */
    public function __construct() {
        $this->parseQuery = new parseQuery('Comment');
    }

    /**
     * \fn		void decrementComment(string $objectId, string $field, int $value)
     * \brief	Decrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Comment
     * \param	$field		the string that represent the field to decrement
     * \param 	$value		the number that represent the quantity to decrease the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function decrementComment($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
        try {
            $parseObject = new parseObject('Comment');
            //we use the increment function with a negative value because decrement function still not work
            $parseObject->increment($field, array(0 - $value));
            if ($withArray) {
                if (is_null($fieldArray) || empty($valueArray))
                    return throwError(new Exception('decrementComment parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
                $parseObject->removeArray($fieldArray, $valueArray);
            }
            $res = $parseObject->update($objectId);
            return $res->$field;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void deleteComment(string $objectId)
     * \brief	The function delete a Comment, setting active property to false
     * \param	$objectId	the string that represent the objectId of the Comment to delete
     * \return	Error		the Error raised by the function
     */
    public function deleteComment($objectId) {
        try {
            $parseObject = new parseObject('Comment');
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		Comment getComment(string $objectId)
     * \brief	The function returns the Comment object specified
     * \param	$objectId the string that represent the objectId of the Comment
     * \return	Comment	the Comment with the specified $objectId
     * \return	Error	the Error raised by the function
     */
    public function getComment($objectId) {
        try {
            $parseObject = new parseObject('Comment');
            $res = $parseObject->get($objectId);
            $cmt = $this->parseToComment($res);
            return $cmt;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		array getComments()
     * \brief	The function returns an array Comments objects specified
     * \return	array	an array of Comments, if one or more Comments are found
     * \return	null	if no Comment is found
     * \return	Error	the Error raised by the function
     */
    public function getComments() {
        try {
            $cmts = null;
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $cmts = array();
                foreach ($res->results as $obj) {
                    $cmt = $this->parseToComment($obj);
                    $cmts[$cmt->getObjectId()] = $cmt;
                }
            }
            return $cmts;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		number getCount()
     * \brief	Returns the number of requests Comment
     * \return	number
     */
    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    /**
     * \fn		void incrementComment(string $objectId, string $field, int $value)
     * \brief	iNcrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Comment
     * \param	$field		the string that represent the field to increment
     * \param 	$value		the number that represent the quantity to increase the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function incrementComment($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
        try {
            $parseObject = new parseObject('Comment');
            $parseObject->increment($field, array($value));
            if ($withArray) {
                if (is_null($fieldArray) || empty($valueArray))
                    return throwError(new Exception('incrementComment parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
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
     * \brief	Specifies which field need to be ordered of requested Comment
     * \param	$field	the field on which to sort
     */
    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    /**
     * \fn		void orderByAscending($field)
     * \brief	Specifies which field need to be ordered ascending of requested Comment
     * \param	$field	the field on which to sort ascending
     */
    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    /**
     * \fn		void orderByDescending($field)
     * \brief	Specifies which field need to be ordered descending of requested Comment
     * \param	$field	the field on which to sort descending
     */
    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    /**
     * \fn		Comment parseToComment($res)
     * \brief	The function returns a representation of an Comment object in Parse
     * \param	$res 	represent the Comment object returned from Parse
     * \return	Comment	the Comment object
     * \return	Error	the Error raised by the function
     */
    public function parseToComment($res) {
        if (is_null($res))
            return throwError(new Exception('parseToComment parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $cmt = new Comment();
            $cmt->setObjectId($res->objectId);
            $cmt->setActive($res->active);
            $cmt->setAlbum(fromParsePointer($res->album));
            $cmt->setCommentCounter($res->commentCounter);
            $cmt->setCounter($res->counter);
            $cmt->setEvent(fromParsePointer($res->event));
            $cmt->setFromUser(fromParsePointer($res->fromUser));
            $cmt->setImage(fromParsePointer($res->image));
            $cmt->setLocation(fromParseGeoPoint($res->location));
            $cmt->setLoveCounter($res->loveCounter);
            $cmt->setLovers($res->lovers);
            $cmt->setRecord(fromParsePointer($res->record));
            $cmt->setShareCounter($res->shareCounter);
            $cmt->setSong(fromParsePointer($res->song));
            $cmt->setTags(parse_decode_array($res->tags));
            $cmt->setText(parse_decode_string($res->text));
            $cmt->setTitle(parse_decode_string($res->title));
            $cmt->setToUser(fromParsePointer($res->toUser));
            $cmt->setType($res->type);
            $cmt->setVideo(fromParsePointer($res->video));
            $cmt->setVote($res->vote);
            $cmt->setCreatedAt(fromParseDate($res->createdAt));
            $cmt->setUpdatedAt(fromParseDate($res->updatedAt));
            $cmt->setACL(fromParseACL($res->ACL));
            return $cmt;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		Comment saveComment($cmt)
     * \brief	This function save a Comment object in Parse
     * \param	$cmt 		represent the Comment object to save
     * \return	Comment		the Comment object with the new objectId parameter saved
     * \return	Exception	the Exception raised by the function
     */
    public function saveComment($cmt) {
        if (is_null($cmt->getFromUser()))
            return throwError(new Exception('saveComment parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $parseObject = new parseObject('Comment');
            $nullArray = array();
            $parseObject->active = is_null($cmt->getActive()) ? true : $cmt->getActive();
            $parseObject->album = is_null($cmt->getAlbum()) ? null : toParsePointer('Album', $cmt->getAlbum());
            $parseObject->comment = is_null($cmt->getComment()) ? null : toParsePointer('Comment', $cmt->getComment());
            $parseObject->commentCounter = is_null($cmt->getCommentCounter()) ? 0 : $cmt->getCommentCounter();
            $parseObject->counter = is_null($cmt->getCounter()) ? 0 : $cmt->getCounter();
            $parseObject->event = is_null($cmt->getEvent()) ? null : toParsePointer('Event', $cmt->getEvent());
            $parseObject->fromUser = toParsePointer('_User', $cmt->getFromUser());
            $parseObject->image = is_null($cmt->getImage()) ? null : toParsePointer('Image', $cmt->getImage());
            $parseObject->location = is_null($cmt->getLocation()) ? null : toParseGeoPoint($cmt->getLocation());
            $parseObject->loveCounter = is_null($cmt->getLoveCounter()) ? 0 : $cmt->getLoveCounter();
            $parseObject->lovers = is_null($cmt->getLovers()) ? $nullArray : $cmt->getLovers();
            $parseObject->record = is_null($cmt->getRecord()) ? null : toParsePointer('Record', $cmt->getRecord());
            $parseObject->shareCounter = is_null($cmt->getShareCounter()) ? 0 : $cmt->getShareCounter();
            $parseObject->song = is_null($cmt->getSong()) ? null : toParsePointer('Song', $cmt->getSong());
            $parseObject->tags = is_null($cmt->getTags()) ? $nullArray : parse_encode_array($cmt->getTags());
            $parseObject->text = is_null($cmt->getText()) ? null : parse_encode_string($cmt->getText());
            $parseObject->title = is_null($cmt->getTitle()) ? null : parse_encode_string($cmt->getTitle());
            $parseObject->toUser = is_null($cmt->getToUser()) ? null : toParsePointer('_User', $cmt->getToUser());
            $parseObject->type = is_null($cmt->getType()) ? null : $cmt->getType();
            $parseObject->video = is_null($cmt->getVideo()) ? null : toParsePointer('Video', $cmt->getVideo());
            $parseObject->vote = is_null($cmt->getVote()) ? null : $cmt->getVote();
            $parseObject->ACL = is_null($cmt->getACL()) ? toParseDefaultACL() : toParseACL($cmt->getACL());
            if ($cmt->getObjectId() == '') {
                $res = $parseObject->save();
                $cmt->setObjectId($res->objectId);
                return $cmt;
            } else {
                $parseObject->update($cmt->getObjectId());
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void setLimit($limit)
     * \brief	Sets the maximum number of Comment to return
     * \param	$limit	the maximum number
     */
    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    /**
     * \fn		void setSkip($skip)
     * \brief	Sets the number of how many Comment must be discarded initially
     * \param	$skip	the number of Comment to skip
     */
    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    /**
     * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
     * \brief	Update a field of the object
     * \param	$objectId		the objectId of the Comment to update
     * \param	$field			the field of the Comment to update
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
                $parseObject = new parseObject('Comment');
                $parseObject->$field = toParseAddRelation($className, $value);
                $parseObject->update($objectId);
            } elseif ($typeRelation == 'remove') {
                $parseObject = new parseObject('Comment');
                $parseObject->$field = toParseRemoveRelation($className, $value);
                $parseObject->update($objectId);
            } else {
                return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
            }
        } else {
            $parseObject = new parseObject('Comment');
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
     * \fn	whereInQuery($field, $className, $array)
     * \brief	Sets a condition for which the field $field matches a value in the array $array
     * \param	$field, $className, $array
     */
    public function whereInQuery($field, $className, $array) {
        $this->parseQuery->whereInQuery($field, $className, $array);
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
     * \fn	whereNearSphere($latitude, $longitude, $distance, $distanceType)
     * \brief	find element in a spherre near the given latitude e longitude
     * \param	$latitude, $longitude
     */
    public function whereNearSphere($latitude, $longitude, $distance = null, $distanceType = null) {
        $this->parseQuery->whereNearSphere('location', $latitude, $longitude, $distance, $distanceType);
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
     * \fn	whereNotInQuery($field, $className, $array)
     * \brief	Sets a condition for which the field $field does not match a value in the array $array
     * \param	$field, $className, $array
     */
    public function whereNotInQuery($field, $className, $array) {
        $this->parseQuery->whereNotInQuery($field, $className, $array);
    }

    /**
     * \fn		void whereOr($value)
     * \brief	Sets a condition for which the field in the array $value must value al least one value
     * 			An example of $value is:
     * 			$value = array(
     * 				array('type' => 'EVENTUPDATED'),
     * 				array('album' => array('__type' => 'Pointer', 'className' => 'Album', 'objectId' => 'lK0bNWIi7k'))
     * 			);
     * \param	$field	the array representing the field and the value to put in or
     */
    public function whereOr($value) {
        $this->parseQuery->where('$or', $value);
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