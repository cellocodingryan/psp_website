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
include 'includes/dbh-inc.php';


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

//practice video upload

if (isset($_POST['video_name'])) {
    //debug
    $name = "nameless";
    if (isset($_POST['video_name'])) {
        $name = $_POST['video_name'];
    }
    $sql = "SELECT * FROM practice_videos WHERE video_name='$name'";
    $result = $conn->query($sql);
    $worked = true;
    $error_message = "";
    if (mysqli_num_rows($result) > 0) {

        if (isset($_POST['replace'])) {
            $sql = "DELETE FROM practice_videos WHERE video_name='$name'";
            $result = mysqli_query($conn,$sql);
        } else {
            $error_message = "Video name exists";
            $worked = false;

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
            $error_message = "file name exists";
//            header("Location: Instruction_Videos.php?error=file_name_exists");
            $worked = false;
        }
    }

    $sql = "INSERT INTO practice_videos (video_name,file_name) VALUES ('$name','$file')";
    $result = mysqli_query($conn,$sql);
echo mysqli_error($conn);






    if ($worked) {

        $connected = uploadFTP(getenv('serverip'),getenv('ftpusername'),getenv('ftppassword'),$_FILES['file']['tmp_name'],getenv('emailattachlocation').'/practice_video/'.$_FILES['file']['name']);
        if (!$connected || $_FILES['file']['error'] != 0) {
            $worked = false;
            if (!$connected) {
                $error_message = "connection_error";
            } else {
                $error_message = $_FILES['file']['error'];
            }
        }
    }


    if ($worked) {
        echo '<script>alert("Video Uploaded");</script>';
    } else {
        echo '<script>alert("' . $error_message . '");</script>';
    }


}

function set_priority($video_id,$order_id) {


	$conn = $GLOBALS['conn'];

$result_rec = $conn->query("SELECT * FROM practice_videos WHERE order_id='$order_id'");

if ($result_rec->num_rows >0) {
$row_rec = $result_rec->fetch_assoc();
}else{
$row_rec = NULL;
}
	$sql = "UPDATE practice_videos SET order_id='$order_id' WHERE video_id='$video_id'";
	//echo "sql: " . $sql . "ERROR" . mysqli_error($conn);
	$result = $conn->query($sql);
	
echo 'recurse? ' . $row_rec['video_id'] . '::' . $video_id;
	if ($row_rec != NULL && $row_rec['video_id'] !== $video_id) {
		//echo 'WENT IN ';
		//echo $row_rec['video_id'] . 'xx' . ($order_id+1);
		set_priority($row_rec['video_id'],$order_id+1);
		$row = $result->fetch_assoc();

	} else {
header("Location: Instruction_Videos.php");
}
}

//order_form

if (isset($_POST['priority'])) {

	set_priority($_POST['video_id'],$_POST['priority']);


}

if ($_SESSION['u_rank'] > 1) {
    echo '<h6>Upload New Practice Track</h6>
<form enctype="multipart/form-data" method="post" action="">
    <input type="hidden" name="MAX_FILE_SIZE" value="50000000000000000000000">
    Video Name <br>
    <input type="text" placeholder="video name" required name="video_name"><br>

    File <br>
    <input type="file" name="file">
    <input type="checkbox" name="replace"><label>Replace</label>
    <input type="submit" name="submit" value="Upload File">
</form>';
}

include_once 'includes/dbh-inc.php';
$sql = "SELECT * FROM practice_videos ORDER BY order_id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
//        echo '<span>test</span>';
$count = 1;
    while ($row = $result->fetch_assoc()) {
        $video_name = "'" . $row['video_name'] . "'";
        $delete_button = "";
$video_id = $row['video_id'];
$override = false;
if ($override)
	set_priority($video_id,$count++);
$order_id = $row['order_id'];
$order_form = "";
        if ($_SESSION['u_rank'] > 1) {

            $delete_button = '<a href="#" style="color: red;" onclick="delete_(\'video\',' .$video_name. ')">[DELETE]</a>';
$order_form = '<label>Change priority: </label>
	<form enctype="multipart/form-data" method="post" action="">
	<input type="hidden" name="video_id" value="'.$video_id.'">
	<input type="number" name="priority" value="'.$order_id.'">
	<input type="submit" value="update">
	</form>
	';
        }
        echo '<h1>' . $row['video_name']  . $delete_button . $order_form . '</h1>';
        echo '<video controlsList="nodownload" onplay="add_info(\'play\', ' .   $video_name  .' )" onpause="add_info(\'pause\', ' .   $video_name  .' )"src="fileserver.php?folder=practice_video&videoname=' . $row['file_name'] . '" width="100%" controls> </video>';

    }
}

//upload video




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