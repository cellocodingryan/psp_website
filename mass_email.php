<?php
require_once 'models/flash.php';
$send_email_now = isset($_POST['content']) && isset($_POST['subject']);

require_once 'init.php';
require_once 'models/email.php';
user::auth("admin");
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
if ($send_email_now) {
    $_POST[user::get_current_user()->getid()] = true;
}

if ($send_email_now) {
    $_POST['content'] .= "<br><br><br><a href='https://percussionscholars.com/beta/mass_email.php'>Click Here to send a mass email (reply all)</a>";

}
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

    $email = new email($email_ids,$_POST['subject'],$_POST['content']);

    if (isset($_FILES['emailattachment'])) {
        if (isset($_POST['custom_name'])) {
            $_POST['name'] = $_POST['custom_name'];
        }
        require_once 'models/upload.php';
        $worked = upload::uploadftp($_FILES['emailattachment']['tmp_name'],
            "email_attach/".$_FILES['emailattachment']['name']);
        $flash = new flash();

        if (!$worked) {
            $flash->add_danger("Failed to Upload");
            header("Location: mass_email.php");
            exit();
        }

        $email->add_attachment("email_attach/".$_FILES['emailattachment']['name']);
    }



    $email->send_email();
    $flash = new flash();
    if ($email->failed_emails > 0) {
        $flash->add_danger("at least " . $email->failed_emails . " emails failed to send");
    } else {

        $flash->add_success("Sending the Email Now!");
    }

    header("Location: mass_email.php");
} else {

    echo $twig->render("mass_email.twig",["members"=>$members,"alumni"=>$alumni,"navvars" => $navvars]);
}
