<?php
require 'init.php';
require_once 'models/flash.php';
user::auth();
$user = user::get_current_user();
$modify_rank = false;
$flash = new flash();
if (isset($_GET['id'])) {
    $user = user::get_by_id($_GET['id']);
    if (user::get_current_user()->getid() != $user->getid()) {


        user::auth("director");
        if (!$user) {

            $flash->add_danger("Invalid ID");
            header("Location: modify_users.php");
        }
        $modify_rank=true;
    }
}
if (isset($_FILES['profilepic'])) {
    $username = $user->get_username();
    $id = $user->getid();
    $extension = pathinfo($_FILES['profilepic']['name'], PATHINFO_EXTENSION);
    $size = filesize($_FILES['profilepic']['tmp_name']);
    if (!file_exists($_FILES['profilepic']['tmp_name'])) {
        if (file_exists(getenv("filelocation_prefix")."profile_pics/$username")) {
            $flash->add_warning("Removed");
            unlink(getenv("filelocation_prefix")."profile_pics/$username");
        } else {
            $flash->add_warning("Nothing to remove");
        }
        header("Location: profile.php?id=$id");
        exit();
    }
    if ($size > 15000000) {
        $flash->add_info("File is too big");
    } else {
        require_once "models/upload.php";
        $worked = upload::uploadftp($_FILES['profilepic']['tmp_name'],"profile_pics/$username");

        if ($worked) {
            $flash->add_success("Uploaded");
        } else {
            $flash->add_danger("Failed to upload");
        }

    }
    header("Location: profile.php?id=$id");
    exit();

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
    "address"=>$user->get_address()

]);