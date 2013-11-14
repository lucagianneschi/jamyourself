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
            $cmt->setComment(fromParsePointer($res->comment));
            $cmt->setCommentCounter($res->commentCounter);
            # $cmt->setCommentators(fromParseRelation('Comment', 'commentators', $res->objectId, '_User'));
            # $cmt->setComments(fromParseRelation('Comment', 'comments', $res->objectId, 'Comment'));
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
            $cmt->setStatus(fromParsePointer($res->status));
            $cmt->setTags($res->tags);
            $cmt->setText($res->text);
            $cmt->setTitle($res->title);
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
            is_null($cmt->getActive()) ? $parseObject->active = true : $parseObject->active = $cmt->getActive();
            is_null($cmt->getAlbum()) ? $parseObject->album = null : $parseObject->album = toParsePointer('Album', $cmt->getAlbum());
            is_null($cmt->getComment()) ? $parseObject->comment = null : $parseObject->comment = toParsePointer('Comment', $cmt->getComment());
            is_null($cmt->getCommentCounter()) ? $parseObject->commentCounter = -1 : $parseObject->commentCounter = $cmt->getCommentCounter();
            is_null($cmt->getCommentators()) ? $parseObject->commentators = null : $parseObject->commentators = toParseAddRelation('_User', $cmt->getCommentators());
            is_null($cmt->getComments()) ? $parseObject->comments = null : $parseObject->comments = toParseAddRelation('Comment', $cmt->getComments());
            is_null($cmt->getCounter()) ? $parseObject->counter = -1 : $parseObject->counter = $cmt->getCounter();
            is_null($cmt->getEvent()) ? $parseObject->event = null : $parseObject->event = toParsePointer('Event', $cmt->getEvent());
            $parseObject->fromUser = toParsePointer('_User', $cmt->getFromUser());
            is_null($cmt->getImage()) ? $parseObject->image = null : $parseObject->image = toParsePointer('Image', $cmt->getImage());
            is_null($cmt->getLocation()) ? $parseObject->location = null : $parseObject->location = toParseGeoPoint($cmt->getLocation());
            is_null($cmt->getLoveCounter()) ? $parseObject->loveCounter = -1 : $parseObject->loveCounter = $cmt->getLoveCounter();
            is_null($cmt->getLovers()) ? $parseObject->lovers = $nullArray : $parseObject->lovers = $cmt->getLovers();
            is_null($cmt->getRecord()) ? $parseObject->record = null : $parseObject->record = toParsePointer('Record', $cmt->getRecord());
            is_null($cmt->getShareCounter()) ? $parseObject->shareCounter = -1 : $parseObject->shareCounter = $cmt->getShareCounter();
            is_null($cmt->getSong()) ? $parseObject->song = null : $parseObject->song = toParsePointer('Song', $cmt->getSong());
            is_null($cmt->getStatus()) ? $parseObject->status = null : $parseObject->status = toParsePointer('Status', $cmt->getStatus());
            is_null($cmt->getTags()) ? $parseObject->tags = $nullArray : $parseObject->tags = $cmt->getTags();
            is_null($cmt->getText()) ? $parseObject->text = null : $parseObject->text = $cmt->getText();
            is_null($cmt->getTitle()) ? $parseObject->title = null : $parseObject->title = $cmt->getTitle();
            is_null($cmt->getToUser()) ? $parseObject->toUser = null : $parseObject->toUser = toParsePointer('_User', $cmt->getToUser());
            is_null($cmt->getType()) ? $parseObject->type = null : $parseObject->type = $cmt->getType();
            is_null($cmt->getVideo()) ? $parseObject->video = null : $parseObject->video = toParsePointer('Video', $cmt->getVideo());
            is_null($cmt->getVote()) ? $parseObject->vote = null : $parseObject->vote = $cmt->getVote();
            is_null($cmt->getACL()) ? $parseObject->ACL = toParseDefaultACL() : $parseObject->ACL = toParseACL($cmt->getACL());
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