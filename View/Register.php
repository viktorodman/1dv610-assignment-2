<?php

namespace View;

require_once('model/Username.php');
require_once('model/Password.php');
require_once('model/Credentials.php');

class Register {
    private static $registerURLID = 'register';
    private static $messageID = 'RegisterView::Message';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $name = 'RegisterView::UserName';
    private static $register = 'RegisterView::Register';
    private static $passwordToShortMessage = 'Password has too few characters, at least 6 characters.';
    private static $usernameToShortMessage = 'Username has too few characters, at least 3 characters.';
    private static $passwordDoesNotMatchMessage = 'Passwords do not match.';
    
    private static $errorMessageSessionIndex = "RegisterView::errorMessageSessionIndex";
    private static $rememberedUserSessionIndex = "RegisterView::rememberedUserSessionIndex";
    
    private $errorMessageWasSetAndShouldNotBeRemovedDuringThisRequest = false;
    private $usernameWasSetAndShouldNotBeRemovedDuringThisRequest = false;
    

    public function response() {
        $remeberedUsername = $this->getRememberedSessionVariable($this->usernameWasSetAndShouldNotBeRemovedDuringThisRequest, self::$rememberedUserSessionIndex);
        $errorMessage = $this->getRememberedSessionVariable($this->errorMessageWasSetAndShouldNotBeRemovedDuringThisRequest, self::$errorMessageSessionIndex);
        
        return $this->generateRegisterFormHTML($errorMessage, $remeberedUsername);
    }

    public function userWantsToRegister() : bool {
        return isset($_POST[self::$register]);
    }

    public function getRegisterCredentials() {
        if(strlen($_POST[self::$name]) < 3 and strlen($_POST[self::$password]) < 6) {
            throw new \Exception(self::$usernameToShortMessage . '<br>' . self::$passwordToShortMessage);
        }

        return new \Model\Credentials($this->getUsername(), $this->getPassword());
    }


    public function reloadPageAndShowErrorMessage(string $errorMessage) {
		$_SESSION[self::$errorMessageSessionIndex] = $errorMessage;
        $_SESSION[self::$rememberedUserSessionIndex] = $_POST[self::$name];
        

		$this->errorMessageWasSetAndShouldNotBeRemovedDuringThisRequest = true;
		$this->usernameWasSetAndShouldNotBeRemovedDuringThisRequest = true;
		
		header('Location: /?register');
	}

    private function getUsername() : \Model\Username {
        if (strlen($_POST[self::$name]) < 3) {
            throw new \Exception(self::$usernameToShortMessage);
        }
        return new \Model\Username($_POST[self::$name]);
    }


    private function getPassword() : \Model\Password {
        if (strlen($_POST[self::$password]) < 6) {
            throw new \Exception(self::$passwordToShortMessage);
        }
        if ($_POST[self::$password] !== $_POST[self::$passwordRepeat]) {
            throw new \Exception(self::$passwordDoesNotMatchMessage);
        }

        return new \Model\Password($_POST[self::$password]);
    }

    private function generateRegisterFormHTML($errorMessage, $remeberedUsername) {
        return '
        <h2>Register new user</h2>
        <form action="?' . self::$registerURLID .'" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>Register a new user - Write username and password</legend>
                <p id="'. self::$messageID .'">' . $errorMessage . '</p>
                <label for="'. self::$name .'" >Username :</label>
                <input type="text" size="20" name="'. self::$name .'" id="'. self::$name .'" value="'. $remeberedUsername .'" />
                <br/>
                <label for="'. self::$password .'" >Password  :</label>
                <input type="password" size="20" name="'. self::$password .'" id="'. self::$password .'" value="" />
                <br/>
                <label for="'. self::$passwordRepeat .'" >Repeat password  :</label>
                <input type="password" size="20" name="'. self::$passwordRepeat .'" id="'. self::$passwordRepeat .'" value="" />
                <br/>
                <input id="submit" type="submit" name="'. self::$register .'"  value="Register" />
                <br/>
            </fieldset>
        </form>';
    }

    private function getRememberedSessionVariable(bool $variableWasSet, string $variableSessionIndex) {
		if ($variableWasSet) {
            return filter_var($_SESSION[$variableSessionIndex], FILTER_SANITIZE_STRING);
        }

        if(isset($_SESSION[$variableSessionIndex])) {
            $message = filter_var($_SESSION[$variableSessionIndex], FILTER_SANITIZE_STRING);
            unset($_SESSION[$variableSessionIndex]);
            return $message;
        }
        return "";
	}

}