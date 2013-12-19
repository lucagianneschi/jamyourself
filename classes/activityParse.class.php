<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version		1.0
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Activity
 *  \details		Classe che accoglie le activities del sito
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:activity">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:activity">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'activity.class.php';

class ActivityParse {

    private $parseQuery;

    /**
     * \fn		void __construct()
     * \brief	The constructor instantiates a new object of type ParseQuery on the Activity class
     */
    public function __construct() {

        $this->parseQuery = new ParseQuery('Activity');
    }

    /**
     * \fn		void decrementActivity(string $objectId, string $field, int $value)
     * \brief	Decrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Activity
     * \param	$field		the string that represent the field to decrement
     * \param 	$value		the number that represent the quantity to decrease the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function decrementActivity($objectId, $field, $value) {
        try {
            $parseObject = new parseObject('Activity');
            //we use the increment function with a negative value because decrement function still not work
            $parseObject->increment($field, array(0 - $value));
            $res = $parseObject->update($objectId);
            return $res->$field;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void deleteActivity(string $objectId)
     * \brief	Set unactive a specified Activity by objectId
     * \param	$objectId the string that represent the objectId of the Activity
     * \return	error in case of exception
     */
    public function deleteActivity($objectId) {
        try {
            $parseObject= new parseObject('Activity');
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void getActivity(string $objectId)
     * \brief	The function returns the Activity object specified
     * \param	$objectId the string that represent the objectId of the Activity
     * \return	Activity	the Activity with the specified $objectId
     * \return	Error		the Error raised by the function
     */
    public function getActivity($objectId) {
        try {
            $parseObject= new parseObject('Activity');
            return $this->parseToActivity($parseObject->get($objectId));
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		array getActivities()
     * \brief	The function returns the Activities objects specified
     * \return	array	an array of Activity, if one or more Activity are found
     * \return	null	if no Activity are found
     * \return	Error	the Error raised by the function
     */
    public function getActivities() {
        try {
            $activities = null;
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $activities = array();
                foreach ($res->results as $obj) {
                    $activity = $this->parseToActivity($obj);
                    $activities[$activity->getObjectId()] = $activity;
                }
            }
            return $activities;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		number getCount()
     * \brief	Returns the number of requests Activity
     * \return	number
     */
    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    /**
     * \fn		void incrementActivity(string $objectId, string $field, int $value)
     * \brief	increment the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Activity
     * \param	$field		the string that represent the field to increment
     * \param 	$value		the number that represent the quantity to increase the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function incrementActivity($objectId, $field, $value) {
        try {
            $parseObject = new parseObject('Activity');
            $parseObject->increment($field, array($value));
            $res = $parseObject->update($objectId);
            return $res->$field;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void orderBy($field)
     * \brief	Specifies which field need to be ordered of requested Activity
     * \param	$field	the field on which to sort
     */
    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    /**
     * \fn		void orderByAscending($field)
     * \brief	Specifies which field need to be ordered ascending of requested Activity
     * \param	$field	the field on which to sort ascending
     */
    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    /**
     * \fn		void orderByDescending($field)
     * \brief	Specifies which field need to be ordered descending of requested Activity
     * \param	$field	the field on which to sort descending
     */
    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    /**
     * \fn		Activity parseToActivity($res)
     * \brief	The function returns a representation of an Activity object in Parse
     * \param	$res		represent the Activity object returned from Parse
     * \return	Activity	the Activity object
     * \return	Error		the Error raised by the function
     */
    public function parseToActivity($res) {
        if (is_null($res))
            return throwError(new Exception('parseToActivity parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $activity = new Activity();
            $activity->setObjectId($res->objectId);
            $activity->setActive($res->active);
            $activity->setAlbum(fromParsePointer($res->album));
            $activity->setComment(fromParsePointer($res->comment));
            $activity->setCounter($res->counter);
            $activity->setFromUser(fromParsePointer($res->fromUser));
            $activity->setEvent(fromParsePointer($res->event));
            $activity->setImage(fromParsePointer($res->image));
            $activity->setPlaylist(fromParsePointer($res->playlist));
            $activity->setQuestion(fromParsePointer($res->question));
            $activity->setRead($res->read);
            $activity->setRecord(fromParsePointer($res->record));
            $activity->setSong(fromParsePointer($res->song));
            $activity->setStatus($res->status);
            $activity->setToUser(fromParsePointer($res->toUser));
            $activity->setType($res->type);
            $activity->setVideo(fromParsePointer($res->video));
            $activity->setCreatedAt(fromParseDate($res->createdAt));
            $activity->setUpdatedAt(fromParseDate($res->updatedAt));
            $activity->setACL(fromParseACL($res->ACL));
            return $activity;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		Activity saveActivity(Activity $activity)
     * \brief	This function save an Activity object in Parse
     * \param	$activity	represent the Activity object to save
     * \return	Activity	the Activity object with the new objectId parameter saved
     * \return	Error		the Error raised by the function
     */
    public function saveActivity($activity) {
        if (is_null($activity->getFromUser()))
            return throwError(new Exception('saveActivity parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $parseObject= new parseObject('Activity');
            $parseObject->active = is_null($activity->getActive()) ? true : $activity->getActive();
            $parseObject->album = is_null($activity->getAlbum()) ? null : toParsePointer('Album', $activity->getAlbum());
            $parseObject->comment = is_null($activity->getComment()) ? null : toParsePointer('Comment', $activity->getComment());
            $parseObject->counter = is_null($activity->getCounter()) ? 0 : $activity->getCounter();
            $parseObject->event = is_null($activity->getEvent()) ? null : toParsePointer('Event', $activity->getEvent());
            $parseObject->fromUser = toParsePointer('_User', $activity->getFromUser());
            $parseObject->image = is_null($activity->getImage()) ? null : toParsePointer('Image', $activity->getImage());
            $parseObject->playlist = is_null($activity->getPlaylist()) ? null : toParsePointer('Playlist', $activity->getPlaylist());
            $parseObject->question = is_null($activity->getQuestion()) ? null : toParsePointer('Question', $activity->getQuestion());
            $parseObject->read = is_null($activity->getRead()) ? true : $activity->getRead();
            $parseObject->record = is_null($activity->getRecord()) ? null : toParsePointer('Record', $activity->getRecord());
            $parseObject->song = is_null($activity->getSong()) ? null : toParsePointer('Song', $activity->getSong());
            $parseObject->status = is_null($activity->getStatus()) ? 'A' : $activity->getStatus();
            $parseObject->toUser = is_null($activity->getToUser()) ? null : toParsePointer('_User', $activity->getToUser());
            $parseObject->type = is_null($activity->getType()) ? null : $activity->getType();
            $parseObject->video = is_null($activity->getVideo()) ? null : toParsePointer('Video', $activity->getVideo());
            $parseObject->ACL = is_null($activity->getACL()) ? toParseDefaultACL() : toParseACL($activity->getACL());
            if ($activity->getObjectId() == '') {
                $res = $parseObject->save();
                $activity->setObjectId($res->objectId);
                return $activity;
            } else {
                $parseObject->update($activity->getObjectId());
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void setLimit($limit)
     * \brief	Sets the maximum number of Activity to return
     * \param	$limit	the maximum number
     */
    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    /**
     * \fn		void setSkip($skip)
     * \brief	Sets the number of how many Activity(s) must be discarded initially
     * \param	$skip	the number of Activity(s) to skip
     */
    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    /**
     * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
     * \brief	Update a field of the object
     * \param	$objectId		the objectId of the Activity to update
     * \param	$field			the field of the Activity to update
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
                $parseObject = new parseObject('Activity');
                $parseObject->$field = toParseAddRelation($className, $value);
                $parseObject->update($objectId);
            } elseif ($typeRelation == 'remove') {
                $parseObject = new parseObject('Activity');
                $parseObject->$field = toParseRemoveRelation($className, $value);
                $parseObject->update($objectId);
            } else {
                return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
            }
        } else {
            $parseObject = new parseObject('Activity');
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

}

?>