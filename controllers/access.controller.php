<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'utils.service.php';

/**
 * AccessController class
 * effettua operazioni di login e logut utente
 *
 * @author Daniele Caldelli
 * @author Maria Laura Fresu
 * @version		0.2
 * @since		2014-03-12
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 */
class AccessController extends REST {

    /**
     * Effettua il login dell'utente, inserendo i dati che servono in sessione
     * @todo    testare e attivare la password criptata, riga 50
     */
    public function login() {
        try {
            global $controllers;
            if ($_SESSION['id'] && $_SESSION['username']) {
                #TODO
                //$this -> response(array('status' => $controllers['ALREADYLOGGEDIND']), 405);
            }
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            }
            if (!isset($this->request['usernameOrEmail']) || !isset($this->request['password'])) {
                $this->response(array('status' => $controllers['NO CREDENTIALS']), 405);
            }
            $connectionService = new ConnectionService();
            $connection = $connectionService->connect();
            if ($connection != false) {
                $name = mysqli_real_escape_string($connection, stripslashes($this->request['usernameOrEmail']));
                $password = mysqli_real_escape_string($connection, stripslashes($this->request['password']));
                //$encriptedPassword = passwordEncryption($password);
                $user = $this->checkEmailOrUsername($connection, $password, $name);
                if (!$user) {
                    $this->response(array('status' => 'INVALID CREDENTIALS'), 503);
                }
                $_SESSION['id'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['type'] = $user->getType();
                $_SESSION['settings'] = $user->getSettings();
                $_SESSION['levelvalue'] = $user->getLevelvalue();
                $_SESSION['premium'] = $user->getPremium();
                $_SESSION['premiumexpirationdate'] = $user->getPremiumexpirationdate();
                $connectionService->disconnect($connection);
                $this->response(array('status' => $controllers['OKLOGIN']), 200);
            } else {
                $this->response(array('status' => 'ERROR CONNECT'), 503);
            }
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * Effettua il logout dell'utente, distruggendo la sessione
     * @todo    testare
     */
    public function logout() {
        $startTimer = microtime();
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during User logout "No POST action"');
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during User logout "No User in session"');
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            }
            session_unset();
            session_destroy();
            $endTimer = microtime();
            jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] User logout');
            $this->response(array('status' => $controllers['OKLOGOUT']), 200);
        } catch (Exception $e) {
            $endTimer = microtime();
            jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during User logout');
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * Check if user credentials are correct
     * @param string $connection Connessione
     * @param string $password password
     * @param string $name name or email
     * @return User User instance
     * @todo Testare
     */
    private function checkEmailOrUsername($connection, $password, $name) {
	$sql = "SELECT id,
                       levelvalue,
                       latitude,
                       longitude,
                       premium,
                       premiumexpirationdate,
                       type,
                       username
	      		FROM user
	      		WHERE password='$password' AND active = 1
	       			  AND (username='$name' OR email='$name')";
	$result = mysqli_query($connection, $sql);
	if (!$result || (mysqli_num_rows($result) != 1)) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query on Login');
	    return false;
	}

	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$user = new User();
	$user->setId($row['id']);
	$user->setLevelvalue($row['levelvalue']);
	$user->setLatitude($row['latitude']);
	$user->setLongitude($row['longitude']);
	$user->setPremium($row['premium']);
	$user->setPremiumexpirationdate($row['premiumexpirationdate']);
	/*
	  $sql = "SELECT setting
	  FROM user_setting
	  WHERE id = " . $row['id'];
	  $results = mysqli_query($connection, $sql);
	  if (!$results) {
	  jamLog(__FILE__, __LINE__, 'Unable to execute query for user setting on Login');
	  return false;
	  }
	  while ($row_setting = mysqli_fetch_array($results, MYSQLI_ASSOC))
	  $rows_setting[] = $row_setting;
	  $settings = array();
	  foreach ($rows_setting as $row_setting) {
	  $settings[] = $row_setting;
	  }
	  $user -> setSettings($settings); */
	$user->setType($row['type']);
	$user->setUsername($row['username']);
	return $user;
    }

}

?>