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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</head>
<body>
<div class="title_leader_and_logo container">
    <div class="title_and_leaders row">
        <div class="header_logo col"></div>
        <div class="leader_text col">
            <p>The Percussion Scholarship Group &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; Patricia Dash & Douglas Waddell, Directors</p>
        </div>
    </div>
</div>
<img src="images/banner.jpg">

<?php
$user_location = "index";
include_once 'nav.php';
?>
<div class="welcome_article">
    <h1>Welcome</h1>
    <p>On behalf of <u>The Percussion Scholarship Group</u> we would like to welcome you to our official website. Feel free to check out our gallery and keep up with our upcoming events. We appreciate all of your support and hope you continue to enjoy our music.</p>
    <?php if (isset($_SESSION['u_id'])): ?>
    <p></p>
    <?php endif ?>
</div>
<div class="promo_video_container container">
    <div class="row video_container">
        <h1>Videos Loading</h1>
    </div>
</div>
<h1 id="credit">Created by <a target="_blank" href="http://homepages.rpi.edu/~wadder" style="text-decoration: overline underline;" >Ryan Waddell</a></h1>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="js/main.js"></script>
</body>
</html>
