<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 7/13/2018
 * Time: 5:54 PM
 */
session_start();
$new_stat_type = $_POST['type'];
$new_stat_name = $_POST['name'];
if (!isset($new_stat_type)) {
//    echo 'ERROR';
    exit();
}
$new_stat = $new_stat_type . " video " . $new_stat_name;
include_once 'functions.php';
date_default_timezone_set('America/Chicago');
add_stat($new_stat,$_SESSION['u_id']);