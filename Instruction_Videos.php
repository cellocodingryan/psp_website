
<?php
require_once 'models/user.php';
session_start();
require_once 'models/flash.php';
user::auth("member");
require_once 'models/upload.php';


//practice video upload

if (user::get_current_user()->has_rank("director")) {
    if (isset($_GET['delete'])) {
        $video_name = $_GET['delete'];
        $res = mysqli_query(db::getdb(), "DELETE FROM practice_videos WHERE video_name='$video_name'");
        $flash = new flash();
        if (!$res) {
            $flash->add_danger("Was not able to delete :( ");
        } else {
            $flash->add_success($video_name." Deleted");
        }
        header("Location: Instruction_Videos.php");
        exit();
    }
}
$flash = new flash();
if (isset($_POST['video_name'])) {
    //debug
    user::auth("director");
    $name = "nameless";
    if (isset($_POST['video_name'])) {
        $name = $_POST['video_name'];
    }
    $sql = "SELECT * FROM practice_videos WHERE video_name='$name'";
    $result = db::getdb()->query($sql);
    $worked = true;
    $error_message = "";
    if (mysqli_num_rows($result) > 0) {

        if (isset($_POST['replace'])) {
            $sql = "DELETE FROM practice_videos WHERE video_name='$name'";
            $result = mysqli_query($conn,$sql);
        } else {
            $error_message = "Video name exists";
            $worked = false;
            $flash->add_danger("Video Name Already Exists");
        }
    }

    $file = $_FILES['file']['name'];
    $sql = "SELECT * FROM practice_videos WHERE file_name='$file'";
    $result = db::getdb()->query($sql);

    if (mysqli_num_rows($result) > 0) {
        if (isset($_POST['replace'])) {
            $sql = "DELETE FROM practice_videos WHERE file_name='$file'";
            $result = mysqli_query($conn,$sql);
        } else {
            $error_message = "file name exists";
            $worked = false;
            $flash->add_danger("Video Name Already Exists");
        }
    }

    $sql = "INSERT INTO practice_videos (video_name,file_name) VALUES ('$name','$file')";
    $result = mysqli_query(db::getdb(),$sql);






    if ($worked) {



        $connected = upload::uploadftp($_FILES['file']['tmp_name'],'public_html/practice_video/'.$_FILES['file']['name']);
        if (!$connected || $_FILES['file']['error'] != 0) {
            $worked = false;
            if (!$connected) {
                $error_message = "connection_error";
            } else {
                $error_message = $_FILES['file']['error'];
            }
            $flash->add_danger($error_message);
        }
    }


    if ($worked) {
        $flash->add_success("File Uploaded");
    }
    header("Location: Instruction_Videos.php");
    exit();

}

function set_priority($video_id,$order_id) {


    $conn = db::getdb();

    $result_rec = $conn->query("SELECT * FROM practice_videos WHERE order_id='$order_id'");

    if ($result_rec->num_rows >0) {
        $row_rec = $result_rec->fetch_assoc();
    }else{
        $row_rec = NULL;
    }
    $sql = "UPDATE practice_videos SET order_id='$order_id' WHERE video_id='$video_id'";
    //echo "sql: " . $sql . "ERROR" . mysqli_error($conn);
    $result = $conn->query($sql);

//    echo 'recurse? ' . $row_rec['video_id'] . '::' . $video_id;
    if ($row_rec != NULL && $row_rec['video_id'] !== $video_id) {
        //echo 'WENT IN ';
        //echo $row_rec['video_id'] . 'xx' . ($order_id+1);
        set_priority($row_rec['video_id'],$order_id+1);

    } else {
        $flash = new flash();
        $flash->add_success("Order Changed");
        header("Location: Instruction_Videos.php");
        exit();
    }
}

//order_form

if (isset($_POST['priority'])) {
    user::auth("director");
    set_priority($_POST['video_id'],$_POST['priority']);

}
require 'init.php';
$canmodify = false;
if (user::get_current_user()->has_rank("director")) {
    $canmodify = true;
}


$sql = "SELECT * FROM practice_videos ORDER BY order_id ASC";
$result = db::getdb()->query($sql);
$videos = [];
if ($result->num_rows > 0) {
    $count = 1;
    while ($row = $result->fetch_assoc()) {

        $video_name = $row['video_name'] ;
        $delete_button = "";
        $video_id = $row['video_id'];
        $order_id = $row['order_id'];
        $order_form = "";
        $videos[] = ["video_id"=>$video_id,"video_order"=>$order_id,"video_name"=>$video_name,"file_name"=>$row['file_name']];
    }
}

echo $twig->render("instructor_video.twig",["navvars"=>$navvars, "canmodify"=> $canmodify, "videos"=>$videos]);