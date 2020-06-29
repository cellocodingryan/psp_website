<?php
require 'init.php';
require_once 'models/flash.php';
user::auth();
$user = user::get_current_user();
$modify_rank = false;
if (isset($_GET['id'])) {
    user::auth("director");
    $user = user::get_by_id($_GET['id']);
    if (!$user) {
        $flash = new flash();
        $flash->add_danger("Invalid ID");
        header("Location: modify_users.php");
    }
    $modify_rank=true;
}
echo $twig->render("profile.twig",[
    "navvars"=>$navvars,
    "userid"=>$user->getid(),
    "firstname"=>$user->get_firstname(),
    "lastname"=>$user->get_lastname(),
    "username"=>$user->get_username(),
    "email"=>$user->get_email(),
    "additional_emails"=>$user->get_all_emails(),
    "additional_phones"=>$user->get_all_phones(),
    "can_change_perms"=>$modify_rank,
    "admin"=>$user->has_rank("admin"),
    "member"=>$user->has_rank("member"),
    "alumni"=>$user->has_rank("alumni"),
    "director"=>$user->has_rank("director"),

]);