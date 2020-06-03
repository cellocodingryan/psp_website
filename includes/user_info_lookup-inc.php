<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 7/13/2018
 * Time: 5:28 PM
 */

$days_lookup = $_POST['days'];
$user_lookup = $_POST['name'];

header("Location: ../User_Stats.php?days=$days_lookup&user=$user_lookup");