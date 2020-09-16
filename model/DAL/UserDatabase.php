<?php

namespace Model\DAL;

class UserDatabase {
    public function __construct() {

        /* $url = getenv('JAWSDB_URL'); */
        $dbparts = parse_url();

        $hostname = $dbparts['host'];
        $username = $dbparts['user'];
        $password = $dbparts['pass'];
        $database = ltrim($dbparts['path'],'/');
        // Create connection
        $conn = new \mysqli($hostname, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $sql = "CREATE TABLE IF NOT EXISTS $table (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL
            )";
        echo "Connection was successfully established!";
    }
}