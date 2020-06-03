<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 6/15/2018
 * Time: 2:01 PM
 */

session_start();
include_once 'functions.php';
add_stat("Logged Out",$_SESSION['u_id']);
session_unset();
session_destroy();
header("Location: ../index.php");
exit();