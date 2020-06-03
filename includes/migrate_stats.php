<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 11/1/18
 * Time: 2:42 PM
 */

session_start();
if ($_SESSION['u_rank'] < 3) {
    header("Location: ../index.php");
    die("Not Authorized");
}
include_once 'dbh-inc.php';
$conn = $GLOBALS['conn'];

$result_users = $conn->query("SELECT * FROM users");

while ($row_user = $result_users->fetch_assoc()) {
    $user_id = $row_user['user_id'];
    $user_id_s = "user_id_".$user_id;
    $sql = "SELECT {$user_id_s} FROM user_stats";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        if (isset($row[$user_id_s]) && $row[$user_id_s] != "") {
            echo $row_user['user_id'] ." ". $row_user['user_last'] . "<br><br><br><br>";
            $stat = json_decode($row[$user_id_s]);
            for ($i = 0;$i < count($stat);++$i) {
//                echo $stat[$i] . "<br>";
                $datetime_string = explode("]",explode("[",$stat[$i])[1])[0];
                $time_string = explode(" ",$datetime_string)[1];
                $date_string = explode(" ",$datetime_string)[0];
//                echo $date_string . "<br><br>";
//                echo $time_string . "<br><br>";
                $time = explode(":",$time_string);
                if (count($time) == 2) {
                    array_push($time,"00");
                }
                $date_array = explode("-",$datetime_string);
                $date = mktime($time[0],$time[1],$time[3],$date_array[0],$date_array[1],$date_array[2]);
                $mysql_date = date("Y-m-d H:i:s",$date);
                $stat_thing = explode("]",explode("[",$stat[$i])[1])[1];
                $user_id = intval($row_user['user_id']);
//                echo "INSERT INTO stats ('user_id','stats_datetime','user_stat') VALUES ('{$user_id}','{$mysql_date}','{$stat_thing}')" . "<br>";
//                $conn->query("INSERT INTO test (a) VALUES ('some value')");
                $conn->query("INSERT INTO stats (user_id,stats_datetime,user_stat) VALUES ('{$user_id}','{$mysql_date}','{$stat_thing}')");
                echo mysqli_error($conn);
            }
        } else {
//            echo 'what';
        }
    }
}
