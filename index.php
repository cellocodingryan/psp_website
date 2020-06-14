<?php
require_once 'init.php';

echo $twig->render('home.twig',["current"=>"index"]);