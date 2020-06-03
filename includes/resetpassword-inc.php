<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 7/13/2018
 * Time: 7:36 PM
 */
session_start();
include_once 'dbh-inc.php';
$old = mysqli_real_escape_string($conn, $_POST['old']);
$new = mysqli_real_escape_string($conn, $_POST['new']);
$repeat = mysqli_real_escape_string($conn, $_POST['repeat']);

if (!isset($_POST['old']) && $_SESSION['u_rank'] < 2) {
    header("Location: ../resetpass.php?reset=oldpass");
    exit();
}
$current_user_id = $_SESSION['u_id'];
if (isset($_POST['u_id'])) {
    $current_user_id = $_POST['u_id'];
}

$sql = "SELECT * FROM users WHERE user_id='$current_user_id'";
$row = mysqli_fetch_assoc(mysqli_query($conn,$sql));
if ($old != NULL && !password_verify($old, $row['user_pwd'])) {
    header("Location: ../resetpass.php?reset=oldpass");
    exit();
}
if ($new == NULL || ($new != $repeat && ($_SESSION['u_rank'] < 2 || !isset($_POST['u_id'])))) {
    header("Location: ../resetpass.php?reset=newpass");
    exit();
}

$pwd = password_hash($new, PASSWORD_DEFAULT);
$sql = "UPDATE users SET user_pwd='$pwd' WHERE user_id='$current_user_id'";
$result = mysqli_query($conn,$sql);

header("Location: ../index.php?reset=success");