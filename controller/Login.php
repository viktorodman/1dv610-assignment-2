<?php

namespace Controller;

require_once('model/User.php');


class Login {

    private $loginView;
    private $userDatabase;

    public function __construct(\View\Login $loginView, \Model\DAL\UserDatabase $userDB) {
        $this->loginView = $loginView;
        $this->userDatabase = $userDB;
    }

    public function doLogin() {
        if ($this->loginView->userWantsToLogin()) {
            try {
                // Get Credentials

                $userCredentials = $this->loginView->getRequestUserCredentials();

                $user = new \Model\User($userCredentials);
                // TEMP now returs a string but should return a user
                $this->userDatabase->loginUser($user);
            } catch (\Throwable $error) {
                $this->loginView->reloadPageAndShowErrorMessage($error->getMessage());
            }
            
        }
    }

}