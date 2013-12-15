<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';

class TestController extends REST {

    public function test() {
        if ($this->get_request_method() != "POST") {
            $this->response(array('status' => "NO POST REQUEST"), 405);
        }else if(isset($this->request['forceError']) && $this->request['forceError']){
                $this->response(array('status' => "FORCE ERROR OK"), 405);               
        }else{
                $this->response(array('status' => "OK"), 200);
        }
    }
}

?>