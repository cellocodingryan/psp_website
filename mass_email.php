<?php
require_once 'models/flash.php';
$send_email_now = isset($_POST['content']) && isset($_POST['subject']);

require_once 'init.php';
require_once 'models/email.php';
session_start();
user::auth("member");

$users = mysqli_query(db::getdb(),"SELECT * FROM users");

$user_ids = [];
$members = array();
$alumni = array();
if (!$users) {
    echo mysqli_error(db::getdb());
    die();
}
$email_ids = array();
foreach ($users as $i) {
    $current_user = user::get_by_prequery($i);
    if (!$current_user) {
        continue;
    }
    if (isset($_POST[$current_user->getid()])) {
        $email_ids[] = $current_user;
    }
    $next = ["id"=>$current_user->getid(),"name"=>$current_user->get_firstname() ." ".$current_user->get_lastname()];

    if ($current_user->has_rank("alumni") and !$current_user->has_rank("director")) {
        $alumni[] = $next;
    } else if ($current_user->has_rank("member")) {
        $members[] = $next;
    }

}
if ($send_email_now) {
    $flash = new flash();
    $flash->add_success("Sending the Email Now!");
    header("Location: mass_email.php");
} else {

    echo $twig->render("mass_email.twig",["members"=>$members,"alumni"=>$alumni,"navvars" => $navvars]);
}
if ($send_email_now) {

    $email = new email($email_ids,$_POST['subject'],$_POST['content']);
    $email->send_email();
}