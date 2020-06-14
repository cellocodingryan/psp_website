<?php
require 'init.php';

echo $twig->render("login.twig",["current"=>"login"]);