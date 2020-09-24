<?php

namespace Model\DAL;

class Database {
    private $connection;


    public function __construct() {
        $url = getenv('JAWSDB_URL');
         
        $dbparts = parse_url($url);
        // FÅR KANSKE GÖRA EN DATABAS CLASS OCH Använda den För komma åt USERS OCH COOKIE STRINGS

        $hostname = $dbparts['host'];
        $username = $dbparts['user'];
        $password = $dbparts['pass'];
        $database = ltrim($dbparts['path'],'/');
        // Create connection
        $this->connection = new \mysqli($hostname, $username, $password, $database);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        } 
    }

    public function getConnection() : \mysqli {
        return $this->connection;
    }
}