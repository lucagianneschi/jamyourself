<?php/* ! \par                Info Generali: * \author                Luca Gianneschi * \version                1.0 * \date                2013 * \copyright                Jamyourself.com 2013 * \par                        Info Classe: * \brief                box caricamento review event * \details                Recupera le informazioni sulla review dell'event, le inserisce in un array da passare alla view * \par                        Commenti: * \warning * \bug * \todo                 */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';require_once SERVICES_DIR . 'debug.service.php';/** * \brief        ReviewBox class * \details        box class to pass info to the view */class ReviewBox {    public $config;    public $error;    public $mediaInfo;    public $reviewArray;    /**     * \fn        initForMediaPage($objectId, $className, $limit, $skip)     * \brief        Init ReviewBox instance for Media Page     * \param        $objectId of the review to display information, Event or Record class     * \param   $className, $limit, $skip,$currentUserId     * \todo             */    public function initForMediaPage($objectId, $className, $limit = null, $skip = null) {	$this->error = null;	$this->reviewArray = array();    }    /**     * \fn        initForPersonalPage($objectId, $type, $className)     * \brief        Init ReviewBox instance for Personal Page     * \param        $objectId of the user who owns the page, $type of user, $className Record or Event class     * \param   $type, $className     */    function initForPersonalPage($objectId, $type, $className, $limit = null, $skip = null) {	$this->error = null;	$this->reviewArray = array();    }    /**     * \fn        initForUploadReviewPage($objectId, $className)     * \brief        Init REviewBox instance for Upload Review Page     * \param        $objectId for the event or record, $className Record or Event     * \todo         */    public function initForUploadReviewPage($objectId, $className) {	require_once SERVICES_DIR . 'utils.service.php';	$currentUserId = sessionChecker();	if (is_null($currentUserId)) {	    $this->errorManagement(ONLYIFLOGGEDIN);	    return;	}	$this->error = null;	$this->reviewArray = array();    }    /**     * \fn        errorManagement($errorMessage = null)     * \brief        set values in case of error or nothing to send to the view     * \param        $errorMessage     */    private function errorManagement($errorMessage = null) {	$this->config = null;	$this->error = $errorMessage;	$this->mediaInfo = array();	$this->reviewArray = array();    }}?>