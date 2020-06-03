<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 7/20/2018
 * Time: 12:31 AM
 */
//this file is used for more than just practice videos, used for that as well as schedules, practice parts
session_start();
include_once 'dbh-inc.php';
//check permissions;
$kick_out = false;
if (!isset($_SESSION['u_rank'])) {
    $kick_out = true;
} else if ($_SESSION['u_rank'] < 2) {
    $kick_out = true;
}
if ($kick_out) {
    header("Location ../index.php");
    exit();
}

if ($_POST['type'] == "video") {
    $video_name = $_POST['video_name'];
    mysqli_query($conn, "DELETE FROM practice_videos WHERE video_name='$video_name'");
} else if ($_POST['type'] == 'schedule')  {
    $id = $_POST['video_name'];
    mysqli_query($conn, "DELETE FROM schedule WHERE Schedule_id='$id'");

} else {
    $id = $_POST['video_name'];
    mysqli_query($conn, "DELETE FROM practice_part WHERE practice_part_id='$id'");
}
