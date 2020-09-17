<?php

namespace Model\DAL;

class UserDatabase {
    private static $tableName = "Users";
    private static $rowUsername = "username";
    private static $rowPassword = "password";
    private $connection;

    public function connect() {
         $url = getenv('JAWSDB_URL');
         $dbparts = parse_url($url);

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

         $this->createUserTableIfNeeded();
    }

    public function addUser(\Model\User $user) { 
        $this->createUserTableIfNeeded();
        // Check if user already exists
        $username = $user->getCredentials()->getUsername();
        $password = $user->getCredentials()->getPassword();

        if($this->userExists($username)) {
            echo "User exists";
        } else {
            echo "Adding User";
            $hash = $this->hashPassword($password);
            $query = "INSERT INTO " . self::$tableName . " (username, password) VALUES ('". $username ."', '". $password ."')";
            $this->connection->query($query);
        }
    }

    public function loginUser(\Model\User $user) {
        $username = $user->getCredentials()->getUsername();
        $password = $user->getCredentials()->getPassword();

        if ($this->userExists($username)) {
            if ($this->passwordIsCorrect($username, $password)) {
                echo "TJOHO";
            } else {
                echo "attans";
            }
        }
    }

    private function hashPassword(string $password) : string {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private function passwordIsCorrect(string $username, string $password) : bool {
        $query = "SELECT ". self::$rowPassword ." FROM " . self::$tableName . " WHERE username LIKE '". $username ."'";
        
        $stmt = $this->connection->query($query);
        $stmt = \mysqli_fetch_row($stmt);


        return \password_verify($password, $stmt[0]);
    }


    private function userExists(string $username) : bool {
        $query = "SELECT * FROM " . self::$tableName . " WHERE username LIKE '". $username ."'";
        $userExists = 0;
        
        if($stmt = $this->connection->prepare($query)) {
            $stmt->execute();
        
            $stmt->store_result();
    
            $userExists = $stmt->num_rows;
    
            $stmt->close();
        }
        
       
        return $userExists == 1;
    }

    private function createUserTableIfNeeded() {
        $createTable = "CREATE TABLE IF NOT EXISTS " . self::$tableName . " (
            username VARCHAR(30) NOT NULL UNIQUE,
            password VARCHAR(60) NOT NULL
            )";

        if($this->connection->query($createTable)) {
           // Add message
        } else {
            // Add error message
        }
    }
}