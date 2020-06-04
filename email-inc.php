<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
@session_start();
//Load Composer's autoloader
require 'vendor/autoload.php';
include_once '../includes/dbh-inc.php';
function send_mail($send_to_who,$subject,$message,$attach = "none") {
    $debug = [[],[]];
    $email_cc = json_decode($_SESSION['u_emails']);
    array_push($send_to_who,$_SESSION['u_id']);

    //send to self

    foreach ($send_to_who as $item) {


        $name = $_SESSION['u_first'] . " " . $_SESSION['u_last'];
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            $count = 0;
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = getenv('mailhost');  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = getenv('mailusername');                 // SMTP username
            $mail->Password = getenv('mailpassword');                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $sql = "SELECT * FROM users WHERE user_id='$item'";
            $result = $GLOBALS["conn"]->query($sql);
            $row = $result->fetch_assoc();

            $email_to_send = json_decode($row['user_email_all']);
            foreach ($email_to_send as $email) {
                ++$count;

                $mail->addAddress($email);
            }
            $mail->setFrom(getenv('mailusername'), $name);



            foreach ($email_cc as $item2) {
                $mail->addReplyTo($item2, $name);
            }



            //Attachments
            if ($attach != "none") {
                $mail->addAttachment($attach);
            }
            // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(false);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            array_push($debug[0],$row['user_first'] . " " . $row['user_last'] . "(" . $count . " emails for this person)");
        } catch (Exception $e) {
            $sql = "SELECT * FROM users WHERE user_id='$item'";
            $result = $GLOBALS["conn"]->query($sql);
            $row = $result->fetch_assoc();
            array_push($debug[1],$row['user_first'] . " " . $row['user_last'] . "(" . $count . " email(s) for this person)" . " ERROR: <br>" . $e);

//            array_push($errors,$e);
        }



    }

    add_stat("sent email (debug)". $debug,$_SESSION['u_id']);
    return $debug;
}