<?php
require_once 'init.php';
$flash = new flash();
$flash->add_success("Logged out");
user::logout();
header("Location: index.php");
exit();