<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require_once 'vendor/autoload.php';
require_once 'user.php';
class email
{
    /**
     * email constructor.
     * email ids is the actual user object not just id didn't want to change the name after changing that
     * @param $email_ids
     * @param $subject
     * @param $content
     */
    public function __construct($email_ids,$subject,$content)
    {
        foreach ($email_ids as $e) {
            $this->email_ids[] = $e;
        }
        $this->subject = $subject;
        $this->content = $content;
    }
    public function add_attachment($attachment) {
        define('KB', 1024);
        define('MB', 1048576);
        define('GB', 1073741824);
        define('TB', 1099511627776);
        if (filesize(getenv("filelocation_prefix")."email_attach/".$attachment) < 10000000) {

            $this->attachment = getenv("filelocation_prefix")."email_attach/".$attachment;
        }
        $url = getenv("url")."/fileserver.php?folder=email_attach&file=".$attachment;
        $this->content .= "<br><br>Attachment Link <a href='$url'>Click here</a>";

    }
    public function send_email() {
        foreach($this->email_ids as $id) {
            $this->send($id);
        }
    }
    private function send($id) {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = getenv("mailhost");
            $mail->SMTPAuth = true;
            $mail->Username = getenv("mailusername");
            $mail->Password = getenv("mailpassword");
            $mail->SMTPSecure = 'ssl';
            $mail->Port = getenv("mailport");

            $emails = $id->get_all_emails();
            foreach ($emails as $e) {
                $mail->addAddress($e);
            }
            $mail->setFrom('new-info@percussionscholars.com', "PSP Website");
            if (user::is_logged_in()) {
                $replytoemails = user::get_current_user()->get_all_emails();
                foreach ($replytoemails as $e) {
                    $mail->addReplyTo($e);

                }
            }
            if ($this->attachment != null) {
                $mail->addAttachment($this->attachment);
            }
            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body = $this->content;
            $mail->send();

        } catch (Exception $e) {
            error_log($e);
            $this->failed_emails[] = $id->get_firstname() . " " . $id->get_lastname();
        }
    }
    public $failed_emails = array();
    private $subject;
    private $content;
    private $attachment = null;
    private $email_ids;
}