<?php

namespace Controller;

class Login {

    private $loginView;

    public function __construct(\View\Login $loginView) {
        $this->loginView = $loginView;
    }

    public function doLogin() {
        if ($this->loginView->userWantsToLogin()) {
            if ($this->loginView->userEnteredAllFields()) {
                // Try to login user with credentials
            } else {
                // Set error message in view
                $this->loginView->setErrorMessage();
            }
        }
    }

}