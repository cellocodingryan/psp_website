<?php
require_once 'models/upload.php';
require_once 'models/user.php';
require_once 'models/flash.php';
if (isset($_POST['image']) && isset($_POST['name'])) {
    user::auth("director");
    upload::uploadftp($_FILES['image']['tmp_name'],"public_html/practice_parts/".$_POST['name']);
    $flash = new flash();
    $flash->add_success("File uploaded");
    $file_name= $_POST['name'];
    $sql = "INSERT INTO practice_part (practice_part_date) VALUES ('$file_name')";
    mysqli_query(db::getdb(),$sql);
    header("Location: practice_part.php?part_name=".$_POST['name']);
    exit();
}
if (isset($_GET['delete'])) {
    user::auth("director");
    $file_name= $_POST['name'];
    $flash = new flash();
    if (mysqli_query(db::getdb(),"DELETE FROM practice_part WHERE practice_part_date = '$file_name'")) {
        $flash->add_success("Gone");
    } else {
        $flash->add_danger("Something went wrong");
    }
    header("Location: practice_part.php");
    exit();


}
require_once 'init.php';

user::auth("member");
$sql = "SELECT * FROM practice_part ORDER BY practice_part_date";

$result = db::getdb()->query($sql);



$options = [];
if (isset($_GET['part_name'])) {
    $part_name = $_GET['part_name'];
    $sql = "SELECT * FROM practice_part WHERE practice_part_date='{$part_name}'";
    $result2 = db::getdb()->query($sql);
    $options[] = $result2->fetch_assoc()["practice_part_date"];
}
foreach ($result as $i) {
    $options[] = $i["practice_part_date"];
}
echo $twig->render("pdfviewer.twig",['navvars'=>$navvars,"title"=>"Practice Parts","canedit"=>user::get_current_user()->has_rank('director'),"folder"=>"practice_parts","options"=>$options,"file"=>"practice_part.php"]);