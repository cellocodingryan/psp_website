<?php


class flash
{

    public function __construct()
    {
        if (isset($_SESSION['flash_primary'])) {
            $this->primary = $_SESSION['flash_primary'];
        } else {
            $this->primary = array();
        }
        if (isset($_SESSION['flash_secondary'])) {
            $this->secondary = $_SESSION['flash_secondary'];
        } else {
            $this->secondary = array();
        }
        if (isset($_SESSION['flash_success'])) {
            $this->success = $_SESSION['flash_success'];
        } else {
            $this->success = array();
        }
        if (isset($_SESSION['flash_danger'])) {
            $this->danger = $_SESSION['flash_danger'];
        } else {
            $this->danger = array();
        }
        if (isset($_SESSION['flash_warning'])) {
            $this->warning = $_SESSION['flash_warning'];
        } else {
            $this->warning = array();
        }
        if (isset($_SESSION['flash_info'])) {
            $this->info = $_SESSION['flash_info'];
        } else {
            $this->info = array();
        }
    }

    public function add_primary($msg) {
        $this->primary[] = $msg;
        $_SESSION['flash_primary'] = $this->primary;
    }
    public function add_secondary($msg) {
        $this->secondary[] = $msg;
        $_SESSION['flash_secondary'] = $this->secondary;
    }
    public function add_success($msg) {
        $this->success[] = $msg;
        $_SESSION['flash_success'] = $this->success;
    }
    public function add_danger($msg) {
        $this->danger[] = $msg;
        $_SESSION['flash_danger'] = $this->danger;
    }
    public function add_warning($msg) {
        $this->warning[] = $msg;
        $_SESSION['flash_warning'] = $this->warning;
    }
    public function add_info($msg) {
        $this->info[] = $msg;
        $_SESSION['flash_info'] = $this->info;
    }
    
    public function get_next_primary() {
        return count($this->primary) > 0 ? array_shift($this->primary) : false;
    }
    public function get_next_secondary() {
        return count($this->secondary) > 0 ? array_shift($this->secondary) : false;
    }
    public function get_next_success() {
        return count($this->success) > 0 ? array_shift($this->success) : false;
    }
    public function get_next_danger() {
        return count($this->danger) > 0 ? array_shift($this->danger) : false;
    }
    public function get_next_warning() {
        return count($this->warning) > 0 ? array_shift($this->warning) : false;
    }
    public function get_next_info() {
        return count($this->info) > 0 ? array_shift($this->info) : false;
    }
    public function get_all_primary() {
        return $this->primary;
    }
    public function get_all_secondary() {
        return $this->secondary;
    }
    public function get_all_success() {
        return $this->success;
    }
    public function get_all_danger() {
        return $this->danger;
    }
    public function get_all_warning() {
        return $this->warning;
    }
    public function get_all_info() {
        return $this->info;
    }
    
    public function clear() {
        unset($_SESSION['flash_primary']);
        unset($_SESSION['flash_secondary']);
        unset($_SESSION['flash_success']);
        unset($_SESSION['flash_danger']);
        unset($_SESSION['flash_warning']);
        unset($_SESSION['flash_info']);
    }
    

    private $primary;
    private $secondary;
    private $success;
    private $danger;
    private $warning;
    private $info;
}