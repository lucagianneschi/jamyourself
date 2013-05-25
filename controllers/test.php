<?php
require_once '../parse_stefano/parse.php';
require_once '../classes/activity.class.php';
require_once '../classes/activityParse.class.php';
require_once '../classes/user.class.php';
require_once '../classes/userParse.class.php';
require_once '../classes/playlist.class.php';
require_once '../classes/playlistParse.class.php';
require_once '../classes/song.class.php';
require_once '../classes/songParse.class.php';
require_once '../log/log.php';
require_once '../classes/pointerParse.class.php';

$userId = "n1TXVlIqHw";

$u =new UserParse();

$user = $u->getUserById($userId);
// echo $user;
if($user==null) die();

$p= new PlaylistParse();

$ret = $p->getUserPlaylists($user);

// $playlist = new Playlist();

// $playlist->setActive(true);
// $playlist->setSongs(array());
// $playlist->setFromUser($user);
// $playlist->setName("Playlist Test 3");

// $ret = $p->save($playlist);

foreach ($ret as $r) echo $r."<br>";


// echo $ret;