<?php
$restricted = 1;
$user_location = "practice_videos";
include_once 'includes/functions.php';
include 'includes/dbh-inc.php';
readfile("{$_GET['folder']}/{$_GET['videoname']}");