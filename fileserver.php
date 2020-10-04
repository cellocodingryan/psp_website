<?php
require_once 'models/user.php';
session_start();
require_once 'models/video_server.php';
$redirect_link = "viewemailattach.php";
if (isset($_GET['file'])) {
    $_SESSION['file'] = $_GET['file'];
}
if (isset($_GET['folder'])) {
    $_SESSION['folder'] = $_GET['folder'];
}

if (isset($_GET['download'])) {
    $redirect_link=$redirect_link."&download";
    $_SESSION['download'] = 1;
}


user::auth("member",$redirect_link);



if (strtolower(explode(".",$_GET['file'])[1]) != "mp4" && strtolower(explode(".",$_GET['file'])[1]) != "mov") {

// We'll be outputting a PDF
    error_log('Content-type: '.filetype(getenv("filelocation_prefix")."{$_GET['folder']}/{$_GET['file']}"));
    header('Content-type: '.filetype(getenv("filelocation_prefix")."{$_GET['folder']}/{$_GET['file']}"));

// It will be called downloaded.pdf
    if (isset($_GET['download']) || isset($_SESSION['download'])) {
        header('Content-Disposition: attachment; filename="'.$_GET['file'].'"');
    }
    
    if (isset($_SESSION['download'])) {
        unset($_SESSION['download']);
    }
    
    readfile(getenv("filelocation_prefix")."{$_GET['folder']}/{$_GET['file']}");


} else {

    $v = new video_server("{$_GET['folder']}/{$_GET['file']}");
    $v->start();
}