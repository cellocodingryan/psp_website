<!doctype html>
<html lang="en" style="width: auto !important;">
<!--width auto to tmp fix the table from bleeding outside of the html tag-->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="contact_table/style.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">


    <link rel="stylesheet" type="text/css" href="css/extra_large.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:1199.99px)" href="css/large.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:991.99px)" href="css/medium.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:767.99px)" href="css/small.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:575.99px)" href="css/extra_small.css">

    <title>Hello, world!</title>
</head>
<body style="width: auto !important;">
<?php
$restricted = 1;
$user_location = "user_edit";
include_once 'nav.php';
include_once 'includes/functions.php'
?>

<h1>Members</h1>

<table id="myTable" class="table table-striped table-bordered tablesorter" style="width:100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
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
//            if ($i == 0 && $row['user_id'] != $_SESSION['u_id']) {
//                continue;
//            }
//            if ($i == 1 && $row['user_id'] == $_SESSION['u_id']) {
//                continue;
//            }
//            don't show pending to non director/admin
            if ($row['user_rank'] < 1 && $_SESSION['u_rank'] < 2) {
                continue;
            }
            if ($row['user_id'] == $_SESSION['u_id'] || ($_SESSION['u_rank'] >= 2 && $_SESSION['u_rank'] >= $row['user_rank'])) {
                $edit = true;
            }
            if (($_SESSION['u_rank'] >= 2 && $_SESSION['u_rank'] > $row['user_rank'])) {
                $edit_rank = true;
            }

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
    </tbody>
</table>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/jquery.tablesorter.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>