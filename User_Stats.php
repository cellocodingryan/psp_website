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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.4/r-2.2.2/rr-1.2.4/sc-1.5.0/datatables.min.css"/>


    <title>Hello, world!</title>
</head>
<body>
<?php
$restricted = 2;
$user_location = "user_stats";
include_once 'nav.php';
include_once 'includes/dbh-inc.php';
include_once 'includes/functions.php';
$_name = "";

?>
<?php if (isset($_GET['comefromcontacts'])): ?>
        <a href="contacts.php">[Go Back]</a>
    <?php endif ?>



<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
    <tr>
        <th>TimeStamp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>Stat</th>

    </tr>
    </thead>
    <tbody>
<?php
$date = date("Y-m-d H:i:s");



$result_stats = $conn->query("SELECT * FROM stats ORDER BY stats_datetime DESC");
while ($stats_loop = $result_stats->fetch_assoc()) {

    $user_id_tmp = $stats_loop['user_id'];
    $user_id_int = intval($user_id_tmp);
    if (isset($_GET['user']) && $_GET['user'] != $user_id_int) {
        continue;
    }
    $user_id = $conn->query("SELECT * FROM users WHERE user_id='{$user_id_int}'");
//    echo mysqli_num_rows($user_id);
    $row = $user_id->fetch_assoc();
//    echo '<h1>TEST'. mysqli_error($conn).'</h1>';
    $name = $row['user_first'] . " " . $row['user_last'];

    //for unranked name

    if ($row['user_rank'] == 1.1) {
        $name = "<span style='color: green;'>ALUMNI </span>" . $name;
    } else if ($row['user_rank'] == 2) {
        $name = "<span style='color: blue;'>DIRECTOR </span>" . $name;
    } else if ($row['user_rank'] > 2) {
        $name = "<span style='color: red;font-weight: bolder;'>ADMIN </span>" . $name;
    }
//        echo "<h2>". "SELECT * FROM users WHERE user_id='{$user_id_tmp}'" . "</h2>";

    echo '<tr>';

    echo '<td>' . $stats_loop['stats_datetime'] . '</td>';

    echo '<td>' . $name . '</td>';

    echo '<td>' . $stats_loop['user_stat'] . '</td>';

    echo '</tr>';

}
if ($_SESSION['u_id'] == 0) {
    die ("Not Authorized. If you believe this to be an error contact your system administrator.");
}
//add_stat("visited stats page",$_SESSION['u_id']);

?>




    </tbody>
    <tfoot>
    <tr>
        <th>TimeStamp</th>
        <th>Name</th>
        <th>Stat</th>

    </tr>
    </tfoot>
</table>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.4/r-2.2.2/rr-1.2.4/sc-1.5.0/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "ordering":false
        });
    } );
</script>
<script src="js/main.js"></script>
</body>
</html>