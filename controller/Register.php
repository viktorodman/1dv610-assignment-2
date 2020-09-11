<?php

namespace Controller;

class Register {
    
    private $registerView;

    public function __construct(\View\Register $registerView) {
        $this->registerView = $registerView;
    }

    public function doRegister() {
        if ($this->registerView->userWantsToRegister()) {
            // Try to register a user
            if ($this->registerView->checkAllFieldsFilled()) {
                
            } else {
                $this->registerView->showErrorMessage();
            }
            
        }
        
    }
}