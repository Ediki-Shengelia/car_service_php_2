<?php

$echo = date_default_timezone_set("Asia/Tbilisi");


require_once __DIR__ . '/../includes/config.php';

class Database
{
    public $connection;
    public function __construct()
    {
        $this->open_db_connection();
    }
    public function open_db_connection()
    {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        if ($this->connection->connect_errno) {
            die("Database Connection Failed Badly " . $this->connection->connect_error);
        }
    }
    public function escape_string($string)
    {
        return $this->connection->real_escape_string($string);
    }
    public function query($sql)
    {
        $result = $this->connection->query($sql);
        if (!$result) {
            die("Query Failed");
        }
        return $result;
    }
    public function the_insert_id()
    {
        return mysqli_insert_id($this->connection);
    }
}


$database = new Database();
