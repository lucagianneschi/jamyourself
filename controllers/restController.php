<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

class REST {

    public $stringConfig;
    public $_allow = array();
    public $_content_type = "application/json";
    public $request = array();
    private $_method = "";
    private $_code = 200;
    public $data = "";

    public function __construct() {
        $this->stringConfig = json_decode(file_get_contents(CONTROLLERS_DIR."config/string.config.json"),true);
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
        $config = $this->stringConfig;
        $controllers = $config['controllers'];

        $status = array(
            100 => $controllers['100'],
            101 => $controllers['101'],
            200 => $controllers['200'],
            201 => $controllers['201'],
            202 => $controllers['202'],
            203 => $controllers['203'],
            204 => $controllers['204'],
            205 => $controllers['205'],
            206 => $controllers['206'],
            300 => $controllers['300'],
            301 => $controllers['301'],
            302 => $controllers['302'],
            303 => $controllers['303'],
            304 => $controllers['304'],
            305 => $controllers['305'],
            306 => $controllers['306'],
            307 => $controllers['307'],
            400 => $controllers['400'],
            401 => $controllers['401'],
            402 => $controllers['402'],
            403 => $controllers['403'],
            404 => $controllers['404'],
            405 => $controllers['405'],
            406 => $controllers['406'],
            407 => $controllers['407'],
            408 => $controllers['408'],
            409 => $controllers['409'],
            410 => $controllers['410'],
            411 => $controllers['411'],
            412 => $controllers['412'],
            413 => $controllers['413'],
            414 => $controllers['414'],
            415 => $controllers['415'],
            416 => $controllers['416'],
            417 => $controllers['417'],
            500 => $controllers['500'],
            501 => $controllers['501'],
            502 => $controllers['502'],
            503 => $controllers['503'],
            504 => $controllers['504'],
            505 => $controllers['505']);
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
        $msg = $this->get_status_message();
        $content = $this->_content_type;
        header("HTTP/1.1 " . $this->_code . " " . $this->get_status_message());
        header("Content-Type:" . $this->_content_type);
    }

    public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['request'])));
        if ((int) method_exists($this, $func) > 0)
            $this->$func();
        else
            $this->response('', 404);    // If the method not exist with in this class, response would be "Page not found".
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