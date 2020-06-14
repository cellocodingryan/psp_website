<?php
require_once 'vendor/autoload.php';

session_start();
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader, [
]);