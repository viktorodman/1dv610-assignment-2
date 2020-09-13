<?php

namespace Model;

class Credentials {
    private $username;
    private $password;

    public function __construct(\Model\Username $username, \Model\Password $password) {
       

        $this->username = $username;
        $this->password = $password;
    }
}