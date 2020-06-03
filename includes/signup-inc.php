<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 6/15/2018
 * Time: 12:17 PM
 */
if (isset($_POST['submit'])) {
    include_once 'dbh-inc.php';

    $first = mysqli_real_escape_string($conn, $_POST['first']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $email_all = '["' . $email . '"]';
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $rank = 0;
    $phone_self = mysqli_real_escape_string($conn, $_POST['phone']);
    $phone_object = (array) [
        array("student cell","8888888888"),
        array("mom cell","88888888888"),
        array("dad cell","88888888888"),
        ];
    $phone = json_encode($phone_object);
//    0 = user, 1 = member, 2 = director, 3 = admin
    //check for empty fields

    if (empty($first) ||empty($last)||empty($email)||empty($uid)||empty($pwd)) {
        header("Location: ../index.php?signup=empty");
        exit();
    }
    //check if input chars are valid
    elseif (!preg_match("/^[a-zA-Z]*$/",$first) || !preg_match("/^[a-zA-Z]*$/",$last)) {
        header("Location: ../index.php?signup=invalid");
        exit();
    }
//    check if input chars are valid
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?signup=email");
        exit();

    }
//    check dups of username
    else{
        $sql = "SELECT * FROM users WHERE user_uid='$uid'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            //throw
            header("Location: ../index.php?signup=usertaken");
            exit();
        }
//        hashing the password
        else {
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
//            insert the user into the database
            $sql = "INSERT INTO users (user_first, user_last, user_email, user_email_all, user_phone, user_uid, user_pwd, address, family, user_rank) VALUES ('$first', '$last', '$email', '$email_all', '$phone', '$uid', '$hashedPwd', '', '', '$rank');";
            $result = mysqli_query($conn, $sql);
//            include_once 'functions.php';

//            add_stat("Created Account",)
            header("Location: ../index.php?signup=success");
            exit();
        }
    }

} else {
    header("Location: ../index.php");
    exit();
}