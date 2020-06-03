<!doctype html>
<html lang="en" style="background: white">
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
    <script
            src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


    <script src="js/jssor.slider.mini.js"></script>
    <script src="js/main.js"></script>

    <title>Hello, world!</title>
</head>
<body style="padding: 0;height: 100%;">

<?php
$user_location = "about";
include_once 'nav.php';
?>
<img class="about_image" src="images/About-us.jpg">
<div class="about_body">
    <div class="about_tab container">
        <div class="row">
            <div class="about_history col-md">
                <h1>Our History</h1>
                <p>Launched in 1995 under the direction of CSO percussionist Patricia Dash and Douglas Waddell, percussionist with Lyric Opera of Chicago, the Percussion Scholarship Program offers intensive, individual, weekly percussion instruction on a full scholarship basis. Participating students, all Chicago residents in grades three through twelve, are selected for the group through a rigorous application and personal interview process.

                    As an ensemble, the Percussion Scholarship Group has had numerous compositions arranged especially for them by nationally known artists. The group has performed at the Percussive Arts Society International Convention, performs twice annually at Symphony Center and has appeared at Macy's Day of Music, DePaul University, the Chicago Cultural Center, on WTTW, on WGN and WFMT radio, and as soloists with members of the Chicago Symphony Orchestra as part of CSO Youth Concerts, the Kraft Family Matinee Series and Welcome Yule! Concerts.</p>
            </div>
            <div class="members_viewing col-md">
                <?php include 'meet_members_mess.php' ?>
                <h1>About the Directors</h1>
                <div class="container meet_directors">
                    <div class="row">
                        <div class="col">
                            <h1>

                                Patricia<br> Dash
                            </h1>
                            <p>
                                Patricia Dash was appointed to the Chicago Symphony Orchestra by Sir Georg Solti in 1986, when she was just twenty-four years old. Born in Rochester, New York, she began her percussion studies at the age of nine. She received a diploma with honors and a certificate of merit from the Eastman School of Music’s Preparatory Department in 1979, and went on to earn a Bachelor of Music degree with distinction from Eastman in 1983. Her teachers include John Beck, Ruth Cahn, Allen Otte, Richard Jenson, and Doug Howard. While in college, she performed as an extra with both the Rochester Philharmonic and the Cincinnati Symphony orchestras. Dash came to Chicago from the Florida Philharmonic Orchestra, where she held the position of principal percussionist. Since coming to Chicago, she has become an active chamber musician, performing with Chicago Chamber Musicians, the Chicago Pro Musica, the CSO Trombone Ensemble, the Ensemble Inter Contemporain of Paris, and in numerous Chicago Symphony chamber music concerts at Orchestra Hall. She has been soloist with Symphony of the Shores, Elmhurst Symphony Orchestra, Palatine Band and DuPage Symphony.

                            </p>
                        </div>
                        <div class="col">
                            <h1>
                                Douglas <br> Waddell
                            </h1>
                            <p>
                                A member of the Grant Park Symphony and the Chicago Lyric Opera Orchestra, Douglas Waddell is constantly in demand as Chicago’s most versatile and virtuosic percussionist. He has been timpanist with the renowned Music of the Baroque ensemble since 1983, and as a member of the Contemporary Chamber Players of Chicago has performed and recorded a wide variety of 20th century chamber works. Mr. Waddell has performed throughout the United States, Europe and Japan with the Chicago Symphony Orchestra and can be heard all over the world on hundreds of television and radio commercial jingles. He has appeared as soloist with the Grant Park Symphony, Symphony of the Shores and the Contemporary Chamber Players of Chicago. A native of South Bend, Indiana, Mr. Waddell holds Bachelor and Master of Music Degrees from DePaul University.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

</body>
</html>