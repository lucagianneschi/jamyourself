<?php

/* File : Rest.inc.php
 * Author : Arun Kumar Sekar
 */

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
        $status = array(
            100 => '100',												
            101 => '101',												
            200 => '200',												
            201 => '201',												
            202 => '202',												
            203 => '203',												
            204 => '204',												
            205 => '205',												
            206 => '206',												
            300 => '300',												
            301 => '301',												
            302 => '302',												
            303 => '303',												
            304 => '304',												
            305 => '305',												
            306 => '306',												
            307 => '307',												
            400 => '400',												
            401 => '401',												
            402 => '402',												
            403 => '403',												
            404 => '404',												
            405 => '405',												
            406 => '406',												
            407 => '407',												
            408 => '408',												
            409 => '409',												
            410 => '410',												
            411 => '411',												
            412 => '412',												
            413 => '413',												
            414 => '414',												
            415 => '415',												
            416 => '416',												
            417 => '417',												
            500 => '500',												
            501 => '501',												
            502 => '502',												
            503 => '503',												
            504 => '504',												
            505 => '505');												
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