<?php
require_once 'init.php';


$events = mysqli_query(db::getdb(),"SELECT * FROM ")


echo $twig->render('events.twig',["navvars"=>$navvars]);