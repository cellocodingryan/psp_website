<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 6/15/2018
 * Time: 6:10 PM
 */
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}
session_start();
include_once 'dbh-inc.php';
$user = $_POST['id'];
//make sure use has permissions and di not try to get around the system
if ($_SESSION['u_rank'] < 2 && (int) $user != (int) $_SESSION['u_id']) {
//    console_log($user . "test" .$_SESSION['u_id']);
    header("Location: ../contacts.php");
    exit();
}
if (isset($_POST['first'])) {
    $value = mysqli_real_escape_string($conn, $_POST['first']);
    $sql = "UPDATE users SET user_first='$value' WHERE user_id='$user'";
    $conn->query($sql);

}
if (isset($_POST['last'])) {
    $value = mysqli_real_escape_string($conn, $_POST['last']);
    $sql = "UPDATE users SET user_last='$value' WHERE user_id='$user'";
    $conn->query($sql);
}
if (isset($_POST['email'])) {
//get new email as set by the user
    $value = mysqli_real_escape_string($conn, $_POST['email']);
//    find the user that is being edited on the database
    $sql = "SELECT * FROM users WHERE user_id ='$user'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
//    get the emails from the user that is being edited
    $emails = json_decode($row['user_email_all']);

    if (strlen($value) == 0) {
        $_POST['remove'] = ".";
    }
    if (isset($_POST['remove'])) {
        $emails_old = $emails;
        $emails = [];
        $which = (int) $_POST['which'];
        for ($i = 0;$i < sizeof($emails_old);++$i) {
            if ($i != $which) {
                $emails[] = $emails_old[$i];
            }
        }

    } else {
//        edi the email that is being edited
        if ($_POST["which"]
            > sizeof($emails)) {
//            if the email being edited is in the array, replace what was there
            $emails[] = $_POST['email'];
        } else {
//            add value to array
            $emails[(int)$_POST['which']] = $_POST['email'];
        }

    }
    $value = json_encode($emails);
    $sql = "UPDATE users SET user_email_all='$value' WHERE user_id='$user'";
//    console_log($emails);

    $conn->query($sql);
}

function remove($phone,$thing_to_remove) {
    $test = array();

    $phone_dub = (object) [

    ];


    return $phone_dub;
}

//phone
if (isset($_POST['phone_num'])) {
    //get new phone as set by the user
    $value = mysqli_real_escape_string($conn, $_POST['phone_num']);
//    find the user that is being edited on the database
    $sql = "SELECT * FROM users WHERE user_id ='$user'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
//    get the phones from the user that is being edited
    $phones = json_decode($row['user_phone']);
    $which = (int) $_POST['which'];
    $phones_new = array();
    if (isset($_POST['remove'])) {
        for ($i = 0;$i < sizeof($phones);++$i) {

            if ($i != $which) {
                $next_val = array($phones[$i][0],$phones[$i][1]);
                array_push($phones_new, $next_val);
            }
        }
        $phones = $phones_new;
    } else {
        if ($which >= sizeof($phones)) {
            $next_val = array($_POST['phone_belongs'],$_POST['phone_num']);
            array_push($phones,$next_val);
        } else {
            $phones[$which][0] = $_POST['phone_belongs'];
            $phones[$which][1] = $_POST['phone_num'];
        }
    }

    $value = json_encode($phones);
    $sql = "UPDATE users SET user_phone='$value' WHERE user_id='$user'";

    $conn->query($sql);
}

//address

if (isset($_POST['street'])) {

    $value[0] = mysqli_real_escape_string($conn, $_POST['street']);
    $value[1] = mysqli_real_escape_string($conn, $_POST['city']);
    $value[2] = mysqli_real_escape_string($conn, $_POST['state']);
    $value[3] = mysqli_real_escape_string($conn, $_POST['zip']);
    $address = '<div>'. $value[0] . '</div>' .'<div>'. $value[1] . '</div>' .'<div>'. $value[2] . '</div>' .'<div>'. $value[3] . '</div>';
    $sql = "UPDATE users SET address='$address' WHERE user_id='$user'";
    $conn->query($sql);
}


if (isset($_POST['rank'])) {

    $value = mysqli_real_escape_string($conn, $_POST['rank']);
//    console_log($value);
    if ($value < 0) {
        $sql = "DELETE FROM users WHERE user_id='$user'";
        $conn->query($sql);
    } else {
        if ($_SESSION['u_rank'] <= $_POST['rank']) {
            header("Location: ../contacts.php");
            exit();
        }
        $sql = "UPDATE users SET user_rank='$value' WHERE user_id='$user'";
        $conn->query($sql);
    }


}

// Function call
$id_s = strval($user);
$id_s = str_replace(' ', '', $id_s);
header("Location: ../contacts.php#user{$id_s}");
