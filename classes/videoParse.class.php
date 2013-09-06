<?php
/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Video Class
 *  \details	Classe che contiene i video presi da Vimeo e Youtube e segnalati dagli utenti
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:video">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php??id=documentazione:api:video">API</a>
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.php';
require_once CLASSES_DIR . 'video.class.php';

class VideoParse {

	private $parseQuery;
	
	/**
	 * \fn		void __construct()
	 * \brief	The constructor instantiates a new object of type ParseQuery on the Video class
	 */
	public function __construct() {
		$this->parseQuery = new ParseQuery('Video');
	}

	/**
	 * \fn		void decrementVideo(string $objectId, string $field, int $value)
	 * \brief	Decrement the value of the $field of the objectId $objectId of $value unit
	 * \param	$objectId	the string that represent the objectId of the Video
	 * \param	$field		the string that represent the field to decrement
	 * \param 	$value		the number that represent the quantity to decrease the $field
	 * \return	int			the new value of the $field
	 * \return	error		in case of exception
	 */
	public function decrementImage($objectId, $field, $value) {
		try {
			$parseObject = new parseObject('Video');
			//we use the increment function with a negative value because decrement function still not work
			$parseObject->increment($field, array(0 - $value));
			$res = $parseObject->update($objectId);
			return $res->$field;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	/**
	 * \fn		void deleteVideo(string $objectId)
	 * \brief	Set unactive a specified Video by objectId
	 * \param	$objectId the string that represent the objectId of the Video
	 * \return	error in case of exception
	 */
	public function deleteVideo($objectId) {
		try {
			$parseObject = new parseObject('Video');
			$parseObject->active = false;
			$parseObject->update($objectId);
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		number getCount()
	 * \brief	Returns the number of requests Video
	 * \return	number
	 */
	public function getCount() {
		return $this->parseQuery->getCount()->count;
	}

	/**
	 * \fn		void getVideo(string $objectId)
	 * \brief	The function returns the Video object specified
	 * \param	$objectId the string that represent the objectId of the Video
	 * \return	Video	the Video with the specified $objectId
	 * \return	Error	the Error raised by the function
	 */
	public function getVideo($objectId) {
		try {
			$parseObject = new parseObject('Video');
			$res = $parseObject->get($objectId);
			$video = $this->parseToVideo($res);
			return $video;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		array getVideos()
	 * \brief	The function returns the Videos objects specified
	 * \return	array	an array of Video, if one or more Video are found
	 * \return	null	if no Video are found
	 * \return	Error	the Error raised by the function
	 */
	public function getVideos() {
		try {
			$videos = null;
			$res = $this->parseQuery->find();
			if (is_array($res->results) && count($res->results) > 0) {
				$videos = array();
				foreach ($res->results as $obj) {
					$video = $this->parseToVideo($obj);
					$videos[$video->getObjectId()] = $video;
				}
			}
			return $videos;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	/**
	 * \fn		void incrementVideo(string $objectId, string $field, int $value)
	 * \brief	iNcrement the value of the $field of the objectId $objectId of $value unit
	 * \param	$objectId	the string that represent the objectId of the Video
	 * \param	$field		the string that represent the field to increment
	 * \param 	$value		the number that represent the quantity to increase the $field
	 * \return	int			the new value of the $field
	 * \return	error		in case of exception
	 */
	public function incrementImage($objectId, $field, $value) {
		try {
			$parseObject = new parseObject('Video');
			$parseObject->increment($field, array($value));
			$res = $parseObject->update($objectId);
			return $res->$field;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	/**
	 * \fn		void orderBy($field)
	 * \brief	Specifies which field need to be ordered of requested Video
	 * \param	$field	the field on which to sort
	 */
	public function orderBy($field) {
		$this->parseQuery->orderBy($field);
	}

	/**
	 * \fn		void orderByAscending($field)
	 * \brief	Specifies which field need to be ordered ascending of requested Video
	 * \param	$field	the field on which to sort ascending
	 */
	public function orderByAscending($field) {
		$this->parseQuery->orderByAscending($field);
	}

	/**
	 * \fn		void orderByDescending($field)
	 * \brief	Specifies which field need to be ordered descending of requested Video
	 * \param	$field	the field on which to sort descending
	 */
	public function orderByDescending($field) {
		$this->parseQuery->orderByDescending($field);
	}

	/**
	 * \fn		Video parseToVideo($res)
	 * \brief	The function returns a representation of an Video object in Parse
	 * \param	$res	represent the Video object returned from Parse
	 * \return	Video	the Video object
	 * \return	Error	the Error raised by the function
	 */
	function parseToVideo($res) {
		if (is_null($res))
			return throwError(new Exception('parseToVideo parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$video = new Video();
			$video->setObjectId($res->objectId);
			$video->setActive($res->active);
			$video->setAuthor($res->author);
			#$video->setCommentators(fromParseRelation('Video', 'commentators', $res->objectId, '_User'));
			#$video->setComments(fromParseRelation('Video', 'comments', $res->objectId, 'Comment'));
			$video->setCounter($res->counter);
			$video->setDescription($res->description);
			$video->setDuration($res->duration);
			#$video->setFeaturing(fromParseRelation('Video', 'featuring', $res->objectId, '_User'));
			$video->setFromUser(fromParsePointer($res->fromUser));
			$video->setLoveCounter($res->loveCounter);
			#$video->setLovers(fromParseRelation('Video', 'lovers', $res->objectId, '_User'));
			$video->setTags($res->tags);
			$video->setTitle($res->title);
			$video->setThumbnail($res->thumbnail);
			$video->setURL($res->URL);
			$video->setCreatedAt(fromParseDate($res->createdAt));
			$video->setUpdatedAt(fromParseDate($res->updatedAt));
			$video->setACL(fromParseACL($res->ACL));
			return $video;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		Video saveVideo(Video $video)
	 * \brief	This function save an Video object in Parse
	 * \param	$video	represent the Video object to save
	 * \return	Video	the Video object with the new objectId parameter saved
	 * \return	Error	the Error raised by the function
	 */
	public function saveVideo($video) {
		if (is_null($video->getFromUser()))
			return throwError(new Exception('saveVideo parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$parseVideo = new parseObject('Video');
			is_null($video->getActive()) ? $parseVideo->active = true : $parseVideo->active = $video->getActive();
			is_null($video->getAuthor()) ? $parseVideo->author = null : $parseVideo->author = $video->getAuthor();
			is_null($video->getCommentators()) ? $parseVideo->commentators = null : $parseVideo->commentators = toParseAddRelation('_User', $video->getCommentators());
			is_null($video->getComments()) ? $parseVideo->comments = null : $parseVideo->comments = toParseAddRelation('Comment', $video->getComments());
			is_null($video->getCounter()) ? $parseVideo->counter = -1 : $parseVideo->counter = $video->getCounter();
			is_null($video->getDescription()) ? $parseVideo->description = null : $parseVideo->description = $video->getDescription();
			is_null($video->getDuration()) ? $parseVideo->duration = 0 : $parseVideo->duration = $video->getDuration();
			is_null($video->getFeaturing()) ? $parseVideo->featuring = null : $parseVideo->featuring = toParseAddRelation('_User', $video->getFeaturing());
			$parseVideo->fromUser = toParsePointer('_User', $video->getFromUser());
			is_null($video->getLoveCounter()) ? $parseVideo->loveCounter = -1 : $parseVideo->loveCounter = $video->getLoveCounter();
			is_null($video->getLovers()) ? $parseVideo->lovers = null : $parseVideo->lovers = toParseAddRelation('_User', $video->getLovers());
			is_null($video->getTags()) ? $parseVideo->tags = null : $parseVideo->tags = $video->getTags();
			is_null($video->getThumbnail()) ? $parseVideo->thumbnail = 'images/defult/videoThumb.jpg' : $parseVideo->thumbnail = $video->getThumbnail();
			is_null($video->getTitle()) ? $parseVideo->title = null : $parseVideo->title = $video->getTitle();
			is_null($video->getURL()) ? $parseVideo->URL = null : $parseVideo->URL = $video->getURL();
			is_null($video->getACL()) ? $parseVideo->ACL = toParseDefaultACL() : $parseVideo->ACL = toParseACL($video->getACL());
			if ($video->getObjectId() == '') {
				$res = $parseVideo->save();
				$video->setObjectId($res->objectId);
				return $video;
			} else {
				$parseVideo->update($video->getObjectId());
			}
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		void setLimit($limit)
	 * \brief	Sets the maximum number of Video to return
	 * \param	$limit	the maximum number
	 */
	public function setLimit($limit) {
		$this->parseQuery->setLimit($limit);
	}

	/**
	 * \fn		void setSkip($skip)
	 * \brief	Sets the number of how many Video(s) must be discarded initially
	 * \param	$skip	the number of Video(s) to skip
	 */
	public function setSkip($skip) {
		$this->parseQuery->setSkip($skip);
	}

		/**
	 * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
	 * \brief	Update a field of the object
	 * \param	$objectId		the objectId of the Video to update
	 * \param	$field			the field of the Video to update
	 * \param	$value			the value to update te field
	 * \param	$isRelation		[optional] default = false - define if the field is a relational type
	 * \param	$typeRelation	[optional] default = '' - define if the relational update must add or remove the value from the field
	 * \param	$className		[optional] default = '' - define the class of the type of object present into the relational field
	 */
	public function updateField($objectId, $field, $value, $isRelation = false, $typeRelation = '', $className = '') {
		if (is_null($objectId) || is_null($field) || is_null($value))
			return throwError(new Exception('updateField parameters objectId, field and value must to be set'), __CLASS__, __FUNCTION__, func_get_args());
		if ($isRelation) {
			if (is_null($typeRelation) || is_null($className))
				return throwError(new Exception('updateField parameters typeRelation and className must to be set for relation update'), __CLASS__, __FUNCTION__, func_get_args());
			if ($typeRelation == 'add') {
				$parseObject = new parseObject('Video');
				$parseObject->$field = toParseAddRelation($className, $value);
				$parseObject->update($objectId);
			} elseif ($typeRelation == 'remove') {
				$parseObject = new parseObject('Video');
				$parseObject->$field = toParseRemoveRelation($className, $value);
				$parseObject->update($objectId);
			} else {
				return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
			}
		} else {
			$parseObject = new parseObject('Video');
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
	 * \brief	Sets a condition for which to return all the Event objects present in the field $field of object $objectId of type $className
	 * \param	$field		the string which represent the field
	 * \param	$className	the string which represent the className
	 * \param	$objectId	the string which represent the objectId
	 */
	public function whereRelatedTo($field, $className, $objectId) {
		$this->parseQuery->whereRelatedTo($field, $className, $objectId);
	}

}

?> 