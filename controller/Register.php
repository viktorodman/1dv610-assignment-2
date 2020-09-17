<?php

namespace Controller;

require_once('model/User.php');

class Register {
    
    private $registerView;
    private $userDatabase;

    public function __construct(\View\Register $registerView, \Model\DAL\UserDatabase $userDB) {
        $this->registerView = $registerView;
        $this->userDatabase= $userDB;
    }

    public function doRegister() {
        if ($this->registerView->userWantsToRegister()) {
            try {
                $userCredentials = $this->registerView->getRegisterCredentials();
                $user = new \Model\User($userCredentials);
                $this->userDatabase->addUser($user);
                header('Location: index.php?');
                //  Try to register user on database
            } catch (\Throwable $error) {
                $this->registerView->showErrorMessage($error->getMessage());
            }
        }
        
    }
}