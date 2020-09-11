<?php

namespace Model;

class User {

    private $userName;
    private $password;

    public function __construct(\Model\UserName $username, \Model\Password $password) {
        $this->userName = $userName;
        $this->password = $password;
    }

    public function registerUser() {
        //Todo add code to register a new user
    }
}