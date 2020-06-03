<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

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
$user_location = "assignment_help";
include_once 'nav.php';
include_once 'includes/functions.php';
include_once 'includes/dbh-inc.php';


$sql = "";
$assign_name = "";
if (isset($_GET['part'])) {
    $assign_name = $_GET['part'];

    $sql = "SELECT * FROM assignment_help WHERE assign_name='$assign_name'";
} else {
    $sql = "SELECT * FROM assignment_help ORDER BY assign_id DESC";

}
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo '<h3 style="color: red;font-weight: bolder"> Nothing here yet check back later</h3>';
}
else {
    $row = $result->fetch_assoc();
    $file_name = $row['assign_file'];
    $assign_name = $row['assign_name'];
    echo '<h4>' .$assign_name. '</h4>';
    echo '<video onplay="help_stat(0,\''.$assign_name.'\','.$_SESSION['u_id'].')" onpause="help_stat(1,\''.$assign_name.'\','.$_SESSION['u_id'].')"  controlsList="nodownload" src="assignment_help/' . $file_name . '" width="100%" controls></video>';

    echo '<form id="part_select"><label>Select the name of assignment help video you are looking for</label><select onchange="go_to_help(this)">';
    $first = true;
    $assign_id = $row['assign_id'];
//selection system
    $sql = "SELECT * FROM assignment_help ORDER BY assign_id DESC";
    $result = $conn->query($sql);
//    echo '<form id="part_select"><label>Select the name of practice_part you are looking for</label><select onchange="go_to_date(this)">';
    while ($row = $result->fetch_assoc()) {
        if ($row['assign_name'] == $assign_name) {
            echo '<option value="' . $row['assign_name'] . '" selected > ' . $row['assign_name'] . '</option>';
        } else {
            echo '<option value="' . $row['assign_name'] . '" > ' . $row['assign_name'] . '</option>';
        }
    }
    echo '</select>';
    echo '</form>';
    echo '<a href="includes/delete_assignment.php?assign_id='.$assign_id.'" style="color=red;">[DELETE]</a>';
}




?>
<br>
<form action="includes/upload_assignment.php" method="POST" enctype="multipart/form-data" >
    <input type="hidden" name="MAX_FILE_SIZE" value="500000000000000">
    <label>Assignment name</label>
    <input type="text" name="assign_name"><br>
    <input type="file" name="file">
    <input type="submit">

</form>

<script>
    function help_stat(playing,part_name,id) {
        $.ajax({
            method: "POST",
            url: "includes/add_stat_assignment_page.php",
            //play_pause 0=playing
            data: {play_pause: playing, part_name: part_name, id: id}
        })
    }
    function go_to_help(part) {

        window.location.href = "assignment_help.php?part=" + ($("#part_select option:nth-of-type(" + (part.selectedIndex+1) + ")").val());
    }
</script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="js/main.js"></script>
</body>
</html>