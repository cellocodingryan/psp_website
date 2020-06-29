<?php


class response {
    public function __construct($status,$message)
    {
        $this->message = $message;
        $this->status = $status;
    }
    public function __toString()
    {
        return json_encode(["status"=>$this->status,"message"=>$this->message]);
    }

    private $status;
    private $message;
}