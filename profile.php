<?php
require 'init.php';

user::auth();

echo $twig->render("profile.twig",[
    "navvars"=>$navvars,
    "userid"=>user::get_current_user()->getid(),
    "firstname"=>user::get_current_user()->get_firstname(),
    "lastname"=>user::get_current_user()->get_lastname(),
    "username"=>user::get_current_user()->get_username(),
    "email"=>user::get_current_user()->get_email(),
    "additional_emails"=>user::get_current_user()->get_all_emails(),
    "additional_phones"=>user::get_current_user()->get_all_phones()
]);