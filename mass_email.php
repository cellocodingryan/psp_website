<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->


    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/extra_large.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:1199.99px)" href="css/large.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:991.99px)" href="css/medium.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:767.99px)" href="css/small.css">
    <link rel="stylesheet" type="text/css" media="only screen and (max-width:575.99px)" href="css/extra_small.css">


    <title>Hello, world!</title>
</head>
<!--keep middle box off bottom-->
<body style="padding-bottom: 3em">
<?php
$restricted = 1;
$user_location = "mass_email";
include_once 'nav.php';
include_once 'includes/dbh-inc.php';
include_once 'includes/functions.php';

?>
<!--center the top line text-->
<h1 style="text-align: center">Mass Email System</h1>
<p style="text-align: center">Welcome to the PSP Mass Email System, you can use this to contact specific groups of people.</p>
<p style="text-align:center;color: red">Be careful! Messages here are not saved!</p>

<form  method="POST" id="mass_email_check" action="includes/mass_email-inc.php" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="50000000000000000000000">
    <label>Subject</label><input  type="text" name="subject"><br>
    <label>Message</label><textarea rows="8" cols="2" name="message"></textarea><br>
    <label>Attachment (max of 1)</label><input type="file" name="attachment"><br><br>

    <input type="checkbox" id="all" onchange="check_all()"  name="all"><label onclick="click_all_click()">All Current Members</label><br>
    <input id="alumni" type="checkbox" onchange="select_alum()"><label>All Alumni</label><br>
<br>

    <?php
    $sql = "SELECT * FROM users";
$result = $conn->query($sql);
$count = 0;

while ($row = $result->fetch_assoc()) {
    $name = get_name($row['user_id']);
    $disabled = "";
    $name_class = "name";
    if ($row['user_rank'] == 1.1) {
        $name_class = "alumni";
    }
    if ($row['user_id'] == $_SESSION['u_id']) {
      $disabled  = "checked disabled";
      $name_class = "";
    }
    echo '<input class="' .$name_class. '"'. $disabled .' type="checkbox" onchange="check_one(' . $count . ')" name="' . $row["user_id"] . '"><label onclick="check(' . $count . ')"> ' . $name . '</label><br>';

    ++$count;
}
    ?>
    <input type="submit">
</form>

<script>
    var alumni_check = false;
    var all_checked = false;
    var checked = [];

    function click_all_click() {

        if (all_checked) {
            $("#all").prop('checked', false);
            check_all();
        } else {
            $("#all").prop('checked', true);
            check_all();
        }
    }
    <?php
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo 'checked.push(0);';
    }
    ?>

    function check_all() {
        if (!all_checked) {
            $("form .name").prop('checked', true);
            for (var i =0;i<checked.length;++i) {
                checked[i] = 1;
            }
            all_checked = true;
        } else {
            $("form .name").prop('checked', false);
            for ( i =0;i<checked.length;++i) {
                checked[i] = 0;
            }
            all_checked = false;
        }
    }

    function select_alum() {
        if (!alumni_check) {
            $("form .alumni").prop('checked', true);
            alumni_check = true;
        }

        else {
            $("form .alumni").prop('checked', false);
            alumni_check = false;
        }
    }
</script>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="js/main.js"></script>
</body>
</html>