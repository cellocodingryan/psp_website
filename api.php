<?php
require_once "models/user.php";
session_start();
require_once 'includes/dbh-inc.php';
class response {
    public function __construct($status,$message)
    {
        $this->message = $message;
        $this->status = $status;
    }
    public function __toString()
    {
        return json_encode(["status"=>$this->status,"message"=>$this->message]);
    }

    private $status;
    private $message;
}
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
            if (isset($_POST['phones']) && isset($_POST['phonenum'])) {
                $user->set_phones($_POST['phones'],$_POST['phonenum']);
            } else if (isset($_POST['phones'])) {
                echo (new response(400,"invalid"));
                exit();
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
        default:
    }
}