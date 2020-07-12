<?php
require_once 'models/user.php';
class navitem {
    public function __construct($name,$href)
    {
        $this->href = $href;
        $this->name = $name;

    }
    public function add_link($name,$href) {
        if ($this->navs == null) {
            $this->navs = array();

            $this->href = null;
            $this->group = true;
        }
        array_push($this->navs,new navitem($name,$href));
        return $this;
    }
    public function set_group_name($name) {
        $this->name = $name;
    }


    public $href;
    public $name;
    public $navs = null;
    public $group = false;
}

$public_nav = [
    new navitem("Home","index.php"),
    new navitem("Events","events.php"),
    new navitem("Performances","videos.php"),
    new navitem("FAQ","faq.php"),
    new navitem("About","about.php"),

];
if (user::is_logged_in()) {
    if (user::get_current_user()->has_rank("member")) {
        $public_nav[] = (new navitem("Members Area",null))->
        add_link("Click Tracks, Videos, & MP3","Instruction_Videos.php")->
        add_link("Contacts","contacts.php")->
        add_link("Mass Email","mass_email.php");
    }
    if (user::get_current_user()->has_rank("director")) {
        $public_nav[] = (new navitem("Admin",null))->add_link("Modify Users","modify_users.php");
    }


}

$msges = [];
$flash = new flash();

$login_nav = [
    new navitem("Log in","login.php"),
    new navitem("Create Account","create_account.php")
];
if (user::is_logged_in()) {
    $login_nav = [
        (new navitem("Welcome ".user::get_current_user()->get_firstname(),"#"))->add_link("Profile","profile.php")->add_link("Log out","logout.php")
    ];
}
$navvars = [
    "navitems"=>$public_nav,
    "loginnav"=>$login_nav,
    "msgs"=>[
        "success"=>$flash->get_all_success(),
        "secondary"=>$flash->get_all_secondary(),
        "primary"=>$flash->get_all_primary(),
        "danger"=>$flash->get_all_danger(),
        "warning"=>$flash->get_all_warning(),
        "info"=>$flash->get_all_info()
    ],
    "current"=>basename($_SERVER["SCRIPT_FILENAME"], '.php').".php"
];
$flash->clear();