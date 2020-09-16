<?php

namespace Model;

class User {

    private static $username = "Admin";
    private static $password = "Password";
    private static $errorMessage = "Wrong name or password";

   
    // Will later return a User
    public static function authenticateUser(\Model\Credentials $userCredentials) {
        if (User::userExists($userCredentials->getUsername())) {
            if ($userCredentials->getPassword() == self::$password) {
                return self::$username;
            } else {
                throw new \Exception(self::$errorMessage);
            }
        } else {
            throw new \Exception(self::$errorMessage);
        }

    }

    // This function will return a User
    private static function userExists(string $username) : bool {
        // TEMP CODE | Will call DB and check for user
        return $username == self::$username;
    }



}