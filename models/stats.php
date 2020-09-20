<?php
require_once 'db.php';
require_once 'user.php';
class stats {
    public static function add_stat($user_stat, $user_id) {
        date_default_timezone_set('America/Chicago');
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO stats (user_id,stats_datetime,user_stat) VALUES ('{$user_id}','{$date}','{$user_stat}')";

        db::getdb()->query($sql);
    }
    public static function get_all_stats($startnum,$numresults,$user_id = null) {
        $sql = "SELECT user_id as user_id,DATE_FORMAT(stats_datetime,\"%M %d %l:%i:%s %r\") as stats_datetime,user_stat as user_stat FROM stats  ORDER BY stats_id DESC";
        if ($user_id != null) {
            $sql = "SELECT user_id as user_id,DATE_FORMAT(stats_datetime,\"%M %d %l:%i:%s %r\") as stats_datetime,user_stat as user_stat FROM stats WHERE user_id='$user_id' LIMIT $startnum,$numresults";
        }
        $result = db::getdb()->query($sql);
        $returnarray = $result->fetch_all(MYSQLI_ASSOC);
        $count = 0;
//
        foreach ($returnarray as $i) {

            $user = user::get_by_id(intval($i['user_id']));
            $username = "Unknown";
            if ($user != null) {

                $username = $user->get_firstname()." ".$user->get_lastname();
            }
            $returnarray[$count]['user_id'] = $username;
            ++$count;
        }
        return $returnarray;
    }
}
