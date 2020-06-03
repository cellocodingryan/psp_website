<?php

session_start();
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 6/15/2018
 * Time: 1:04 PM
 */

if (isset($_POST['submit'])) {
    include 'dbh-inc.php';
    include_once 'functions.php';

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

    //error handlers
//    check if inputs are empty

    if (empty($uid) || empty($pwd)) {
//        header("Location: ../index.php?login=empty");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE user_uid ='$uid' OR user_email='$uid'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: ../index.php?login=user_not_found");
            exit();
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                if ($hashedPwdCheck == false) {
                    header("Location: ../index.php?login=password_wrong");
                    exit();
                } elseif ($hashedPwdCheck == true) {
                    //log in the user here

if ($row['user_rank']==1.1)
    die("There is an error, please try again later");
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_emails'] = $row['user_email_all'];
                    $_SESSION['u_uid'] = $row['user_uid'];
                    $_SESSION['u_rank'] = $row['user_rank'];

                    $_SESSION['login_time'] = time();
                    $user_id = strval($_SESSION['u_id']);
                    $date = date('m') . "-" .  date('d') . "-20" . date('y');



                    date_default_timezone_set('America/Chicago');
                    add_stat("Logged On",$_SESSION['u_id']);
                    header("Location: ../index.php?login=success&id=".$_SESSION['u_id']);
                    exit();
                }
            }
        }
    }

} else {
    header("Location: ../index.php?login=error");
    exit();
}