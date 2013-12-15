<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

class REST {

    public $_allow = array();
    public $_content_type = "application/json";
    public $request = array();
    private $_method = "";
    private $_code = 200;
    public $data = "";

    public function __construct() {
	$this->inputs();
    }

    public function get_referer() {
	return $_SERVER['HTTP_REFERER'];
    }

    public function response($data, $status) {
	$this->_code = ($status) ? $status : 200;
	$this->set_headers();
	echo $this->json($data);
	exit;
    }

    private function get_status_message() {
	global $rest_strings;
	$status = array(
	    100 => $rest_strings['100'],
	    101 => $rest_strings['101'],
	    200 => $rest_strings['200'],
	    201 => $rest_strings['201'],
	    202 => $rest_strings['202'],
	    203 => $rest_strings['203'],
	    204 => $rest_strings['204'],
	    205 => $rest_strings['205'],
	    206 => $rest_strings['206'],
	    300 => $rest_strings['300'],
	    301 => $rest_strings['301'],
	    302 => $rest_strings['302'],
	    303 => $rest_strings['303'],
	    304 => $rest_strings['304'],
	    305 => $rest_strings['305'],
	    306 => $rest_strings['306'],
	    307 => $rest_strings['307'],
	    400 => $rest_strings['400'],
	    401 => $rest_strings['401'],
	    402 => $rest_strings['402'],
	    403 => $rest_strings['403'],
	    404 => $rest_strings['404'],
	    405 => $rest_strings['405'],
	    406 => $rest_strings['406'],
	    407 => $rest_strings['407'],
	    408 => $rest_strings['408'],
	    409 => $rest_strings['409'],
	    410 => $rest_strings['410'],
	    411 => $rest_strings['411'],
	    412 => $rest_strings['412'],
	    413 => $rest_strings['413'],
	    414 => $rest_strings['414'],
	    415 => $rest_strings['415'],
	    416 => $rest_strings['416'],
	    417 => $rest_strings['417'],
	    500 => $rest_strings['500'],
	    501 => $rest_strings['501'],
	    502 => $rest_strings['502'],
	    503 => $rest_strings['503'],
	    504 => $rest_strings['504'],
	    505 => $rest_strings['505']);
	return ($status[$this->_code]) ? $status[$this->_code] : $status[500];
    }

    public function get_request_method() {
	return $_SERVER['REQUEST_METHOD'];
    }

    private function inputs() {
	switch ($this->get_request_method()) {
	    case "POST":
		$this->request = $this->cleanInputs($_POST);
		break;
	    case "GET":
	    case "DELETE":
		$this->request = $this->cleanInputs($_GET);
		break;
	    case "PUT":
		parse_str(file_get_contents("php://input"), $this->request);
		$this->request = $this->cleanInputs($this->request);
		break;
	    default:
		$this->response('', 406);
		break;
	}
    }

    private function cleanInputs($data) {
	$clean_input = array();
	if (is_array($data)) {
	    foreach ($data as $k => $v) {
		$clean_input[$k] = $this->cleanInputs($v);
	    }
	} else {
	    if (get_magic_quotes_gpc()) {
		$data = trim(stripslashes($data));
	    }
	    $data = strip_tags($data);
	    $clean_input = trim($data);
	}
	return $clean_input;
    }

    private function set_headers() {
	header("HTTP/1.1 " . $this->_code . " " . $this->get_status_message());
	header("Content-Type:" . $this->_content_type);
    }

    public function processApi() {
	if (isset($_REQUEST['request'])) {
	    $func = strtolower(trim(str_replace("/", "", $_REQUEST['request'])));
	    if ((int) method_exists($this, $func) > 0)
		$this->$func();
	    else
		$this->response('', 404);    // If the method not exist with in this class, response would be "Page not found".            
	}
    }

    /*
     * 	Encode array into JSON
     */

    public function json($data) {
	if (is_array($data)) {
	    return json_encode($data);
	}
    }

}

?>