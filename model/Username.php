<?php

namespace Model;

class Username {
    private $username;

    public function __construct(string $username) {
        $this->username = $username;
    }
}