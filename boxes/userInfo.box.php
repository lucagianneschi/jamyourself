<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright		Jamyourself.com 2013 * \par			Info Classe: * \brief		box caricamento info utente * \details		Recupera le informazioni dell'utente, le inserisce in un array da passare alla view * \par			Commenti: * \warning * \bug * \todo		 * */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';require_once CLASSES_DIR . 'user.class.php';require_once CLASSES_DIR . 'userParse.class.php';/** * \brief	UserInfoBox class  * \details	box class to pass info to the view  */class UserInfoBox {    public $user;    public $error;    /**     * \fn	initForPersonalPage($objectId)     * \brief	Init InfoBox instance for Personal Page     * \param	$objectId for user that owns the page     */    public function init($objectId) {        $userParse = new UserParse();        $user = $userParse->getUser($objectId);        if ($user instanceof Error) {            $this->error = $user->getErrorMessage();            $this->user = null;            return;        } else {            $this->error = null;            $this->user = $user;        }    }}?>