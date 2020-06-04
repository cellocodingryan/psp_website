<?php

include_once 'dbh-inc.php';
//check permissions
session_start();
if (!isset($_SESSION['u_rank'])) {
    header("Location ../index.php");
    exit();
} else if ($_SESSION['u_rank'] < 2) {
    header("Location ../index.php");
    exit();
}
function uploadFTP($server, $username, $password, $local_file, $remote_file){
    // connect to server
    $connection = ftp_connect($server);

    // login
    if (@ftp_login($connection, $username, $password)){
        // successfully connected
    }else{
        return false;
    }

    ftp_put($connection, $remote_file, $local_file, FTP_BINARY);

    ftp_close($connection);
    return true;
}

//practice video upload

if (isset($_POST['video_name'])) {
    //debug

    $name = "nameless";
    if (isset($_POST['video_name'])) {
        $name = $_POST['video_name'];
    }
    $sql = "SELECT * FROM practice_videos WHERE video_name='$name'";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0) {

        if (isset($_POST['replace'])) {
            $sql = "DELETE FROM practice_videos WHERE video_name='$name'";
            $result = mysqli_query($conn,$sql);
        } else {
//            header("Location: ../Instruction_Videos.php?error=name_exists");
            exit();
        }
    }

    $file = $_FILES['file']['name'];
    $sql = "SELECT * FROM practice_videos WHERE file_name='$file'";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0) {
        if (isset($_POST['replace'])) {
            $sql = "DELETE FROM practice_videos WHERE file_name='$file'";
            $result = mysqli_query($conn,$sql);
        } else {
//            header("Location: ../Instruction_Videos.php?error=file_name_exists");
            exit();
        }
    }

    $sql = "INSERT INTO practice_videos (video_name,file_name) VALUES ('$name','$file')";
    mysqli_query($conn,$sql);






    $worked = true;
    $error_message = "";
    $connected = uploadFTP(getenv('serverip'),getenv('ftpusername'),getenv('ftppassword'),$_FILES['file']['tmp_name'],getenv('emailattachlocation').'/practice_video/'.$_FILES['file']['name']);
    if (!$connected || $_FILES['file']['error'] != 0) {
        $worked = false;
        if (!$connected) {
            $error_message = "connection_error";
        } else {
            $error_message = $_FILES['file']['error'];
        }
    }

    if ($worked) {
//        header("Location: ../Instruction_Videos.php?error=success");
        exit();
    } else {
//        header("Location: ../Instrution_videos.php?error=unknown");
    }


}
