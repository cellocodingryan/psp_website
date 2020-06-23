<?php

require_once 'includes/dbh-inc.php';
class user
{

    /**
     * @var mixed|string
     */


    private function __construct($id,$way)
    {
        $id = mysqli_real_escape_string(db::getdb(), $id);
        $sql = null;
        if ($way == "id") {
            $sql = "SELECT * FROM users WHERE user_id=$id";
        } else if ($way == "usernameemail") {
            $sql = "SELECT * FROM users WHERE user_uid='$id' OR user_email='$id'";
        } else {
            die("Something went wrong");
        }
        $result = mysqli_query(db::getdb(), $sql);
        $this->logged_in = false;
        if (mysqli_num_rows($result) < 1) {
            return;
        } else if (mysqli_num_rows($result) > 1) {
            throw new \http\Exception\RuntimeException("DB ERROR -1");
        }

        if ($row = mysqli_fetch_assoc($result)) {

            $this->id = $row['user_id'];
            $this->firstname = $row['user_first'];
            $this->lastname = $row['user_last'];
            $this->email = $row['user_email'];
            $this->emails = $row['user_email_all'];
            $this->username = $row['user_uid'];
            $this->rank = $row['user_rank'];
            $this->password = $row['user_pwd'];
            $this->found = true;
        }


    }
    public static function get_by_id($id) {
        return new user($id,"id");
    }
    public static function get_by_uid($uid) {
        return new user($uid, "usernameemail");
    }

    /**
     * @param $id
     * @param $pass
     * @return bool|user
     */
    public static function login($id,$pass) {
        $user = user::get_by_uid($id);
        if ($user->found) {
            $hashedPwdCheck = password_verify($pass, $user->password);
            if ($hashedPwdCheck) {
                $user->logged_in = true;
                $user->password = null;
                $_SESSION['user'] = $user;
                return $user;
            }
            return false;
        }
        return false;
    }
    public static function logout() {
        unset($_SESSION['user']);
    }
    public static function get_current_user() {
        if (!isset($_SESSION['user'])) {
            return null;
        }
        if ($_SESSION['user'] == null) {
            return null;
        }
        return $_SESSION['user'];
    }
    public static function is_logged_in() {
        if (!isset($_SESSION['user'])) {
            return false;
        }
        if ($_SESSION['user'] == null) {
            return false;
        }
        return $_SESSION['user']->getloggedin();
    }
    public function getloggedin() {
        return $this->logged_in ? true:false;
    }
    public function get_firstname() {
        return $this->firstname;
    }
    private $username = null;
    private $password = null;
    private $id= null;
    private $firstname= null;
    private $lastname= null;
    private $email= null;
    private $emails= null;
    private $phones= null;
    private $rank= null;
    private $found = false;
    private $logged_in;

}