<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 6/15/2018
 * Time: 11:52 AM
 */

require(pathinfo(__FILE__, PATHINFO_DIRNAME)."/../config/passwords.php");


$dbServername = getenv('dbservername');
$dbUsername = getenv('dbusernname');
$dbPassword = getenv('dbpassword');
$dbName = getenv('dbName');

$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);
$GLOBALS['conn'] = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);