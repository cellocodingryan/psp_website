<?php
require 'init.php';

$lastpage = "index.php";
if (isset($_GET['lastpage'])) {
    $lastpage = $_GET['lastpage'];
}
echo $twig->render("login.twig",["navvars"=>$navvars,"lastpage"=>$lastpage]);