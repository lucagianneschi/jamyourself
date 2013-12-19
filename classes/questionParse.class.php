<?php

/* ! \par       Info Generali:
 *  \author     Daniele Caldelli
 *  \version    1.0
 *  \date       2013
 *  \copyright  Jamyourself.com 2013
 *  \par        Info Classe:
 *  \brief      QuestionParse
 *  \details    Classe Parse dedicata alle domande e alle risposte tra utenti e amministrazione
 *  \par        Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:question">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:question">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';

class QuestionParse {

    private $parseQuery;

    /**
     * \fn		void __construct()
     * \brief	The constructor instantiates a new object of type ParseQuery on the Question class
     */
    public function __construct() {
        $this->parseQuery = new parseQuery('Question');
    }

    /**
     * \fn		number getCount()
     * \brief	Returns the number of requests Question
     * \return	number
     */
    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    /**
     * \fn		void getQuestion(string $objectId)
     * \brief	The function returns the Question object specified
     * \param	$objectId the string that represent the objectId of the Question
     * \return	Question	the Question with the specified $objectId
     * \return	Error		the Error raised by the function
     */
    public function getQuestion($objectId) {
        try {
            $parseObject = new parseObject('Question');
            $res = $parseObject->get($objectId);
            $question = $this->parseToQuestion($res);
            return $question;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		array getQuestions()
     * \brief	The function returns the Questions objects specified
     * \return	array 	an array of Question, if one or more Question are found
     * \return	null	if no Question are found
     * \return	Error	the Error raised by the function
     */
    public function getQuestions() {
        try {
            $questions = null;
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $questions = array();
                foreach ($res->results as $obj) {
                    $question = $this->parseToQuestion($obj);
                    $questions[$question->getObjectId()] = $question;
                }
            }
            return $questions;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void orderBy($field)
     * \brief	Specifies which field need to be ordered of requested Question
     * \param	$field	the field on which to sort
     */
    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    /**
     * \fn		void orderByAscending($field)
     * \brief	Specifies which field need to be ordered ascending of requested Question
     * \param	$field	the field on which to sort ascending
     */
    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    /**
     * \fn		void orderByDescending($field)
     * \brief	Specifies which field need to be ordered descending of requested Question
     * \param	$field	the field on which to sort descending
     */
    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    /**
     * \fn		Question parseToQuestion($res)
     * \brief	The function returns a representation of an Question object in Parse
     * \param	$res		represent the Question object returned from Parse
     * \return	Question	the Question object
     * \return	Error		the Error raised by the function
     */
    function parseToQuestion($res) {
        if (is_null($res))
            return throwError(new Exception('parseToQuestion parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $question = new Question();
            $question->setObjectId($res->objectId);
            $question->setAnswer(parse_decode_string($res->answer));
            $question->setMailFrom(parse_decode_string($res->mailFrom));
            $question->setMailTo(parse_decode_string($res->mailTo));
            $question->setName(parse_decode_string($res->mailTo));
            $question->setReplied($res->replied);
            $question->setSubject(parse_decode_string($res->subject));
            $question->setText(parse_decode_string($res->text));
            $question->setCreatedAt(fromParseDate($res->createdAt));
            $question->setUpdatedAt(fromParseDate($res->updatedAt));
            $question->setACL(fromParseACL($res->ACL));
            return $question;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		Question saveQuestion(Question $question)
     * \brief	This function save an Question object in Parse
     * \param	$question 	represent the Question object to save
     * \return	Question	the Question object with the new objectId parameter saved
     * \return	Error		the Error raised by the function
     */
    public function saveQuestion($question) {
        if (!is_null($question->getObjectId())) {
            return throwError(new Exception('saveQuestion update is not allow here'), __CLASS__, __FUNCTION__, func_get_args());
        }
        try {
            $parseObject = new parseObject('Question');
            $parseObject->answer = is_null($question->getAnswer()) ? null : $question->getAnswer();
            $parseObject->mailFrom = is_null($question->getMailFrom()) ? null : parse_encode_string($question->getMailFrom());
            $parseObject->mailTo = is_null($question->getMailTo()) ? null : parse_encode_string($question->getMailTo());
            $parseObject->name = is_null($question->getName()) ? null : $question->getName();
            $parseObject->replied = is_null($question->getReplied()) ? false : $question->getReplied();
            $parseObject->subject = is_null($question->getSubject()) ? null : parse_encode_string($question->getSubject());
            $parseObject->text = is_null($question->getText()) ? null : parse_encode_string($question->getText());
            $parseObject->ACL = is_null($question->getACL()) ? toParseDefaultACL() : toParseACL($question->getACL());
            $res = $parseObject->save();
            $question->setObjectId($res->objectId);
            return $question;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void setLimit($limit)
     * \brief	Sets the maximum number of Question to return
     * \param	$limit	the maximum number
     */
    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    /**
     * \fn		void setSkip($skip)
     * \brief	Sets the number of how many Question(s) must be discarded initially
     * \param	$skip	the number of Question(s) to skip
     */
    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    /**
     * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
     * \brief	Update a field of the object
     * \param	$objectId		the objectId of the Comment to update
     * \param	$field			the field of the Question to update
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
                $parseObject = new parseObject('Question');
                $parseObject->$field = toParseAddRelation($className, $value);
                $parseObject->update($objectId);
            } elseif ($typeRelation == 'remove') {
                $parseObject = new parseObject('Question');
                $parseObject->$field = toParseRemoveRelation($className, $value);
                $parseObject->update($objectId);
            } else {
                return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
            }
        } else {
            $parseObject = new parseObject('Question');
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

}

?>