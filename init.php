<?php
require_once 'vendor/autoload.php';
require_once 'includes/dbh-inc.php';
require_once 'models/user.php';
require_once 'models/flash.php';
session_start();

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader, [
]);
if (isset($_POST)) {
    //login
    $flash = new flash();
    if (isset($_POST['username']) && isset($_POST['password'])) {

        if (isset($_POST['email']) && isset($_POST['firstname']) &&
            isset($_POST['lastname']) && isset($_POST['password']) &&
            isset($_POST['confirm_password']) ) {

            if (!user::create_account(
                $_POST['username'],
                $_POST['email'],
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['password'],
                $_POST['confirm_password']
            )) {
                $flash->add_danger(user::geterr());
                $lastpage = basename($_SERVER["SCRIPT_FILENAME"], '.php').".php";
                header("Location: create_account.php?lastpage=$lastpage");
                exit();
            } else {
                $flash->add_success("Account Created ");
                $lastpage = basename($_SERVER["SCRIPT_FILENAME"], '.php').".php";
                header("Location: $lastpage");
                exit();
            }

        }

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
