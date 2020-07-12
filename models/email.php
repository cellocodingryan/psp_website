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
                error_log($e);
                $mail->addAddress($e);
            }
            $mail->setFrom('new-info@percussionscholars.com', "PSP Website");
            $replytoemails = user::get_current_user()->get_all_emails();
            foreach ($replytoemails as $e) {
                $mail->addReplyTo($e);
            }
            if ($this->attachment != null) {
                $mail->addAttachment($this->attachment);
            }
            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body = $this->content;

            $mail->send();

        } catch (phpmailerException $e) {

        }
    }
    private $subject;
    private $content;
    private $attachment = null;
    private $email_ids;
}