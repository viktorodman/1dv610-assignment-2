<?php

namespace Model;

class Login {
    private static $errorMessageNoUsername = 'Username is missing';
    private static $errorMessageNoPassword = 'Password is missing';

    public function __construct(\Model\Credentials $credentials) {
        
    }

}