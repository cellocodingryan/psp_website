<?php
require_once 'models/upload.php';
require_once 'models/user.php';
session_start();
require_once 'models/flash.php';

if (isset($_FILES['image']) && (isset($_POST['name']) || isset($_POST['custom_name']))) {
    user::auth("director");
    if (isset($_POST['custom_name'])) {
        $_POST['name'] = $_POST['custom_name'];
    }
    $worked = upload::uploadftp($_FILES['image']['tmp_name'],"schedules/".$_POST['custom_name'] ." ". $_POST['date'] .".". explode(".",$_FILES['image']['name'])[1]);
    $flash = new flash();

    if (!$worked) {
        $flash->add_danger("Failed to Upload");
        header("Location: schedule.php");
        exit();
    }

    $file_name= $_POST['custom_name'] ." ". $_POST['date'];
    $sql = "INSERT INTO schedule (Schedule_date) VALUES ('$file_name')";
    $res = mysqli_query(db::getdb(),$sql);

    $flash->add_success("File uploaded");
    if (!$res) {
        if (!$worked) {
            $flash->add_danger("Failed to Upload (db error)");
            header("Location: schedule.php");
            exit();
        }
    }
    header("Location: schedule.php?part_name=".$_POST['name']);
    exit();
}
if (isset($_GET['delete'])) {
    user::auth("director");
    $file_name= $_GET['name'];
    $flash = new flash();
    if (mysqli_query(db::getdb(),"DELETE FROM schedule WHERE Schedule_date = '$file_name'")) {
        $flash->add_success("Gone");
    } else {
        $flash->add_danger("Something went wrong");
    }
    header("Location: schedule.php");
    exit();


}
require_once 'init.php';

user::auth("member");
$sql = "SELECT * FROM schedule ORDER BY Schedule_date";

$result = db::getdb()->query($sql);



$options = [];
$file_to_skip = "";
if (isset($_GET['part_name'])) {
    $part_name = $_GET['part_name'];
    $sql = "SELECT * FROM schedule WHERE Schedule_date='{$part_name}'";
    $result2 = db::getdb()->query($sql);
    if (mysqli_num_rows($result2) == 1) {
        $result2= $result2->fetch_assoc();
        $options[] = $result2["Schedule_date"];
        $file_to_skip = $result2["Schedule_date"];
    }
}
foreach ($result as $i) {
    if ($i["Schedule_date"] == $file_to_skip) {
        continue;
    }
    $options[] = $i["Schedule_date"];
}
echo $twig->render("pdfviewer.twig",['navvars'=>$navvars,"title"=>"Schedule","canedit"=>user::get_current_user()->has_rank('director'),"folder"=>"schedules","options"=>$options,"file"=>"schedule.php"]);