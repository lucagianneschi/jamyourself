<?php
/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Image
 *  \details	Classe per la singola immagine caricata dall'utente
 *  \par		Commenti:
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
require_once CLASSES_DIR . 'utils.php';
require_once CLASSES_DIR . 'image.class.php';

class ImageParse {

	private $parseQuery;

	/**
	 * \fn		void __construct()
	 * \brief	The constructor instantiates a new object of type ParseQuery on the Image class
	 */
	function __construct() {
		$this->parseQuery = new parseQuery('Image');
	}

	/**
	 * \fn		void deleteImage(string $objectId)
	 * \brief	Set unactive a specified Image by objectId
	 * \param	$objectId	the string that represent the objectId of the Image
	 * \return	error		in case of exception
	 */
	public function deleteImage($objectId) {
		try {
			$parseObject = new parseObject('Image');
			$parseObject->active = false;
			$parseObject->update($objectId);
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		number getCount()
	 * \brief	Returns the number of requests Image
	 * \return	number
	 */
	public function getCount() {
		$this->parseQuery->getCount();
	}

	/**
	 * \fn		void getImage(string $objectId)
	 * \brief	The function returns the Image object specified
	 * \param	$objectId	the string that represent the objectId of the Image
	 * \return	Image		the Image with the specified $objectId
	 * \return	Error		the Error raised by the function
	 */
	public function getImage($objectId) {
		try {
			$parseObject = new parseObject('Image');
			$res = $parseObject->get($objectId);
			return $this->parseToImage($res);
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		array getImages()
	 * \brief	The function returns the Images objects specified
	 * \return	array	an array of Image, if one or more Image are found
	 * \return	null	if no Image are found
	 * \return	Error	the Error raised by the function
	 */
	public function getImages() {
		try {
			$images = null;
			$res = $this->parseQuery->find();
			if (is_array($res->results) && count($res->results) > 0) {
				$images = array();
				foreach ($res->results as $obj) {
					$image = $this->parseToImage($obj);
					$images[$image->getObjectId()] = $image;
				}
			}
			return $images;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		void orderBy($field)
	 * \brief	Specifies which field need to be ordered of requested Image
	 * \param	$field	the field on which to sort
	 */
	public function orderBy($field) {
		$this->parseQuery->orderBy($field);
	}

	/**
	 * \fn		void orderByAscending($field)
	 * \brief	Specifies which field need to be ordered ascending of requested Image
	 * \param	$field	the field on which to sort ascending
	 */
	public function orderByAscending($field) {
		$this->parseQuery->orderByAscending($field);
	}

	/**
	 * \fn		void orderByDescending($field)
	 * \brief	Specifies which field need to be ordered descending of requested Image
	 * \param	$field	the field on which to sort descending
	 */
	public function orderByDescending($field) {
		$this->parseQuery->orderByDescending($field);
	}

	/**
	 * \fn		Image parseToImage($res)
	 * \brief	The function returns a representation of an Image object in Parse
	 * \param	$res	represent the Image object returned from Parse
	 * \return	Image	the Image object
	 * \return	Error	the Error raised by the function
	 */
	function parseToImage($res) {
		if (is_null($res))
			return throwError(new Exception('parseToImage parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$image = new Image();
			$image->setObjectId($res->objectId);
			$image->setActive($res->active);
			$image->setAlbum(fromParsePointer($res->album));
			$image->setCommentCounter($res->commentCounter);
			#$image->setCommentators(fromParseRelation('Image', 'commentators', $res->objectId, '_User'));
			#$image->setComments(fromParseRelation('Image', 'comments', $res->objectId, 'Comment'));
			$image->setCounter($res->counter);
			$image->setDescription($res->description);
			#$image->setFeaturing(fromParseRelation('Image', 'featuring', $res->objectId, '_User'));
			$image->setFile(fromParseFile($res->file));
			$image->setFilePath($res->filePath);
			$image->setFromUser(fromParsePointer($res->fromUser));
			$image->setLocation(fromParseGeoPoint($res->location));
			$image->setLoveCounter($res->loveCounter);
			#$image->setLovers(fromParseRelation('Image', 'lovers', $res->objectId, '_User'));
			$image->setShareCounter($res->shareCounter);
			$image->setTags($res->tags);
			$image->setCreatedAt(fromParseDate($res->createdAt));
			$image->setUpdatedAt(fromParseDate($res->updatedAt));
			$image->setACL(fromParseACL($res->ACL));
			return $image;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		Image saveImage(Image $image)
	 * \brief	This function save an Image object in Parse
	 * \param	$image	represent the Image object to save
	 * \return	Image	the Image object with the new objectId parameter saved
	 * \return	Error	the Error raised by the function
	 */
	function saveImage($image) {
		if (is_null($image->getFromUser()))
			return throwError(new Exception('saveImage parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$parseImage = new parseObject('Image');
			is_null($image->getActive()) ? $parseImage->active = true : $parseImage->active = $image->getActive();
			is_null($image->getAlbum()) ? $parseImage->album = null : $parseImage->album = toParsePointer('Album', $image->getAlbum());
			is_null($image->getCommentCounter()) ? $parseImage->commentCounter = null : $parseImage->commentCounter = $image->getCommentCounter();
			is_null($image->getCommentators()) ? $parseImage->commentators = null : $parseImage->commentators = toParseAddRelation('_User', $image->getCommentators());
			is_null($image->getComments()) ? $parseImage->comments = null : $parseImage->comments = toParseAddRelation('Comment', $image->getComments());
			is_null($image->getCounter()) ? $parseImage->counter = null : $parseImage->counter = $image->getCounter();
			is_null($image->getDescription()) ? $parseImage->description = null : $parseImage->description = $image->getDescription();
			is_null($image->getFeaturing()) ? $parseImage->featuring = null : $parseImage->featuring = toParseAddRelation('_User', $image->getFeaturing());
			is_null($image->getFile()) ? $parseImage->file = null : $parseImage->file = toParseFile($image->getFile());
			is_null($image->getFilePath()) ? $parseImage->filePath = null : $parseImage->filePath = $image->getFilePath();
			$parseImage->fromUser = toParsePointer('_User', $image->getFromUser());
			is_null($image->getLocation()) ? $parseImage->location = null : $parseImage->location = toParseGeoPoint($image->getLocation());
			is_null($image->getLoveCounter()) ? $parseImage->loveCounter = null : $parseImage->loveCounter = $image->getLoveCounter();
			is_null($image->getLovers()) ? $parseImage->lovers = null : $parseImage->lovers = toParseAddRelation('_User', $image->getLovers());
			is_null($image->getShareCounter()) ? $parseImage->shareCounter = null : $parseImage->shareCounter = $image->getShareCounter();
			is_null($image->getTags()) ? $parseImage->tags = null : $parseImage->tags = $image->getTags();
			is_null($image->getACL()) ? $parseImage->ACL = toParseDefaultACL() : $parseImage->ACL = toParseACL($image->getACL());
			if ($image->getObjectId() == '') {
				$res = $parseImage->save();
				$image->setObjectId($res->objectId);
				return $image;
			} else {
				$parseImage->update($image->getObjectId());
			}
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		void setLimit($limit)
	 * \brief	Sets the maximum number of Image to return
	 * \param	$limit	the maximum number
	 */
	public function setLimit($limit) {
		$this->parseQuery->setLimit($limit);
	}

	/**
	 * \fn		void setSkip($skip)
	 * \brief	Sets the number of how many Image(s) must be discarded initially
	 * \param	$skip	the number of Image(s) to skip
	 */
	public function setSkip($skip) {
		$this->parseQuery->setSkip($skip);
	}

	/**
	 * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
	 * \brief	Update a field of the object
	 * \param	$objectId		the objectId of the Image to update
	 * \param	$field			the field of the Image to update
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
				$parseObject = new parseObject('Image');
				$parseObject->$field = toParseAddRelation($className, $value);
				$parseObject->update($objectId);
			} elseif ($typeRelation == 'remove') {
				$parseObject = new parseObject('Image');
				$parseObject->$field = toParseRemoveRelation($className, $value);
				$parseObject->update($objectId);
			} else {
				return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
			}
		} else {
			$parseObject = new parseObject('Image');
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
