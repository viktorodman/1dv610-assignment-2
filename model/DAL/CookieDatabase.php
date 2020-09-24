<?php

namespace Model\DAL;

class CookieDatabase {
    private static $tableName = "cookies";

    private $hostname;
    private $username;
    private $password;
    private $database;
    private $connection;
    public function __construct(\mysqli $dbConnection) {
        $url = getenv('JAWSDB_URL');
         
        $dbparts = parse_url($url);
        // FÅR KANSKE GÖRA EN DATABAS CLASS OCH Använda den För komma åt USERS OCH COOKIE STRINGS

        $this->hostname = $dbparts['host'];
        $this->username = $dbparts['user'];
        $this->password = $dbparts['pass'];
        $this->database = ltrim($dbparts['path'],'/');
        $this->connection = $dbConnection; 
        // Create connection
        /* $this->connection = new \mysqli($hostname, $username, $password, $database); */
        $this->createCookieTableIfNeeded();
    }

    public function saveCookieInformation(string $cookieUsername, string $cookiePassword, int $cookieDuration) {
        $connection = new \mysqli($this->hostname, $this->username, $this->password, $this->database);
        if ($this->userCookieExists($cookieUsername)) {
            $this->updateAndSaveCookieInfo($cookieUsername, $cookiePassword, $cookieDuration);
        } else {
            $this->saveCookie($cookieUsername, $cookiePassword, $cookieDuration);
        }
    }

    

    public function cookiesAreValid($cookieUsername, $cookiePassword) : bool {
        if ($this->passwordIsValid($cookieUsername, $cookiePassword) && $this->cookieIsNotExpired($cookieUsername)) {
            return true;
        }

        return false;
    }

    private function saveCookie(string $cookieUsername, string $cookiePassword, int $cookieDuration) {
        $connection = new \mysqli($this->hostname, $this->username, $this->password, $this->database);

        $query = "INSERT INTO " . self::$tableName . " (cookieuser, cookiepassword, expiredate) VALUES
            ('". $cookieUsername ."', '". $cookiePassword ."', '". $cookieDuration ."')";

          $connection->query($query);
    }

    private function userCookieExists(string $cookieUsername) : bool {
       
        $connection = new \mysqli($this->hostname, $this->username, $this->password, $this->database);

        $query = "SELECT * FROM " . self::$tableName . " WHERE cookieuser LIKE BINARY '". $cookieUsername ."'";
        $userExists = 0;
        
        if($stmt = $connection->prepare($query)) {

            
            $stmt->execute();
        
            $stmt->store_result();

            
            
    
            $userExists = $stmt->num_rows;
            $stmt->close();
        }

        
        /* $stmt = $connection>prepare($query) */

        
       
        return $userExists == 1;
    }

    private function updateAndSaveCookieInfo(string $username, string $password, int $duration) {
        $connection = new \mysqli($this->hostname, $this->username, $this->password, $this->database);

        $query = "UPDATE " . self::$tableName . " SET cookiepassword='". $password ."', expiredate='". $duration ."' WHERE cookieuser='". $username ."'";
        
        $connection->query($query);
        
    }

    private function passwordIsValid(string $cookieUsername, string $cookiePassword) : bool {
        $connection = new \mysqli($this->hostname, $this->username, $this->password, $this->database);

        $query = "SELECT cookiepassword FROM " . self::$tableName . " WHERE cookieuser LIKE BINARY '". $cookieUsername ."'";
        $savedPassword = $connection->query($query);

        return $savedPassword === $cookiePassword; 
    }

    private function cookieIsNotExpired(string $cookieUsername) : bool {
        $connection = new \mysqli($this->hostname, $this->username, $this->password, $this->database);

        $query = "SELECT expiredate FROM " . self::$tableName . " WHERE cookieuser LIKE BINARY '". $cookieUsername ."'";
        $cookieExpiredate = $connection->query($query);

        if ($cookieExpiredate < time()) {
            throw new \Exception("Wrong information in cookies");
        }


        return true;
    }


    private function createCookieTableIfNeeded() {
        $connection = new \mysqli($this->hostname, $this->username, $this->password, $this->database);

        $createTable = "CREATE TABLE IF NOT EXISTS " . self::$tableName . " (
            cookieuser VARCHAR(30) NOT NULL UNIQUE,
            cookiepassword VARCHAR(250) NOT NULL,
            expiredate int(250)
            )";

            $connection->query($createTable);
           
    }
}