<?php

namespace Model;

class Password {
    private $password;

    public function __construct(string $password) {
        $this->password = $password;
    }
}