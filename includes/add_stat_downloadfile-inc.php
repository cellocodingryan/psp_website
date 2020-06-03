<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 7/23/2018
 * Time: 5:52 PM
 */
include_once 'functions.php';
if (isset($_POST['id'])) {
    add_stat("User Downloaded the part: ".$_POST['part_name'],$_POST['id']);
}