<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 7/13/2018
 * Time: 8:42 PM
 */

$restricted = 2;
$user_location = "limbo";
include_once 'nav.php';
include_once 'includes/dbh-inc.php';
include_once 'includes/functions.php';

$user_id = $_GET['user_id'];
$name = $_GET['user_first'];
$username = $_GET['user_name'];
header("Location: ../resetpass.php?user_name=$name&user_id=$user_id&username=$username");