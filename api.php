<?php
require_once "models/user.php";
session_start();
require_once 'includes/dbh-inc.php';
require_once 'models/response.php';
if (isset($_GET['method'])) {
    switch ($_GET['method']) {
        case "edit_profile":
            if (!user::is_logged_in()) {
                echo (new response(403,"Not logged in"));
                exit();
            }
            if (!isset($_POST['id'])) {
                echo (new response(400,"invalid"));
                exit();
            }
            if ($_POST['id'] != user::get_current_user()->getid()) {
                if (!user::get_current_user()->has_rank("director")) {
                    echo (new response(403, "Not Authorized"));
                    exit();
                }
            }
            $user = user::get_by_id($_POST['id']);
            if (isset($_POST['firstname'])) {
                $user->set_firstname($_POST['firstname']);
            }
            if (isset($_POST['lastname'])) {
                $user->set_lastname($_POST['lastname']);
            }
            if (isset($_POST['email'])) {
                $user->set_primary_email($_POST['email']);
            }
            if (isset($_POST['emails']) && isset($_POST['emailnum'])) {
                $user->set_emails($_POST['emails'],$_POST['emailnum']);
            } else if (isset($_POST['emails'])) {
                echo (new response(400,"invalid"));
                exit();
            }
            if (isset($_POST['phoneid'])) {
                if (!isset($_POST['type'])) {
                    echo (new response(400,"invalid"));
                    exit();
                }
                $user->set_phones($_POST['phones'],$_POST['type'],$_POST['phoneid']);

            }
            
            echo (new response(200, "Success"));
            
            break;
        case "change_password":
            if (!isset($_POST['id']) || !isset($_POST['password']) || !isset($_POST['password_confirm'])) {
                echo (new response(400,"invalid"));
            }
            $user = user::get_by_id($_POST['id']);
            if (!user::get_current_user()->has_rank("director") || $user->getid() == user::get_current_user()->getid()) {


                if (!isset($_POST['password_old'])) {
                    echo (new response(400,"invalid"));
                    exit();
                }
                if (!$user->check_password($_POST['password_old'])) {
                    echo (new response(400,"invalid"));
                    exit();
                }
            }
            if ($_POST['password'] == "") {
                echo (new response(400,"invalid"));
                exit();
            }
            if ($user->change_password($_POST['password'],$_POST['password_confirm'])) {

                echo (new response(200, "Success"));
            }
            echo (new response(400,"invalid"));

            break;
        case "change_permissions":
            $flash = new flash();
            if (!user::get_current_user()->has_rank("director")) {
                $flash->add_danger("Invalid Permissions");
                die(new response(401,"invalid (please refresh)"));
            }
            if (!isset($_POST['id'])) {
                echo (new response(200,"invalid"));
            }
            if ($_POST['id'] == user::get_current_user()->getid()) {
                $flash->add_danger("Invalid Permissions");
                $id = $_POST['id'];
                die(new response(401,"invalid (please refresh)"));
            }
            $user = user::get_by_id($_POST['id']);
            if (isset($_POST['admin']) && $_POST['admin']=="true") {
                $user->set_rank("admin");
            } else if (isset($_POST['director']) && $_POST['director']=="true") {
                $user->set_rank("director");
            } else if (isset($_POST['alumni']) && $_POST['alumni']=="true") {
                $user->set_rank("alumni");
            } else if (isset($_POST['member'])&& $_POST['member']=="true") {
                $user->set_rank("member");
            } else {
                $user->set_rank("");
            }
            echo (new response(200, "Success"));
            break;
        default:
    }
}