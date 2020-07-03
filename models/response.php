<?php


class response {
    public function __construct($status,$message)
    {
        $this->message = $message;
        $this->status = $status;
    }
    public function add_attr($name,$val) {
        $this->vals[$name] = $val;
    }
    public function __toString()
    {
        return json_encode(array_merge(["status"=>$this->status,"message"=>$this->message],$this->vals));
    }
    private $vals = [];
    private $status;
    private $message;
}