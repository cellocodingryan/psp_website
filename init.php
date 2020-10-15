<?php
require_once 'vendor/autoload.php';
require_once 'models/db.php';
require_once 'models/user.php';
require_once 'models/flash.php';
if (!isset($_SESSION)) {
    session_start();
}

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader, [
    'debug' => true,
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
    } else if (isset($_POST['username']) && isset($_POST['resetpasswordrequest'])) {
        $user = user::get_by_uid($_POST['username']);
        if (!$user) {
            $flash->add_danger("username does not exist");
            $lastpage = basename($_SERVER["SCRIPT_FILENAME"], '.php').".php";
            header("Location: resetpassword.php");
            exit();
        }
        $code = $user->reset_password_code();
        require_once 'models/email.php';
        $id = $user->getid();

        $_SESSION['username_for_password_reset'] = $_POST['username'];
        $url = getenv("url");
        $email = "Here is your password reest code that you requested. <br><a href='$url/resetpassword.php?code=$code&code_sent'> Click here </a><br><br>Code: $code";
        $email = new email([$user],"Your password code",$email);
        $email->send_email();
        $flash->add_success("Check your email for code");
        $lastpage = basename($_SERVER["SCRIPT_FILENAME"], '.php').".php";
        header("Location: resetpassword.php?code_sent");

        exit();
    }
}


require_once 'nav.php';
