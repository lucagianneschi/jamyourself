<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     geoPointParse
 *  \details   Classe che serve per accogliere latitudine e longitudine di un 
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:faq">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:faq">API</a>
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');
	
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.php';
require_once CLASSES_DIR . 'faq.class.php';

class FaqParse {

	private $parseQuery;
	
	/**
	 * \fn		void __construct()
	 * \brief	The constructor instantiates a new object of type ParseQuery on the FAQ class
	 */
	public function __construct() {
		$this->parseQuery = new parseQuery('FAQ');
	}
	
	/**
	 * \fn		number getCount()
	 * \brief	Returns the number of requests FAQ
	 * \return	number
	 */
	public function getCount() {
		return $this->parseQuery->getCount()->count;
	}
	
	/**
	 * \fn		array getDistinctAreas()
	 * \brief	Returns the type of the areas for FAQ
	 * \return	array
	 */
	public function getDistinctAreas() {
		$faqs = $this->getFaqs();
		$aree = array();
		foreach ($faqs as $faq) {
			$aree[] = $faq->getArea();
		}
		$aree = array_unique($aree);
		natcasesort($aree);
	
		return $aree;
	}
	
	/**
	 * \fn		array getDistinctTags()
	 * \brief	Returns the type of the tags for FAQ
	 * \return	array
	 */
	public function getDistinctTags() {
		$faqs = $this->getFaqs();
		$tags = array();
		foreach ($faqs as $faq) {
			$tags = array_merge($tags, $faq->getTag());
		}
		$tags = array_unique($tags);
		natcasesort($tags);
	
		return $tags;
	}
	
	/**
	 * \fn		void getFaq(string $objectId)
	 * \brief	The function returns the FAQ object specified
	 * \param	$objectId the string that represent the objectId of the FAQ
	 * \return	FAQ	the FAQ with the specified $objectId
	 * \return	Error	the Error raised by the function
	 */
	public function getFaq($objectId) {
		try {
			$parseFaq = new parseObject('FAQ');
			$res = $parseFaq->get($objectId);
			$faq = $this->parseToFaq($res);
			return $faq;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	/**
	 * \fn		array getFaqs()
	 * \brief	The function returns the FAQs objects specified
	 * \return	array 	an array of FAQ, if one or more FAQ are found
	 * \return	null	if no FAQ are found
	 * \return	Error	the Error raised by the function
	 */
	public function getFaqs() {
		try {
			$faqs = null;
			$res = $this->parseQuery->find();
			if (is_array($res->results) && count($res->results) > 0) {
				$faqs = array();
				foreach ($res->results as $obj) {
					$faq = $this->parseToFaq($obj);
					$faqs[$faq->getObjectId()] = $faq;
				}
			}
			return $faqs;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		void orderBy($field)
	 * \brief	Specifies which field need to be ordered of requested FAQ
	 * \param	$field	the field on which to sort
	 */
	public function orderBy($field) {
		$this->parseQuery->orderBy($field);
	}	
	
	/**
	 * \fn		void orderByAscending($field)
	 * \brief	Specifies which field need to be ordered ascending of requested FAQ
	 * \param	$field	the field on which to sort ascending
	 */
	public function orderByAscending($field) {
		$this->parseQuery->orderByAscending($field);
	}
	
	/**
	 * \fn		void orderByDescending($field)
	 * \brief	Specifies which field need to be ordered descending of requested FAQ
	 * \param	$field	the field on which to sort descending
	 */
	public function orderByDescending($field) {
		$this->parseQuery->orderByDescending($field);
	}

	/**
	 * \fn		FAQ parseToFAQ($res)
	 * \brief	The function returns a representation of an FAQ object in Parse
	 * \param	$res 	represent the FAQ object returned from Parse
	 * \return	FAQ	the FAQ object
	 * \return	Error	the Error raised by the function
	 */
	public function parseToFaq($res) {
		if (is_null($res))
			return throwError(new Exception('parseToFaq parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$faq = new Faq();
			$faq->setObjectId($res->objectId);
			$faq->setAnswer($res->answer);
			$faq->setArea($res->area);
			$faq->setPosition($res->position);
			$faq->setQuestion($res->question);
			$faq->setTags($res->tags);
			$faq->setCreatedAt(new DateTime($res->createdAt));
			$faq->setUpdatedAt(new DateTime($res->updatedAt));
			$faq->setACL(fromParseACL($res->ACL));
			return $faq;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		FAQ saveFAQ(FAQ $faq)
	 * \brief	This function save an FAQ object in Parse
	 * \param	$faq 	represent the FAQ object to save
	 * \return	FAQ	the FAQ object with the new objectId parameter saved
	 * \return	Error	the Error raised by the function
	 */
	public function saveFaq($faq) {
		if ($faq->getObjectId() != null)
			return throwError(new Exception('saveFaq update is not allow here'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$parseFaq= new parseObject('FAQ');
			
			is_null($faq->getAnswer()) ? $parseFaq->answer = null : $parseFaq->answer = $faq->getAnswer();
			is_null($faq->getArea()) ? $parseFaq->area = null : $parseFaq->area = $faq->getArea();
			is_null($faq->getPosition()) ? $parseFaq->position = null : $parseFaq->position = $faq->getPosition();
			is_null($faq->getQuestion()) ? $parseFaq->question = null : $parseFaq->question = $faq->getQuestion();
			is_null($faq->getTags()) ? $parseFaq->tags = null : $parseFaq->tags = $faq->getTags();
			is_null($faq->getACL()) ? $parseFaq->ACL = toParseDefaultACL() : $parseFaq->ACL = toParseACL($faq->getACL());
			$res = $parseFaq->save();
			$faq->setObjectId($res->objectId);
			return $faq;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		void setLimit($limit)
	 * \brief	Sets the maximum number of FAQ to return
	 * \param	$limit	the maximum number
	 */
	public function setLimit($limit) {
		$this->parseQuery->setLimit($limit);
	}
	
	/**
	 * \fn		void setSkip($skip)
	 * \brief	Sets the number of how many FAQ(s) must be discarded initially
	 * \param	$skip	the number of FAQ(s) to skip
	 */
	public function setSkip($skip) {
		$this->parseQuery->setSkip($skip);
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
		
	public function whereRelatedTo($field, $className, $objectId) {
		$this->parseQuery->whereRelatedTo($field, $className, $objectId);
	}

}

?>