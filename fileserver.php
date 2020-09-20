<?php
require_once 'models/user.php';
session_start();
require_once 'models/video_server.php';
user::auth("member");
if (explode(".",$_GET['file'])[1] == "pdf") {

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