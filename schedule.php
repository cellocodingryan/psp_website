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
$user_location = "schedule";
include_once 'includes/dbh-inc.php';
include_once 'nav.php';
include_once 'includes/functions.php'
?>
<style>
    h1 {height 4%;}
    input:not([type=checkbox]) {height: 2%;}
    html, body {
        height: 100%;
    }
    iframe {height: 70%;width: 100%;}
</style>
<h1>Schedule</h1>


<?php
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
if(isset($_FILES['image'])){

    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_name=$_POST['date'];
    $mandatory = false;
    if (isset($_POST['mandatory'])) {
        $mandatory = true;
        $file_name = "[MANDATORY] Dates and Weekends off";
    }
    $date = date_create($file_name);
    @$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    $is_new = false;
//    sql for date here
    $sql = "SELECT * FROM schedule WHERE Schedule_date='$file_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sqld = "DELETE FROM schedule WHERE Schedule_date='$file_name'";
        $conn->query($sqld);
    }
    else if ($result->num_rows <= 0) {
        $is_new = true;
    }
    $sql = "INSERT INTO schedule (Schedule_date) VALUES ('$file_name')";
    $conn->query($sql);

    if(true){
        $sql_id = "SELECT * FROM schedule WHERE Schedule_date='$file_name'";
        $idres = $conn->query($sql_id);

        $id = $idres->fetch_assoc()['Schedule_id'];
        $connected = uploadFTP('74.220.207.132','percuss@percussionscholars.com','Corvair@11',$_FILES['image']['tmp_name'],"public_html/schedules/".$file_name.'---'.$id.'.'.$file_ext);
        include_once 'testemail/email-inc.php';
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $email_id_to_send = array();
        //DEBUG LINE
        //END DEBUG LINE
        while ($row = $result->fetch_assoc()) {
            if ($row['user_rank'] == 1.1) {
                continue;
            }
            if ($restricted > 2) {
                continue;
            }
            array_push($email_id_to_send,$row['user_id']);
        }
        if ($debug && sizeof($email_id_to_send) > 5) {
            header("Location: ../error.html");
        }
        $subject = "";
        if (!$mandatory) {
            if ($is_new) {
                $subject = "A new PSP schedule was published.";
                $message = "Hello everyone, a new schedule has been published by Mr. Waddell for the weekend of ".date_format($date,"m/d/y");
            } else {
                $subject = "This weeks schedule has been changed.";
                $message = "Hello everyone, a new schedule has been CHANGED by Mr. Waddell for the weekend of ".date_format($date,"m/d/y");
            }
        } else {
            $subject = "Mandatory dates and weekends off";
            $message = "This years mandatory dates and weekends off";
        }
        $mail_output = send_mail($email_id_to_send,$subject,$message,'schedules/'.$file_name."---".$id.".".$file_ext);
        $output_string = print_r($mail_output,true);

        echo '<script>alert("Schedule Published");window.location.href = \'schedule.php?date=' . $file_name . '\';</script>';

    }else{
        echo print_r($errors);
    }
}
$schedule_date = "x";
if (isset($_GET['schedule'])) {
    if ($is_new) {
        echo '<script>alert("Schedule Published");window.location.href = \'schedule.php\';</script>';
    } else {
        echo '<script>alert("Schedule Published");window.location.href = \'schedule.php\';</script>';
    }
}
$id = "";
if (isset($_GET['date'])) {
    $date = $_GET['date'];
//    echo '<script> ' .$date. '</script>';
    //verify
    $sql = "SELECT * FROM schedule WHERE Schedule_date='$date'";
    $result = $conn->query($sql);
    $id = $result->fetch_assoc()['Schedule_id'];
    if ($result->num_rows > 0) {
        $schedule_date = $date . "---" . $id;
    } else {
        header("Location schedule.php");
    }
} else {
    $sql = "SELECT * FROM schedule ORDER BY Schedule_date DESC";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
   if (substr($row['Schedule_date'],0,1) == "[") {
       $row = $result->fetch_assoc();
   }
    $id = $row['Schedule_id'];
    if ($result->num_rows > 0) {
        $schedule_date = ($row['Schedule_date']) . "---" . $id;
    }
}
if ($schedule_date != "x") {

    echo '<iframe src="schedules/' . $schedule_date . '.pdf"></iframe>';

}
?>




<?php
$sql = "SELECT * FROM schedule ORDER BY Schedule_date DESC";
$result = $conn->query($sql);
echo '<form id="date_select"><label>Select the date of schedule you are looking for</label><select onchange="go_to_date(this)">';
$first = true;
while ($row = $result->fetch_assoc()) {
    $style="";
    if (substr($row['Schedule_date'],0,1) == "[") {
        $style = 'Style="font-weight: bolder;color: #FF0000;"';
    }
    if ($row['Schedule_date']."---".$id == $schedule_date) {
        echo '<option ' . $style . 'value="' . $row['Schedule_date'] . '" selected > ' . $row['Schedule_date'] . '</option>';
    } else {
        echo '<option ' . $style . 'value="' . $row['Schedule_date'] . '" > ' . $row['Schedule_date'] . '</option>';
    }

}


echo '</select></form>';
if ($_SESSION['u_rank'] > 1) {

    $delete_button = '<a href="#" style="color: red;" onclick="delete_(\'schedule\',' .$id. ')">[DELETE]</a>';
    echo $delete_button;
}
if ($_SESSION['u_rank'] > 1) {
    echo '<h6>Upload New Schedule</h6>
<form action="" method="POST" enctype="multipart/form-data">
    <label>Enter date for new schedule: &nbsp</label><input type="date" required name="date">
    <label>Select File: &nbsp</label><input type="file" required name="image">
    <label>Mandatory: &nbsp</label><input name="mandatory" type="checkbox"><br>
    <input type="submit">
</form>';
}
?>

<script>
    function go_to_date(date) {

        window.location.href = "schedule.php?date=" + ($("#date_select option:nth-of-type(" + (date.selectedIndex+1) + ")").val());
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