<?php

require 'init.php';
require_once 'models/db.php';
require_once 'models/email.php';
user::auth("director");
if (isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname'])) {
    $password = md5(rand());
    $username = explode("@",$_POST['email'])[0];
    error_log("username".$username);
    $count_try = 1;
    while (!user::create_account($username,$_POST['email'],$_POST['firstname'],$_POST['lastname'],$password,$password) && $count_try < 10) {
        $username.=$count_try;
    }
    $user = user::get_by_uid($_POST['email']);
    $flash = new flash();
    if (!$user) {
        $flash->add_danger("Something went wrong");
        header("Location: generate_account.php");
        exit();
    }
    if (isset($_POST["member"])) {
        $user->set_rank("member");
    }

     if (isset($_POST['alumni'])) {
        $user->set_rank("alumni");

    }
    if (isset($_POST['director'])) {
        $user->set_rank("director");

    }
    $flash->add_success("Account Created");
    $subject = "New PSP account created on your behalf";
    $name = $_POST['firstname'];
    $current_user = user::get_current_user();
    $current_user_name = $current_user->get_firstname()." ".$current_user->get_lastname();
    $content = "Hello $name,<br><br>A new account was just created on your behalf by $current_user_name. You can view it by going to percussionscholars.com. Your username and password are included on this email.<br><br>Username: $username<br>Password: $password<br><br>Sincerely,<br><br>The Percussion Website Bot";
    $email = new email([$user,$current_user],$subject,$content);
    $email->send_email();


    if (count($email->failed_emails) > 0) {
        $flash->add_danger("Email Failed To Send");
    }
    header("Location: generate_account.php");
    exit();

}
echo $twig->render("create_account.twig", ["navvars" => $navvars,"lastpage"=>" ","generating"=>true]);