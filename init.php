<?php
require_once 'vendor/autoload.php';
require_once 'includes/dbh-inc.php';
require_once 'models/user.php';
require_once 'models/flash.php';
session_start();


if (isset($_POST)) {
    //login
    $flash = new flash();
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $user = user::login($_POST['username'],$_POST['password']);
        if (!$user) {
            sleep(2);
            $flash->add_danger("Incorrect username or password");
            $lastpage = basename($_SERVER["SCRIPT_FILENAME"], '.php').".php";
            header("Location: login.php?lastpage=$lastpage");
            exit();
        }
        $flash->add_success("Welcome " . user::get_current_user()->get_firstname());
        $lastpage = basename($_SERVER["SCRIPT_FILENAME"], '.php').".php";
        header("Location: $lastpage");
        exit();
    }
}


require_once 'nav.php';
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader, [
]);