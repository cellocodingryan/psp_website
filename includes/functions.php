<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 6/17/2018
 * Time: 10:20 PM
 */
include_once 'dbh-inc.php';
function phone_print($phone) {
// note: making sure we have something
    if(!isset($phone{3})) { return ''; }
    // note: strip out everything but numbers
    $phone = preg_replace("/[^0-9]/", "", $phone);
    $length = strlen($phone);
    switch($length) {
        case 7:
            return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
            break;
        case 10:
            return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
            break;
        case 11:
            return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
            break;
        default:
            return $phone;
            break;
    }
}

function get_name($user_id) {

    $conn = $GLOBALS['conn'];
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        if ($row['user_id'] == $user_id) {
            $name = $row["user_first"] . ' ' . $row["user_last"];
            if ($row['user_rank'] == 1.1) {
                $name = "<span style='color: green;'>ALUMNI </span>" . $name;
            } else if ($row['user_rank'] == 2) {
                $name = "<span style='color: blue;'>DIRECTOR </span>" . $name;
            } else if ($row['user_rank'] > 2) {
                $name = "<span style='color: red;font-weight: bolder;'>ADMIN </span>" . $name;
            }
            return $name;
        }

    }
    return "BigFoot";
}
function add_stat($user_stat, $user_id) {
//    assert(false);
    date_default_timezone_set('America/Chicago');
    $date = date("Y-m-d H:i:s");
    $sql = "INSERT INTO stats (user_id,stats_datetime,user_stat) VALUES ('{$user_id}','{$date}','{$user_stat}')";

    $conn = $GLOBALS['conn'];
    $conn->query($sql);
//    echo mysqli_error($conn) . $user_stat . " PPP " .$user_id;
}
