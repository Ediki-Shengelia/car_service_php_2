<?php

class Session
{
    public $signed_in = false;
    public $user_id;
    public $message;
    public function __construct()
    {
        session_start();
        $this->check_the_login();
    }
    public function login($user)
    {
        if ($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }
    public function check_the_login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else {
            $this->signed_in = false;
            unset($this->user_id);
        }
    }
    public function get_user_id()
    {
        return $_SESSION['user_id'];
    }
    public function is_signed_in()
    {
        return $this->signed_in;
    }
    public function message($msg = "")
    {
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            $this->message = "";
        }
    }
    public function check_the_message()
    {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }
}


$session = new Session();
