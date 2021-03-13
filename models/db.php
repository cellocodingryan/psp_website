<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 6/15/2018
 * Time: 11:52 AM
 */

require(pathinfo(__FILE__, PATHINFO_DIRNAME)."/../config/passwords.php");


class db {
    private function __construct() {
//        echo ("???$3");
        $this->db = new mysqli(
            getenv('dbservername'),
            getenv('dbusernname'),
            getenv('dbpassword'),
            getenv('dbName')
        );
    }
    public static function getdb() {
//        echo ("xx");
        if (!isset(self::$instance)){
            self::$instance = new db();
        }
        return self::$instance->db;
    }
    public static $instance;
    public $db;
}
