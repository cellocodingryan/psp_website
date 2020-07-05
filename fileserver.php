<?php
require_once 'models/user.php';
session_start();
require_once 'models/video_server.php';
user::auth("member");
$v = new video_server("{$_GET['folder']}/{$_GET['file']}");
$v->start();