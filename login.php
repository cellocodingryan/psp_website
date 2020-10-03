<?php
require 'init.php';
if (user::is_logged_in()) {
    $flash = new flash();
    $flash->add_warning("Something went wrong :(");
    header("Location: index.php");
    exit();
}
$lastpage = "index.php";
if (isset($_GET['lastpage'])) {
    $lastpage = $_GET['lastpage'];
}

echo $twig->render("login.twig",["navvars"=>$navvars,"lastpage"=>$lastpage]);