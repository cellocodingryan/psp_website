<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 8/7/2018
 * Time: 10:45 PM
 */
include_once 'functions.php';
if (isset($_POST['id'])) {
    date_default_timezone_set('America/Chicago');
    if ($_POST['play_pause'] == 0) {
        add_stat("User played assignment help video: ".$_POST['part_name'],$_POST['id']);
    } else {
        add_stat("User paused assignment help video: ".$_POST['part_name'],$_POST['id']);
    }
}