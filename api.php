<?php
require_once "models/user.php";
session_start();
require_once 'models/db.php';

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
            if ($_POST['id'] != user::get_current_user()->getid() && $_POST['id'] > -1) {
                if (!user::get_current_user()->has_rank("director")) {
                    echo (new response(403, "Not Authorized"));
                    exit();
                }
            }

            $response = new response(200, "Success");
            $user = null;
            if ($_POST['id'] == -1) {
                $user = user::get_current_user();
            } else {
                $user = user::get_by_id($_POST['id']);
            }
            if (isset($_POST['firstname'])) {
                $user->set_firstname($_POST['firstname']);
                $response->add_attr("new_val",$user->get_firstname());
            }
            if (isset($_POST['lastname'])) {
                $user->set_lastname($_POST['lastname']);
                $response->add_attr("new_val",$user->get_lastname());

            }
            if (isset($_POST['email'])) {
                $user->set_primary_email($_POST['email']);
                $response->add_attr("new_val",$user->get_email());
            }
            if (isset($_POST['emails'])) {
                if (!isset($_POST['which_element'])) {
                    echo (new response(400,"invalid"));
                    exit();
                }
                $emailnum = $user->set_emails($_POST['emails'],$_POST['which_element']);
                $emails = $user->get_all_emails();
                $response->add_attr("which_element",$emailnum);
                if ($emailnum > -1) {
                    $response->add_attr("new_val",$emails[$emailnum]);
                }
            }
            if (isset($_POST['phones_name']) || isset($_POST['phones_number'])) {
                if (!isset($_POST['which_element'])) {
                    echo (new response(400,"invalid"));
                    exit();
                }
                $type = 0;
                $value = "";
                if (isset($_POST['phones_number'])) {
                    $type = 1;
                    $value = $_POST['phones_number'];
                } else {
                    $value = $_POST['phones_name'];
                }
                $phonenum = $user->set_phones($value,$type,$_POST['which_element']);
                $phones = $user->get_all_phones();
                $response->add_attr("which_element",$phonenum);
                if ($phonenum > -1) {
                    $response->add_attr("new_val",$phones[$phonenum][$type]);
                }
            }
            if (isset($_POST['address_line_1'])) {
                $user->set_address($_POST['address_line_1'],"address_line_1");
                $res = $user->get_address()["address_line_1"];
                $response->add_attr("new_val",$res);
            }
            if (isset($_POST['city'])) {
                $user->set_address($_POST['city'],"city");
                $res = $user->get_address()["city"];
                $response->add_attr("new_val",$res);
            }
            if (isset($_POST['state'])) {
                $user->set_address($_POST['state'],"state");
                $res = $user->get_address()["state"];
                $response->add_attr("new_val",$res);
            }
            if (isset($_POST['zipcode'])) {
                $user->set_address($_POST['zipcode'],"zipcode");
                $res = $user->get_address()["zipcode"];
                $response->add_attr("new_val",$res);
            }
            
            if (isset($_POST['address_line_2'])) {
                $user->set_address($_POST['address_line_2'],"address_line_2");
                $res = $user->get_address()["address_line_2"];
                $response->add_attr("new_val",$res);
            }
            
            
            echo $response;
            
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
                die (new response(400,"invalid"));
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
        case "add_stat":
            require_once 'models/stats.php';
            if (!user::is_logged_in()) {
                die (new response(400,"invalid"));
            }
            if (!isset($_POST['stat'])) {
                die (new response(400,"invalid"));
            }
            stats::add_stat($_POST['stat'],user::get_current_user()->getid());

        default:
    }
}