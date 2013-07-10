<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

include_once ROOT_DIR . 'config.php';
include_once PARSE_DIR . 'parse.php';
include_once CLASSES_DIR . 'utils.php';


$parseQuery = new parseQuery('_User');
$parseQuery->setLimit(5);
$parseQuery->whereExists('createdAt');
$parseQuery->orderByAscending('updatedAt');
$parseQuery->find();
$string = '';
foreach ($parseQuery as $user) {
    $string .= '[objectId] => ' . $user->getObjectId() . '<br />';
    $string .= '[username] => ' . $user->getUsername() . '<br />';
    $string .= '[type] => ' . $user->getType() . '<br/>';
    return $string;
}
?>
