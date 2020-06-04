<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 6/15/2018
 * Time: 2:59 PM
 */

include_once 'includes/dbh-inc.php';
session_start();
if (isset($restricted) ) {
    if (isset($_SESSION['u_id'])) {
        if ($restricted == 3 && $_SESSION['u_rank'] < 3) {
            header("Location: maintenance.php?location=".$user_location);
        }else
            if ($restricted > $_SESSION['u_rank']) {
                header("Location: 404.html");
            }
    } else {
        header("Location: 404.html");
    }
    date_default_timezone_set('America/Chicago');
    include_once 'includes/functions.php';
    if (isset($_SESSION['onvideopage']) && $_SESSION['onvideopage'] == true) {
        add_stat("left video page",$_SESSION['u_id']);
        $_SESSION['onvideopage'] = false;
    }
    if (isset($_SESSION['onassignmenthelp']) && $_SESSION['onassignmenthelp'] == true) {
        add_stat("left assignment help page",$_SESSION['u_id']);
        $_SESSION['onassignmenthelp'] = false;
    }
}
?>

<nav id="nav" >
    <div class="holder" style="overflow: visible">
        <a href="index.php" class="home <?php
        if ($user_location == "index") {
            echo 'current';
        }
        ?>">home</a>
        <a href="events.php" class="calendar <?php
        if ($user_location == "events") {
            echo 'current';
        }
        ?>">events</a>

        <a href="videos.php" class="videos <?php
        if ($user_location == "videos") {
            echo 'current';
        }
        ?>">Performances</a>
        <a href="faq.php" class="faq <?php
        if ($user_location == "faq") {
            echo 'current';
        }
        ?>">FaQ</a>
        <a href="about.php" class="about <?php
        if ($user_location == "about") {
            echo 'current';
        }
        ?>">About</a>
