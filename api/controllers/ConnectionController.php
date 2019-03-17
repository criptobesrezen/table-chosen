<?php

class connection
{
    private $host;
    private $user;
    private $password;
    private $db_name;
    private $link;

    public function __construct()
    {
        require 'connection.php';
        $this->host     = DB_HOST;
        $this->db_name  = DB_NAME;
        $this->user     = DB_USER;
        $this->password = DB_PASSWORD;
    }

    public function open() {
        $this->link = mysqli_connect($this->host, $this->user, $this->password, $this->db_name);
        $this->link->set_charset('utf8');
        return $this->link;
    }
}