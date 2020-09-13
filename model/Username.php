<?php

namespace Model;

class Username {
    private static $usernameToShortMessage = 'Username has too few characters, at least 3 characters.';
    private $username;

    public function __construct(string $username) {
        if (strlen($username) < 3) {
            throw new \Exception(self::$usernameToShortMessage);
        }
        $this->username = $username;
    }


}