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
        if (!$result) {
            return;
        }
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
        $user = new user($id,"id");
        return $user->username != null ? $user : false;
    }
    public static function get_by_uid($uid) {
        $user = new user($uid, "usernameemail");
        return $user->username != null ? $user : false;
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
    public static function create_account($username, $email, $firstname,$lastname,
                                          $password,$password_confirm) {
        $db = db::getdb();
        $username = mysqli_real_escape_string($db,$username);
        $email = mysqli_real_escape_string($db,$email);
        $firstname = mysqli_real_escape_string($db,$firstname);
        $lastname = mysqli_real_escape_string($db,$lastname);
        $password = mysqli_real_escape_string($db,$password);
        $password_confirm = mysqli_real_escape_string($db,$password_confirm);

        $existing_user = user::get_by_uid($username);
        if (!$existing_user) {
            $existing_user = user::get_by_uid($email);
            if (!$existing_user) {
                if ($password_confirm == $password) {
                    $hashedPwd = password_hash($password, PASSWORD_BCRYPT);
//            insert the user into the database
                    $sql = "INSERT INTO users (user_first, user_last, user_email, user_email_all, user_phone, user_uid, user_pwd, address, family, user_rank) VALUES ('$firstname', '$lastname', '$email', '[$email]', '[]', '$username', '$hashedPwd', '', '', '0');";
                    $res = mysqli_query($db,$sql);
                    if (!$res) {
                        user::seterror(mysqli_error($db));
                        return false;
                    }
                    return true;
                }
                user::seterror("passwords do not match");
                return false;
            }
        }
        user::seterror("A user with that username already exists");
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
    private function seterr($err) {
        user::$error = $err;
    }
    private static function seterror($err) {
        user::$error = $err;
    }

    public static function geterr() {
        $err = user::$error;
        user::$error = "";
        return $err;
    }
    private $username = null;
    private $password = null;
    private $id= null;
    private static $error = "";
    private $firstname= null;
    private $lastname= null;
    private $email= null;
    private $emails= null;
    private $phones= null;
    private $rank= null;
    private $found = false;
    private $logged_in;

}