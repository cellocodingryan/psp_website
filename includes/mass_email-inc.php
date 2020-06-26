<h1>Loading please do not leave this page</h1>

<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 7/14/2018
 * Time: 11:21 PM
 */


include_once 'dbh-inc.php';
include_once 'functions.php';
session_start();
if (!isset($_SESSION['u_rank']) || $_SESSION['u_rank'] < 1) {
    die("error");
}
$emails_to_send = array();
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
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
$attachment = false;
$file_name = "";
if (file_exists($_FILES['attachment']['tmp_name'])) {
    $attachment = true;
    $file_name = $_FILES['attachment']['name'];
    $connected = uploadFTP(getenv('serverip'),getenv('ftpusername'),getenv('ftppassword'),$_FILES['attachment']['tmp_name'],getenv('emailattachlocation').'/email_attachment/'.$_FILES['attachment']['name']);
    echo getenv('emailattachlocation').'/email_attachment/'.$_FILES['attachment']['name'];
}

while ($row = $result->fetch_assoc()) {
    if (isset($_POST[$row['user_id']])) {
        $emails_for_user = json_decode($row['user_email_all']);
        array_push($emails_to_send,$row['user_id']);
    }
}
include_once '../testemail/email-inc.php';
$worked;
$message = "No Message Specified";
$subject = "No Subject Specified";
if (strlen($_POST['message']) > 0) {
    $message = $_POST['message'];
}
echo 'Message: '.$message;
if (strlen($_POST['subject']) > 0) {
    $subject = $_POST['subject'];
}
if ($attachment) {
    $worked = send_mail($emails_to_send, $subject, $message,"../../email_attachment/".$file_name);
} else {
    $worked = send_mail($emails_to_send, $subject, $message);
}
echo '<p>The email was sent to:</p><ul>';
$stat_string = "Worked: ";
foreach ($worked[0] as $person) {
    echo '<li>' . $person. '</li>';
    $stat_string .= $person . ", ";
}
$stat_string .= " Did not work: ";
echo '</ul>';

if (sizeof($worked) > 0) {
    echo '<p>The email failed to send to:</p><ul>';
    foreach ($worked[1] as $person) {
        echo '<li>' . $person. '</li>';
        $stat_string .= $person . ", ";
    }
}

echo '</ul><h1>Sending complete (you can leave the page now)</h1> ';
add_stat("sent email (debug)" . $stat_string,$_SESSION['u_id']);
echo '<a href="../mass_email.php">[Go to mass email page]</a><br>';
echo '<a href="../index.php">[Go to home page]</a>';
//header("Location: ../index.php?email=".$worked);
?>