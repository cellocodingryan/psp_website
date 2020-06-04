<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 8/8/2018
 * Time: 12:18 AM
 */
include_once 'dbh-inc.php';
function uploadFTP($server, $username, $password, $local_file, $remote_file){
    // connect to server
    $connection = ftp_connect($server);

    // login
    if (@ftp_login($connection, $username, $password)){
        // successfully connected
    }

    ftp_put($connection, $remote_file, $local_file, FTP_BINARY);
    ftp_close($connection);
    return true;
}
if (isset($_POST['assign_name'])) {

    $name = $_POST['assign_name'];
    $file = $_FILES['file']['name'];
    $sql = "INSERT INTO assignment_help (assign_name,assign_file) VALUES ('$name','$file')";
    $result = mysqli_query($conn,$sql);

    $connected = uploadFTP(getenv('serverip'),getenv('ftpusername'),getenv('ftppassword'),$_FILES['file']['tmp_name'],getenv('emailattachlocation').'/assignment_help/'.$_FILES['file']['name']);
    if (!$connected || $_FILES['file']['error'] != 0) {
        $worked = false;
        if (!$connected) {
            $error_message = "connection_error";
        } else {
            $error_message = $_FILES['file']['error'];
        }
    }
    header("Location: ../assignment_help.php");
    exit();
}
