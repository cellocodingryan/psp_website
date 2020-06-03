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
$user_location = "practice_videos";
include_once 'nav.php';
include_once 'includes/functions.php';
include_once 'includes/dbh-inc.php';









include_once 'includes/dbh-inc.php';
$sql = "SELECT * FROM practice_videos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
//        echo '<span>test</span>';
    while ($row = $result->fetch_assoc()) {
        $video_name = "'" . $row['video_name'] . "'";
        $delete_button = "";
        if ($_SESSION['u_rank'] > 1) {

            $delete_button = '<a href="#" style="color: red;" onclick="delete_(\'video\',' .$video_name. ')">[DELETE]</a>';
        }
        echo '<h1>' . $row['video_name'] . ' </h1>' . $delete_button;
        echo '<video controlsList="nodownload" onplay="add_info(\'play\', ' .   $video_name  .' )" onpause="add_info(\'pause\', ' .   $video_name  .' )"src="practice_video/' . $row['file_name'] . '" width="100%" controls> </video>';

    }
}

//upload video


if ($_GET['success'] == true) {
    echo '<h6>Video Uploaded Successfully</h6>';
}



if ($_SESSION['u_rank'] > 1) {
    echo '<h6>Upload New Practice Track</h6>
<form enctype="multipart/form-data" method="post" action="includes/upload_video-inc.php">
    <input type="hidden" name="MAX_FILE_SIZE" value="50000000000000000000000">
    Video Name <br>
    <input type="text" placeholder="video name" required name="video_name"><br>

    File <br>
    <input type="file" name="file">
    <input type="checkbox" name="replace"><label>Replace</label>
    <input type="submit" name="submit" value="Upload File">
</form>';
}

?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="js/main.js"></script>
</body>
</html>