<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright		Jamyourself.com 2013 * \par			Info Classe: * \brief		box caricamento info event * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view * \par			Commenti: * \warning * \bug * \todo		 * */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';require_once CLASSES_DIR . 'record.class.php';require_once CLASSES_DIR . 'recordParse.class.php';/** * \brief	RecordBox class  * \details	box class to pass info to the view for personal page, media page & uploadRecord page */class RecordBox {    public $config;    public $error;    public $recordArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/record.config.json"), false);    }    /**     * \fn	initForMediaPage($objectId)     * \brief	init for Media Page     * \param	$objectId of the record to display in Media Page     * \todo         */    public function initForMediaPage($objectId) {        $recordP = new RecordParse();        $recordP->where('objectId', $objectId);        $recordP->where('active', true);        $recordP->whereInclude('fromUser');        $recordP->setLimit(MIN);        $records = $recordP->getRecords();        if ($records instanceof Error) {            $this->errorManagement($records->getErrorMessage());            return;        } elseif (is_null($records)) {            $this->errorManagement();            return;        } else {            $this->error = null;            $this->recordArray = $records;        }    }    /**     * \fn	initForPersonalPage($objectId)     * \brief	init for recordBox for personal Page     * \param	$objectId of the user who owns the page     * \todo	     */    public function initForPersonalPage($objectId, $limit = null, $skip = null) {        $record = new RecordParse();        $record->wherePointer('fromUser', '_User', $objectId);        $record->where('active', true);        $record->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : DEFAULTQUERY);        $record->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);        $record->orderByDescending('createdAt');        $records = $record->getRecords();        if ($records instanceof Error) {            $this->errorManagement($records->getErrorMessage());            return;        } elseif (is_null($records)) {            $this->errorManagement();            return;        } else {            $this->error = null;            $this->recordArray = $records;        }    }    /**     * \fn	init($genre = null, $limit = null, $skip = null)     * \brief	Init RecordFilter instance for TimeLine     * \param	$genre = null, $limit = null, $skip = null     * \todo     */    public function initForStream ($geopoint = array(), $city = null, $country = null, $genre = array(), $limit = null, $skip = null, $distance = null, $unit = 'km', $field = 'loveCounter') {        require_once BOXES_DIR . 'utilsBox.php';        $currentUserId = sessionChecker();        if (is_null($currentUserId)) {            $this->errorManagement(ONLYIFLOGGEDIN);            return;        }        $record = new RecordParse();        if (count($geopoint) != 0) {            $record->whereNearSphere($geopoint[0], $geopoint[1], (is_null($distance) || !is_numeric($distance)) ? $this->config->distanceLimitForRecord : $distance, ($unit == 'km') ? $unit : 'mi');        } elseif (!is_null($city) || !is_null($country)) {            $locations = findLocationCoordinates($city, $country);            if (!($locations instanceof Error) && !is_null($locations)) {                $lat = current($locations)->getGeopoint()->location['latitude'];                $long = current($locations)->getGeopoint()->location['longitude'];            }            $record->whereNearSphere($lat, $long, (is_null($distance) || !is_numeric($distance)) ? $this->config->distanceLimitForRecord : $distance, ($unit == 'km') ? $unit : 'mi');        }        if (count($genre) != 0) {            $record->whereContainedIn('genre', $genre);        }        $record->whereExists('createdAt');        $record->whereInclude('fromUser');        $record->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitRecordForTimeline);        $record->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);        if (((count($geopoint) == 0) && (is_null($city)) && is_null($country))) {            $record->orderByDescending($field);        }        $records = $record->getRecords();        if ($records instanceof Error) {            $this->errorManagement($records->getErrorMessage());            return;        } elseif (is_null($records)) {            $this->errorManagement();            return;        } else {            $this->error = null;            $this->recordArray = $records;        }    }    /**     * \fn	initForUploadRecordPage($objectId)     * \brief	init for recordBox for upload record page     * \param	$objectId of the user who owns the record     */    public function initForUploadRecordPage() {        require_once BOXES_DIR . 'utilsBox.php';        $currentUserId = sessionChecker();        if (is_null($currentUserId)) {            $this->errorManagement(ONLYIFLOGGEDIN);            return;        }        $record = new RecordParse();        $record->wherePointer('fromUser', '_User', $currentUserId);        $record->where('active', true);        $record->setLimit($this->config->limitRecordForUploadRecordPage);        $record->orderByDescending('createdAt');        $records = $record->getRecords();        if ($records instanceof Error) {            $this->errorManagement($records->getErrorMessage());            return;        } elseif (is_null($records)) {            $this->errorManagement();            return;        } else {            $this->error = null;            $this->recordArray = $records;        }    }    /**     * \fn	errorManagement($errorMessage = null)     * \brief	set values in case of error or nothing to send to the view     * \param	$errorMessage     */    private function errorManagement($errorMessage = null) {        $this->config = null;        $this->error = $errorMessage;        $this->recordArray = array();    }}?>