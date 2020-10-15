<?php
require_once 'models/user.php';
session_start();
require_once 'models/video_server.php';
if (!user::is_logged_in()) {
    $flash = new flash();
    $flash->add_info("After you login, click on the email link again");
}
user::auth("member");
if (strtolower(explode(".",$_GET['file'])[1]) != "mp4" && strtolower(explode(".",$_GET['file'])[1]) != "mov") {

// We'll be outputting a PDF
    header('Content-type: application/pdf');

// It will be called downloaded.pdf
    if (isset($_GET['download'])) {
        header('Content-Disposition: attachment; filename="'.$_GET['file'].'"');
    }

    readfile(getenv("filelocation_prefix")."{$_GET['folder']}/{$_GET['file']}");

    exit();
}
$v = new video_server("{$_GET['folder']}/{$_GET['file']}");
$v->start();