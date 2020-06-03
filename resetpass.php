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
<body>
<?php
$restricted = 0;
$user_location = "reset_password";
include_once 'nav.php';
include_once 'includes/dbh-inc.php';
include_once 'includes/functions.php';

?>
<h1>CHANGE PASSWORD</h1>
<?php
if ($_SESSION['u_rank'] > 1) {
    if (isset($_GET['user_id'])) {
        echo '<h2>Changing password for ' . $_GET['user_name'] . ' username: '. $_GET['username'] .'</h2>';
    }
}

if (isset($_GET['reset'])) {
    $reset = $_GET['reset'];
    if ($reset == "oldpass") {
        echo '<h4>Your old password is not correct</h4>';
    } else {
        echo '<h4>Your new passwords do not match</h4>';
    }
}

?>
<form method="post" action="includes/resetpassword-inc.php">
    <?php

    if (!($_SESSION['u_rank'] > 1 && isset($_GET['user_id']))) {
        echo '<input type="password" name="old" placeholder="old password">
<input type="password" name="new" placeholder="new password"><input type="password" name="repeat" placeholder="repeat password">';

    } else {
        echo '<input type="password" name="new" placeholder="new password">';

    }



    ?>


    <?php

    if ($_SESSION['u_rank'] > 1) {
        if (isset($_GET['user_id'])) {
            echo '<input name="u_id" hidden value="' . $_GET['user_id'] . '">';
        }
    }
    ?>
    <input type="submit">
</form>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="js/main.js"></script>
</body>
</html>