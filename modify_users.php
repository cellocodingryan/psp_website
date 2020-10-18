<?php
require 'init.php';

user::auth("director");

$users = mysqli_query(db::getdb(),"SELECT user_id,user_first,user_rank FROM users");

$user_ids = [];
if (!$users) {
    echo mysqli_error(db::getdb());
}
while ($row = mysqli_fetch_assoc($users)) {
    $user_ids = $row['user_id'];
}

echo $twig->render("modify_users.twig",["users"=>$users,"navvars" => $navvars]);