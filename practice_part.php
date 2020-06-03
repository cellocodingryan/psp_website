<!doctype html>
<html lang="en" style="width: auto !important;">
<!--width auto to tmp fix the table from bleeding outside of the html tag-->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="contact_table/style.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">


    <link rel="stylesheet" type="text/css" href="css/extra_large.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:1199.99px)" href="css/large.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:991.99px)" href="css/medium.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:767.99px)" href="css/small.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:575.99px)" href="css/extra_small.css">

    <title>Hello, world!</title>
</head>
<body>
<?php
$restricted = 1;
$user_location = "practice_part";
include_once 'includes/dbh-inc.php';
include_once 'nav.php';
include_once 'includes/functions.php'
?>
<style>
    h1 {height 4%;}
    input {height: 2%;}
    html, body {
        height: 100%;
    }
    iframe {height: 70%;width: 100%;}
</style>
<h1>Parts</h1>


<?php
if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_name=$_POST['part_name'];
    $date = date_create($file_name);

    @$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    $is_new = false;
    $expensions= array("pdf");

    if(in_array($file_ext,$expensions)=== false){
        $errors[]="extension not allowed, please choose a PDF";
    }

    if($file_size > 2097152 && false){
        $errors[]='File size must be excately 2 MB';
    }

//    sql for date here



    if(empty($errors)==true){

        $sql = "SELECT * FROM practice_part WHERE practice_part_date='$file_name'";
        $result = $conn->query($sql);
        if ($result->num_rows <= 0) {
            $is_new = true;
            $sql = "INSERT INTO practice_part (practice_part_date) VALUES ('$file_name')";
            mysqli_query($conn,$sql);
        }

        move_uploaded_file($file_tmp,"practice_parts/".$file_name.'.'.$file_ext);

        if ($is_new) {
            echo '<script>alert("practice_part Published");</script>';
        } else {
            echo '<script>alert("practice_part Updated");</script>';
        }
    }else{
        echo print_r($errors);
    }
}
$practice_part_date = "x";
if (isset($_GET['practice_part'])) {
    if ($is_new) {
        echo '<script>alert("practice_part Published");window.location.href = \'practice_part.php\';</script>';
    } else {
        echo '<script>alert("practice_part Published");window.location.href = \'practice_part.php\';</script>';
    }
}
$id = "";
$name = "";
if (isset($_GET['part'])) {
    $date = $_GET['part'];
    //verify
    $sql = "SELECT * FROM practice_part WHERE practice_part_date='$date'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row['practice_part_id'];
    $name = $row['practice_part_date'];
    if ($result->num_rows > 0) {
        $practice_part_date = $date;
    } else {
        header("Location practice_part.php");
    }
} else {
    $sql = "SELECT * FROM practice_part ORDER BY practice_part_date DESC";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row['practice_part_id'];
    $name = $row['practice_part_date'];
    if ($result->num_rows > 0) {
        $practice_part_date = ($row['practice_part_date']);
    }
}

if ($practice_part_date != "x") {

    echo '<iframe src="practice_parts/' . $practice_part_date . '.pdf#toolbar=0" frameborder="0"></iframe>';

}
?>




<?php
$sql = "SELECT * FROM practice_part ORDER BY practice_part_date";
$result = $conn->query($sql);
echo '<form id="part_select"><label>Select the name of practice_part you are looking for</label><select onchange="go_to_date(this)">';
$first = true;
while ($row = $result->fetch_assoc()) {
    if ($row['practice_part_date'] == $practice_part_date) {
        echo '<option value="' . $row['practice_part_date'] . '" selected > ' . $row['practice_part_date'] . '</option>';
    } else {
        echo '<option value="' . $row['practice_part_date'] . '" > ' . $row['practice_part_date'] . '</option>';
    }
}


echo '</select>';
if ($_SESSION['u_rank'] > 1) {

    $delete_button = '<a href="#" style="color: red;" onclick="delete_(\'practice_part\',' .$id. ')">[DELETE]</a>';
    echo $delete_button;
}
$download = '<a style="color: green;" onclick="download_stat(\''. $name .'\', ' . $_SESSION['u_id'] .')" download href="practice_parts/' .$name. '.pdf">[DOWNLOAD]</a>';
echo $download.'</form>';
echo '<h1>' . $row['practice_part_date'] . '</h1>';
if ($_SESSION['u_rank'] > 1) {
    echo '<h6>Upload New Part</h6>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" required name="part_name"><br>
    <input type="file" required name="image"><br>
    <input type="submit">
</form>';
}
?>

<script>
    function download_stat(part_name,id) {
        $.ajax({
            method: "POST",
            url: "includes/add_stat_downloadfile-inc.php",
            data: {part_name: part_name, id: id}
        })
    }
    function go_to_date(part) {

        window.location.href = "practice_part.php?part=" + ($("#part_select option:nth-of-type(" + (part.selectedIndex+1) + ")").val());
    }
</script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/jquery.tablesorter.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>