<!--        <a href="psp_app.pdf" target="_blank">Application</a>-->

        <?php
        if (isset($_SESSION['u_id'])) {

//           extra tabs go here


            if(time() - $_SESSION['login_time'] >= 3000){
                include_once 'includes/functions.php';
                date_default_timezone_set('America/Chicago');
                add_stat("user returned to the site",$_SESSION['u_id']);
                $_SESSION['login_time'] = time();
//                header("Location: includes/logout-inc.php");
                //redirect if the page is inactive for 30 minutes
            }
            else {
                $_SESSION['login_time'] = time();
                // update value of session
            }

            if ($_SESSION['u_rank'] >= 1) {
                $current = "";
                if ($user_location == "user_edit") {
                    $current = "current";
                }
                echo '<a href="contacts.php" class="' . $current . '">Contacts</a>';
            }
            if ($_SESSION['u_rank'] >= 1) {
                $current = "";
                if ($user_location == "practice_videos") {
                    $_SESSION['onvideopage'] = true;
                    add_stat("entered video page",$_SESSION['u_id']);
                    $current = "current";
                }
                echo '<a href="Instruction_Videos.php" class="' . $current . '">Click Tracks, Videos, & MP3</a>';
            }
            if ($_SESSION['u_rank'] >= 1) {
                $current = "";
                if ($user_location == "assignment_help") {
                    $_SESSION['onassignmenthelp'] = true;
                    add_stat("entered assignment help page",$_SESSION['u_id']);
                    $current = "current";
                }
                echo '<a href="assignment_help.php" class="' . $current . '">Assignment help</a>';
            }
            if ($_SESSION['u_rank'] >= 1) {
                $current = "";
                if ($user_location == "practice_part") {
                    $current = "current";
                }
                echo '<a href="practice_part.php" class="' . $current . '">Parts</a>';
            }
            if ($_SESSION['u_rank'] >= 1) {
                $current = "";
                if ($user_location == "schedule") {
                    $current = "current";
                }
                echo '<a href="schedule.php" class="' . $current . '">Schedule & Mandatory Dates</a>';
            }
            if ($_SESSION['u_rank'] >= 2) {
                $current = "";
                if ($user_location == "user_stats") {
                    $current = "current";
                }
                echo '<a href="User_Stats.php" class="' . $current . '">Stats</a>';
            }
            if ($_SESSION['u_rank'] >= 1) {
                $current = "";
                if ($user_location == "m2qass_email") {
                    $current = "current";
                }
                echo '<a href="mass_email.php" class="' . $current . '">Mass Email</a>';
            }



            echo '<a href="includes/logout-inc.php">logout</a>
<a href="resetpass.php">Change Password</a>';


            //mothers day here

            if ($_SESSION['u_rank'] >= 2) {
                $current = "";
                if ($user_location == "motheres") {
                    $current = "current";
                    echo '<a href="mothers.php" class="' . $current . '">Happy Mother\'s Day</a>';
                }
            }
            if ($_SESSION['u_rank'] >= 2) {
                $current = "";
                if ($user_location == "fathers") {
                    $current = "current";
                }
                echo '<a href="fathers.php" class="' . $current . '">Happy Father\'s Day</a>';
            }



            //end of navigation bar for logged in people

            //test results tab
            $sql = "SELECT * FROM test_results";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if ($_SESSION['u_rank'] >= $row['active'] && false) {//remove the and false next year
                $current = "";
                if ($user_location == "test_results") {
                    $current = "current";
                }
                echo '<a href="test_results.php" class="' . $current . '">Test Results</a>';
            }


        } else {

            //more input for test results
            $sql = "SELECT * FROM test_results";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if ($row['active'] == 0) {
                $current = "";
                if ($user_location == "test_results") {
                    $current = "current";
                }
                echo '<a href="test_results.php" class="' . $current . '">Test Results</a>';
            }


            echo '<a href="#" onclick="sign_in()">Log in</a>
        <a href="#" onclick="sign_up()">Sign Up</a>';



//            test if signup failed

            if (isset($_GET["signup"])) {
                $test_if_failed = $_GET["signup"];
                echo '<script>
$(document).ready(function() {
    sign_up();
} );

</script>';
                if ($test_if_failed == "invalid") {
                    echo '<span>Invalid Characters Detected</span>';
                }
                if ($test_if_failed == "email") {
                    echo '<span>Invalid Email</span>';
                }
                if ($test_if_failed == "usertaken") {
                    echo '<span>That username is taken</span>';
                }
                if ($test_if_failed == "empty") {
                    echo '<span>Some or all of entry fields were empty</span>';
                }
            }
//            test is password wrong
            if ((isset($_GET["signup"]) && $_GET["signup"] == "success")) {
                echo '<script>
$(document).ready(function() {
    sign_in();
} );

</script>';
            }
            if (isset($_GET["login"])) {
                $test_if_failed = $_GET["login"];
                echo '<script>
$(document).ready(function() {
    sign_in();
} );

</script>';
                if ($test_if_failed == "user_not_found") {
                    echo '<span>Username Invalid</span>';
                }
                if ($test_if_failed == "password_wrong") {
                    echo '<span>Password Invalid</span>';
                }
                if ($test_if_failed == "empty") {
                    echo '<span>Some or all of entry fields were empty</span>';
                }
            }

        }
        if (isset($_GET["reset"])) {
            if ($_GET["reset"] == "success") {
                echo '<span>Password has been changed</span>';
            }
        }
        if (isset($_GET["email"])) {
            echo '<span>Email Sent! (You should get a copy)</span>';
        }
        ?>
    </div>
    <?php
    if (!isset($_SESSION['u_id'])) {
        echo '<form action="includes/login-inc.php" method="POST" id="sign-in" class="hide">
            <input type="text" required name="uid" placeholder="Username/e-mail">
            <input type="password" name="pwd" placeholder="password">
            <button type="submit" name="submit">Login</button>
        </form>
    <form action="includes/signup-inc.php" id="sign-up" METHOD="POST" class="hide">
        <input type="text" required name="first" placeholder="Firstname">
        <input type="text" required name="last" placeholder="Lastname">
        <input type="text"  required name="email" placeholder="E-mail">
        <input type="tel" name="phone" placeholder="phone">
        <input type="text" required name="uid" placeholder="Username">
        <input type="password" required name="pwd" placeholder="Password">
        <button type="submit" name="submit"> Sign Up</button>
    </form>';
    }
    ?>
</nav>