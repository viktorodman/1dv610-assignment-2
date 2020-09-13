<?php

namespace Model;

class Username {
    private static $usernameToShortMessage = 'Username has too few characters, at least 3 characters.';
    private $username;

    public function __construct(string $username) {
        if (mb_strlen($username) < 3) {
            throw new \Exception(self::$usernameToShortMessage);
        }
        $this->username = $username;
    }


}