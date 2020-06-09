<?php
require_once 'vendor/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader, [
    'cache' => 'cache',
]);

echo $twig->render('home.twig');