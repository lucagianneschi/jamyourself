<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'userParse.class.php';

$pUser = new UserParse();
$pUser->whereContainedIn("username", array("pippo",  "gabriele.spatafora")); 
$result = $pUser->getCount();
echo $result
        ?>