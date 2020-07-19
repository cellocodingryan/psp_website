<?php
require_once 'models/upload.php';
require_once 'models/user.php';
require_once 'models/flash.php';
if (isset($_POST['image']) && (isset($_POST['name']) || isset($_POST['custom_name']))) {
    user::auth("director");
    if (isset($_POST['custom_name'])) {
        $_POST['name'] = $_POST['custom_name'];
    }
    upload::uploadftp($_FILES['image']['tmp_name'],"public_html/schedules/".$_POST['name']);
    $flash = new flash();
    $flash->add_success("File uploaded");
    $file_name= $_POST['name'];
    $sql = "INSERT INTO practice_part (practice_part_date) VALUES ('$file_name')";
    mysqli_query(db::getdb(),$sql);
    header("Location: schedule.php?part_name=".$_POST['name']);
    exit();
}
if (isset($_GET['delete'])) {
    user::auth("director");
    $file_name= $_POST['name'];
    $flash = new flash();
    if (mysqli_query(db::getdb(),"DELETE FROM schedule WHERE Schedule_date = '$file_name'")) {
        $flash->add_success("Gone");
    } else {
        $flash->add_danger("Something went wrong");
    }
    header("Location: practice_part.php");
    exit();


}
require_once 'init.php';

user::auth("member");
$sql = "SELECT * FROM schedule ORDER BY Schedule_date";

$result = db::getdb()->query($sql);



$options = [];
if (isset($_GET['part_name'])) {
    $part_name = explode("---",$_GET['part_name'])[0];
    $sql = "SELECT * FROM schedule WHERE Schedule_date='{$part_name}'";
    $result2 = db::getdb()->query($sql)->fetch_assoc();
    $options[] = $result2["Schedule_date"]."---".$result2["Schedule_id"];
}
foreach ($result as $i) {
    $options[] = $i["Schedule_date"]."---".$i["Schedule_id"];
}
echo $twig->render("pdfviewer.twig",['navvars'=>$navvars,"title"=>"Schedule","canedit"=>user::get_current_user()->has_rank('director'),"folder"=>"schedules","options"=>$options,"file"=>"schedule.php"]);