<?php
require_once 'init.php';
$sql = "SELECT * FROM users";
$result = db::getdb()->query($sql);
$users = [];
$page = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page']-1;
}

$amount_per_page = 10;
if (isset($_GET['amount_per_page'])) {
    $amount_per_page = $_GET['amount_per_page'];
}
$searchval = "";
while($row = $result->fetch_assoc()) {
    if (isset($_GET['search']) && $_GET['search'] != "") {
        $searchval = $_GET['search'];
        $found = false;
        foreach($row as $k=>$v) {
            if (strpos($v,$searchval) !== false) {
                $found = true;
            }
        }
        if (!$found) {
            continue;
        }
    }
    $users[] = [
        "firstname"=>$row['user_first'],
        "lastname"=>$row['user_last'],
        "emails"=>json_decode($row['user_email_all']),
        "phones"=>json_decode($row['user_phone'])
    ];
}


echo $twig->render("contacts.twig",["navvars"=>$navvars,"contacts"=>array_slice($users,$page*$amount_per_page,$amount_per_page),"currentpage"=>$page,"amount_per_page"=>$amount_per_page,"total"=>mysqli_num_rows($result),"searchval"=>$searchval]);
exit();
?>


<?php
include_once 'includes/dbh-inc.php';
$sql = "SELECT * FROM users";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    $edit_value = "";
//        user id will go on here VVVVVV
    $what_to_change = "";
    $edit_rank = false;
    $edit = false;
    while($row = $result->fetch_assoc()) {


        echo '<tr id="user' . $row["user_id"] .'">';

        // name

        $resetpass = "";
        if ($edit) {
            $name = 'name';
            $what_to_change =$row['user_id'];
            if ($edit_rank) {
                $resetpass = "<a href='includes/resetpassoverride-inc.php?user_id=" . $row['user_id'] . "&user_first=" . $row['user_first'] . "&user_name=" . $row['user_uid'] . "  ' style='color:red'>[RESET PASSWORD]</a>";
            }
            $edit_value = "<span class='link_style' href='#' onclick='name_(); edit_contact_info(" . $what_to_change . ");'>[edit]</span>";
        }
        //make it a link only if user has high permissions
        $name_val = "";
        if ($_SESSION['u_rank'] > 1) {
            $name_val = '<th><a style="color: black;" href="User_Stats.php?days=7&user='.$row['user_id']. '&comefromcontacts=true">'.$row['user_first'].' '.$row['user_last'].'</a>' . $edit_value . $resetpass .'</th>';
        } else {
            $name_val = '<th>' . $row['user_first'] . ' ' . $row['user_last'] . $edit_value . $resetpass .'</th>';
        }
        echo $name_val;
        $edit_value = "";


//            email
//          get emails var from json decode
        $emails = json_decode($row['user_email_all']);
//           remove and add values is the remove and edit buttons
        $remove_value = "";
        $add_value = "";
        echo '<th>';
//            loop through all emails
        for ($i = 0; $i < sizeof($emails);++$i) {
            $edit_value = "";
            $remove_value = "";
            if ($edit) {
                $edit_value = "<span class='link_style' href='#' onclick='modify_email(\"edit\", $i, " . $what_to_change . ");'>[edit]</span>";
                $remove_value = "<a href='#' style='color:red' onclick='modify_email(\"remove\", $i, " . $what_to_change . ");'>[remove]</a>";
            }
            echo '<div>' . $emails[$i] . $edit_value . $remove_value . "</div>";
        }
//            the add button is here if they have edit permissions
        if ($edit) {
            $add_value = "<span class='link_style' href='#' style='color:green' onclick='modify_email(\"add\", $i, " . $what_to_change . ");'>[add]</span>";
        }
        echo $add_value . '</th>';


//            phone



        $edit_value = "";
        $add_value = "";
        $remove_value = "";
        if ($edit) {
            $what_to_change = $row['user_id'];
            $edit_value = "<span class='link_style' href='#' onclick='modify_phone(\"edit\", $i, " . $what_to_change . ");'>[edit]</span>";
            $add_value = "<span class='link_style' href='#' style='color:green' onclick='modify_phone(\"add\", 1, " . $what_to_change . ");'>[add]</span>";
        }
        $phone = json_decode($row['user_phone']);
        file_put_contents('php://stderr', print_r($phone, TRUE));
        $phonenum = "";
        echo '<th class="nowrap">';
        $size = sizeof($phone);
        for ($i =0;$i < sizeof($phone);++$i) {
            $phones = '<span>' . $phone[$i][0] . '</span>' . ':' . '<span>' . phone_print($phone[$i][1]) . '</span>';

            if ($edit) {
                $edit_value = "<span class='link_style' href='#' onclick='modify_phone(\"edit\", $i, " . $what_to_change . ");'>[edit]</span>";
                $add_value = "<span class='link_style' href='#' style='color:green' onclick='modify_phone(\"add\", $i, " . $what_to_change . ");'>[add]</span>";
                if ($i > 2 || $_SESSION['u_rank'] > 2) { //admin access
                    $remove_value = "<a href='#' style='color:red' onclick='modify_phone(\"remove\", $i, " . $what_to_change . ");'>[remove]</a>";
                } else {
                    $remove_value = "";
                }
            }
            echo '<div>' . $phones . $edit_value . $remove_value . '</div>';
        }
        if ($edit) {
            echo $add_value;
        }
        echo '</th>';



// END PHONE


//            address
        $edit_value = "";
        if ($edit) {
            $name = 'name';
            $what_to_change =$row['user_id'];
            $edit_value = "<span class='link_style' href='#' onclick='modify_address(" . $what_to_change . ");'>[edit]</span>";
        }
        echo '<th>' . $row['address'] . $edit_value . '</th>';
        $edit_value = "";


//            rank
        $rank = "";
        $rank_int = $row["user_rank"];
        if ($rank_int == 0) {
            $rank = "Pending";
        } else if ($rank_int == 1) {
            $rank = "Member";
        } else if ($rank_int == 1.1) {
            $rank = "Alumni";
        }

        else if ($rank_int == 2) {
            $rank = "Director";
        } else if ($rank_int == 3) {
            $rank = "Admin";
        }
        $edit_value = "";
        if ($edit_rank) {
            $what_to_change = $row['user_id'];
            $userrank = $row['user_rank'];
            $thisrank = $_SESSION['u_rank'];
            $edit_value = "<span class='link_style' href='#' onclick='rank();edit_contact_info(" . $what_to_change . ",$userrank,$thisrank)'>[edit]</span>";
        }
        echo '<th>' . $rank .$edit_value . '</th>';


        echo '</tr>';
        $edit = false;
    }
} else {
    echo "0 results";
}


?>
