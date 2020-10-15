<?php
require 'init.php';
if (user::is_logged_in()) {
    $flash = new flash();
    $flash->add_primary("Welcome!");
    header("Location: index.php");
    exit();
}
$code = "";

if (isset($_POST['code']) && isset($_POST['username']) && isset($_POST['password_r']) && isset($_POST['confirm_password'])) {
    $flash = new flash();
    $user = user::get_by_uid($_POST['username']);
    if (!$user) {
        $flash->add_warning("Invalid username");
        header("Location: resetpassword.php");
        exit();
    }
    if ($_POST['password_r']!=$_POST['confirm_password']) {
        $flash->add_warning("Passwords do not match");
        $code = $_POST['code'];
        header("Location: resetpassword.php?code=$code&code_sent");
        exit();
    }
    if ($user->verify_password_reset_code($_POST['code'])) {
        if (!$user->change_password($_POST['password_r'],$_POST['confirm_password'])) {
            $flash->add_warning("Something went wrong");
            header("Location: resetpassword.php");
            exit();
        } else {
            $_SESSION['username_for_password_reset'] = "";
            $flash->add_success("Password reset");
        }
    } else {
        $flash->add_danger("Invalid Code");
        header("Location: resetpassword.php?code=$code&code_sent");
        exit();
    }
    header("Location: login.php");
    exit();

} else if (isset($_GET['code'])) {
    $code = $_GET['code'];
}
$code_sent = false;
if (isset($_GET['code_sent'])) {
    $code_sent = true;
}


$username = "";
if (isset($_SESSION['username_for_password_reset'])) {
    $username = $_SESSION['username_for_password_reset'];
}
echo $twig->render("resetpassword.twig",["navvars"=>$navvars,"code_sent"=>$code_sent==true?"true":"false","code"=>$code,"username"=>$username]);