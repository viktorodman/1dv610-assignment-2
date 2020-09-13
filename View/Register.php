<?php

namespace View;

require_once('Model/Username.php');
require_once('Model/Password.php');
require_once('Model/Credentials.php');

class Register {
    private static $registerURLID = 'register';
    private static $messageID = 'RegisterView::Message';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $name = 'RegisterView::UserName';
    private static $register = 'DoRegistration';
    private static $passwordToShortMessage = 'Password has too few characters, at least 6 characters.';
    private static $usernameToShortMessage = 'Username has too few characters, at least 3 characters.';
    private static $passwordDoesNotMatch = 'Passwords do not match.';
    private $errorMessage = "";
    


    
    public function response() {
        return $this->generateRegisterFormHTML($this->errorMessage);
    }

    public function userWantsToRegister() : bool {
        return isset($_POST[self::$register]);
    }

    public function getRegisterCredentials() {
        if(mb_strlen($_POST[self::$name]) < 3 and mb_strlen($_POST[self::$password]) < 6) {
            throw new \Exception(self::$usernameToShortMessage . '<br>' . self::$passwordToShortMessage);
        }


        return new \Model\Credentials($this->getUsername(), $this->getPassword());
    }

    public function showErrorMessage(string $errorMessage) {
		$this->errorMessage = $errorMessage;
	}

    private function getUsername() : \Model\Username {
        if (mb_strlen($_POST[self::$name]) < 3) {
            throw new \Exception(self::$usernameToShortMessage);
        }
        return new \Model\Username($_POST[self::$name]);
    }
    private function getPassword() : \Model\Password {
        if (mb_strlen($_POST[self::$password]) < 6) {
            throw new \Exception(self::$passwordToShortMessage);
        }
        if ($_POST[self::$password] !== $_POST[self::$passwordRepeat]) {
            throw new \Exception(self::$passwordDoesNotMatch);
        }

        return new \Model\Password($_POST[self::$password]);
    }

    private function generateRegisterFormHTML($message) {
        return '
        <h2>Register new user</h2>
        <form action="?' . self::$registerURLID .'" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>Register a new user - Write username and password</legend>
                <p id="'. self::$messageID .'">' . $message . '</p>
                <label for="'. self::$name .'" >Username :</label>
                <input type="text" size="20" name="'. self::$name .'" id="'. self::$name .'" value="" />
                <br/>
                <label for="'. self::$password .'" >Password  :</label>
                <input type="password" size="20" name="'. self::$password .'" id="'. self::$password .'" value="" />
                <br/>
                <label for="'. self::$passwordRepeat .'" >Repeat password  :</label>
                <input type="password" size="20" name="'. self::$passwordRepeat .'" id="'. self::$passwordRepeat .'" value="" />
                <br/>
                <input id="submit" type="submit" name="'. self::$register .'"  value="register" />
                <br/>
            </fieldset>
        </form>';
    }

    /* public function showErrorMessage() {
        if (empty($_POST[self::$name]) and empty($_POST[self::$password]) and empty($_POST[self::$passwordRepeat])) {
            $this->errorMessage = self::$usernameToShortMessage . '<br>' . self::$passwordToShortMessage;
        } elseif (!empty($_POST[self::$name]) and empty($_POST[self::$password])) {
            $this->errorMessage = self::$passwordToShortMessage;
        }
    } */

    

   /*  public function getUsername() : \Model\Username {
        if (empty($_POST[self::$name])) {
            
        }
    } */

    /* public function checkAllFieldsFilled() : bool {
        return !empty($_POST[self::$name]) and !empty($_POST[self::$password]) and !empty($_POST[self::$passwordRepeat]);
    } */
}