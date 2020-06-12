<?php
require_once 'init.php';
$test = ["videos"=>["https://www.youtube.com/embed/32W2IBkVqUk","https://www.youtube.com/embed/zmNo0dowYEU","https://www.youtube.com/embed/9LI8iwnfys8","https://www.youtube.com/embed/cqZhxZp66ZQ","https://www.youtube.com/embed/DfSgsrzdq2M","https://www.youtube.com/embed/x6lrD27AjBs"]];
echo $twig->render('performances.twig',$test);