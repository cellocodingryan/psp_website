<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 8/8/2018
 * Time: 7:37 AM
 */
include_once 'dbh-inc.php';
session_start();
if ($_SESSION['u_rank'] >= 2) {
    $id = $_GET['assign_id'];
    $sql = "DELETE FROM assignment_help WHERE assign_id='$id'";
    $conn->query($sql);
    header("Location: ../assignment_help.php?delete=gone");
} else {
    echo '<h1>GET OUT</h1>';
}