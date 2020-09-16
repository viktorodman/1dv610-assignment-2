<?php

namespace Controller;

require_once('model/User.php');

class Login {

    private $loginView;

    public function __construct(\View\Login $loginView) {
        $this->loginView = $loginView;
    }

    public function doLogin() {
        if ($this->loginView->userWantsToLogin()) {
            try {
                // Get Credentials
                $userCredentials = $this->loginView->getCredentials();
                // TEMP now returs a string but should return a user
                $user = \Model\User::authenticateUser($userCredentials);
            } catch (\Throwable $error) {
                $this->loginView->showErrorMessage($error->getMessage());
            }
            
        }
    }

}