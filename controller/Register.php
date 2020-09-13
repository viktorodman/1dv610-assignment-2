<?php

namespace Controller;

class Register {
    
    private $registerView;

    public function __construct(\View\Register $registerView) {
        $this->registerView = $registerView;
    }

    public function doRegister() {
        if ($this->registerView->userWantsToRegister()) {
            try {
                $userCredentials = $this->registerView->getRegisterCredentials();
            } catch (\Throwable $error) {
                $this->registerView->showErrorMessage($error->getMessage());
            }


           /*  if ($this->registerView->checkAllFieldsFilled()) {
                // Try to register a user
            } else {
                $this->registerView->showErrorMessage();
            } */
            
        }
        
    }
}