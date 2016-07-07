<?php

namespace jaf\mysql;

class MySQLConfiguration {
    public $host = ''; 
    public $port = 0;
    public $username = ''; 
    public $password = ''; 
    public $database = ''; 

    public function __construct($host, $port, $username, $password, $database) { 
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }   

}
