<?php

namespace Controller;


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
            } catch (\Throwable $error) {
                $this->loginView->showErrorMessage($error->getMessage());
            }
            
        }
    }

}