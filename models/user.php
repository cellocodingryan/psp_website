<?php

require_once 'models/db.php';
require_once 'models/response.php';
require_once 'models/flash.php';

class user
{



    private function __construct($id,$way)
    {
        $sql = null;
        if ($way == "id") {
            $id = mysqli_real_escape_string(db::getdb(), $id);
            $sql = "SELECT * FROM users WHERE user_id='$id'";
        } else if ($way == "usernameemail") {
            $id = mysqli_real_escape_string(db::getdb(), $id);
            $sql = "SELECT * FROM users WHERE user_uid='$id' OR user_email='$id'";
        } else if ($way == "prequery") {
            $row = $id;
            $this->id = $row['user_id'];
            $this->user_first = $row['user_first'];
            $this->lastname = $row['user_last'];
            $this->email = $row['user_email'];
            $this->emails = $row['user_email_all'];
            $this->address = $row['address'];
            $this->username = $row['user_uid'];
            $this->phones = $row['user_phone'];
            $this->rank = $row['user_rank'];
            $this->password = $row['user_pwd'];
            $this->found = true;
            return;
        }
        else {
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
            $this->user_first = $row['user_first'];
            $this->lastname = $row['user_last'];
            $this->email = $row['user_email'];
            $this->emails = $row['user_email_all'];
            $this->address = $row['address'];
            $this->username = $row['user_uid'];
            $this->phones = $row['user_phone'];
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
    public static function get_by_prequery($row) {
        $user = new user($row, "prequery");
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
            if ($hashedPwdCheck or $user->verify_password_reset_code($pass)) {
                $user->logged_in = true;
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

    public function set_firstname($firstname) {
        $this->set_val("user_first",$firstname);
        $this->user_first = $firstname;
    }
    public function set_lastname($lastname) {
        $this->set_val("user_last",$lastname);
        $this->lastname;
    }
    public function set_primary_email($email) {
        /*
         * determine if this email is in use
         */
        $testuser = user::get_by_uid($email);/

        if ($testuser->getid() == user::get_current_user()->getid()) {
            $emails = json_decode($this->emails);
            $emails[0] = $email;
            $this->email = $emails[0];
            $this->emails = json_encode($emails);
            $this->set_val("user_email_all",json_encode($emails));
            $this->set_val("user_email",$email);
            return true;
        } else {
            return false;
        }

    }
    public function set_emails($emails,$emailnum = -1) {
        $emails_ = json_decode($this->emails);
        if ($emailnum != -1) {
            if (count($emails_) <= $emailnum) {
//                return;
                $flash = new flash();
                $flash->add_danger("invalid");
                die(new response(401,"invalid (please refresh)"));
            }
            if ($emails == "" && $emailnum != 0) {
                array_splice($emails_, $emailnum, 1);
                $emailnum = -1;

            } else {

                if (in_array($emails,$emails_)) {
                    $flash = new flash();
                    $flash->add_danger("invalid");
                    die(new response(401,"invalid (please refresh)"));
                }

                $emails_[$emailnum] = $emails;
            }
        } else if ($emails != "") {
            if (in_array($emails,$emails_)) {

                $flash = new flash();
                $flash->add_danger("invalid");
                die(new response(401,"invalid (please refresh)"));
            }
            $emailnum = count($emails_);
            $emails_[] = $emails;
        }
        $this->emails = json_encode($emails_);
        $primary_email = json_decode($this->emails)[0];
        $this->set_primary_email($primary_email);
        return $emailnum;
    }
    public function set_phones($phones,$type,$phonenum = -1) {
        $phones_ = json_decode($this->phones);
        if ($phonenum == -1 || $phonenum >= count($phones_)) {
            $phones_[] = ["",""];
            $phonenum = count($phones_)-1;
        }
        if ($phonenum >= count($phones_)) {
            $flash = new flash();
            $flash->add_danger("invalid");
            die(new response(401,"invalid (please refresh)"));
        }

        $phones_[$phonenum][$type] = $phones;
        if ($phones_[$phonenum] == ["",""] && $phonenum != 0) {
            array_splice($phones_, $phonenum, 1);
        }
        $this->set_val("user_phone",json_encode($phones_));
        $this->phones = json_encode($phones_);
        return $phonenum;
    }

    public function set_address($value,$type) {
        $address = json_decode($this->address,true);
        if ($address == null) {
            $address = ["address_line_1"=>"","address_line_2"=>"","city"=>"","state"=>"","zipcode"=>""];
        }
        $address[$type] = $value;
        $this->address = json_encode($address);
        $this->set_val("address",json_encode($address));
    }
    public function get_address() {
        $address = json_decode($this->address,true);
        if ($address == null) {
            $address = ["address_line_1"=>"","address_line_2"=>"","city"=>"","state"=>"","zipcode"=>""];
        }
        return $address;
    }
    private function set_val($param,$value) {
        try {
            $db = db::getdb();
            $stmt = $db->prepare("UPDATE users SET `{$param}`=? WHERE user_id=?");
            if (!$stmt) {
                die (mysqli_error($db));
            }
            $stmt->bind_param("ss",$value, $this->id);
            $stmt->execute();
//            $this->{$$param} = $value;
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user']->getid() == $this->id) {
                    $this->logged_in = $_SESSION['user']->logged_in;
                    $_SESSION['user'] = $this;
                }
            }

        } catch (Exception $e) {
            echo mysqli_error($db);
            die($e);
        }
    }

    public static function logout() {
        unset($_SESSION['user']);
    }
    public static function auth($level_required="loggedin",$lastpage="index") {
        $user = self::get_current_user();

        if (user::is_logged_in()) {
            if ($level_required == "loggedin") {
                return true;
            }
            if ($user->has_rank($level_required)) {
                return true;
            }
        }

        header("Location: login.php?lastpage=$lastpage");
        exit();
    }
    public function change_password($password,$password_confirm) {
        if ($password != $password_confirm) {
            return false;
        }
        $this->set_val("user_pwd",password_hash($password,PASSWORD_BCRYPT));
        $this->password = password_hash($password,PASSWORD_BCRYPT);
        return true;

    }
    public function check_password($password) {
        return password_verify($password,$this->password);
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
        return $this->user_first;
    }
    public function get_lastname() {
        return $this->lastname;
    }
    public function get_email() {
        return $this->email;
    }
    public function get_username() {
        return $this->username;
    }
    public function has_rank($rank) {
        switch ($rank) {
            case "member":
                if ($this->rank == 1.00) {
                    return true;
                }
            case "alumni":
                if ($this->rank == 1.10) {
                    return true;
                }
            case "director":
                if ($this->rank == 2.00) {
                    return true;
                }
            case "admin":
                if ($this->rank == 3.00) {
                    return true;
                }
            default:
                return false;
        }
    }
    public function get_all_emails() {
        $email_decode = json_decode($this->emails);
        if (count($email_decode) == 0) {
            $email_decode[] = "";
        }
        return $email_decode;
    }
    public static function geterr() {
        $err = user::$error;
        user::$error = "";
        return $err;
    }

    public function getid() {
        return $this->id;
    }
    public function get_all_phones() {
        $phone_decode = json_decode($this->phones);
        if (count($phone_decode) == 0) {
            $phone_decode[] = "";
        }
        return $phone_decode;
    }

    public function set_rank($rank) {

        switch ($rank) {
            case "admin":
                $this->set_val("user_rank",3.00);
                break;
            case "member":
                $this->set_val("user_rank",1.00);
                break;
            case "director":
                $this->set_val("user_rank",2.00);
                break;
            case "alumni":
                $this->set_val("user_rank",1.10);
                break;
            default:
                $this->set_val("user_rank",0.0);
        }
    }

    public function reset_password_code($expire_time = 300) {
        $str=rand();
        $expire_time = time()+300;
        $code = md5($str);
        $db = db::getdb();
        $time = time();
        $db->query("DELETE FROM password_reset WHERE user_id = $this->id OR expire_time < $time");
//        error_log(mysqli_error($db));
        $hash = password_hash($code,PASSWORD_BCRYPT);
        $id=$this->id;
        $db->query("INSERT INTO password_reset (user_id,reset_code,expire_time) VALUES ($id,'$hash',$expire_time)");
        return $code;
    }
    public function verify_password_reset_code($reset_code) {
        $db = db::getdb();
        $time = time();
        $db->query("DELETE FROM password_reset WHERE expire_time < $time");
        $id=$this->id;

        $res = $db->query("SELECT * FROM password_reset WHERE user_id = $id");
        if ($res->num_rows == 0) {
            return false;
        }
        $code_verify = $res->fetch_assoc()['reset_code'];
        if (password_verify($reset_code,$code_verify)) {
            $db->query("DELETE FROM password_reset WHERE user_id = $this->id OR expire_time < $time");
            return true;
        }
        return false;
    }

    private function seterr($err) {
        user::$error = $err;
    }
    private static function seterror($err) {
        user::$error = $err;
    }


    private $username = null;
    private $password = null;
    private $id= null;
    private static $error = "";
    private $user_first= null;
    private $address = null;
    private $lastname= null;
    private $email= null;
    private $emails= null;
    private $phones= null;
    private $rank= null;
    private $found = false;
    private $logged_in;

}
if (!isset($_SESSION)) {

}