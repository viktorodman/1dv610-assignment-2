<?php

namespace View;

require_once('model/Username.php');
require_once('model/Password.php');
require_once('model/Credentials.php');

class Login {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $usernameField = 'LoginView::LoginField';
	private static $errorMessageNoUsername = 'Username is missing';
	private static $errorMessageNoPassword = 'Password is missing';
	private static $userSession = 'user';
	private static $errorMessageSessionIndex = "LoginView::errorMessageSessionIndex";
	private static $rememberedUserSessionIndex = "LoginView::rememberedUserSessionIndex";
	
    private $errorMessageWasSetAndShouldNotBeRemovedDuringThisRequest = false;
    private $usernameWasSetAndShouldNotBeRemovedDuringThisRequest = false;
	

	
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$remeberedUsername = $this->getRememberedUsername();
		$message = $this->getErrorMessage();
		$response = $this->generateLoginFormHTML($message, $remeberedUsername);

		//$response .= $this->generateLogoutButtonHTML($message);
		return $response;
	}

	public function reloadPageAndLogin() {
        $this->messageWasSetAndShouldNotBeRemovedDuringThisRequest = true;

        header('Location: /');
	}

	public function reloadPageAndShowErrorMessage(string $errorMessage) {
		$_SESSION[self::$errorMessageSessionIndex] = $errorMessage;
		$_SESSION[self::$rememberedUserSessionIndex] = $_POST[self::$name];

		$this->errorMessageWasSetAndShouldNotBeRemovedDuringThisRequest = true;
		$this->usernameWasSetAndShouldNotBeRemovedDuringThisRequest = true;
		
		header('Location: /');
	}

	public function userWantsToLogin () : bool {
		return isset($_POST[self::$login]);
	}

	public function getRequestUserCredentials() : \Model\Credentials {
		return new \Model\Credentials($this->getRequestUsername(), $this->getRequestPassword());
	}

	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message, $remeberedUsername) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="'. self::$messageId .'">'. $message .'</p>
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $remeberedUsername .'" />
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	private function getRememberedUsername() {
		if ($this->usernameWasSetAndShouldNotBeRemovedDuringThisRequest) {
            return $_SESSION[self::$rememberedUserSessionIndex];
        }

        if(isset($_SESSION[self::$rememberedUserSessionIndex])) {
            $message = $_SESSION[self::$rememberedUserSessionIndex];
            unset($_SESSION[self::$rememberedUserSessionIndex]);
            return $message;
        }
        return "";
	}

	private function getErrorMessage() {
		if ($this->errorMessageWasSetAndShouldNotBeRemovedDuringThisRequest) {
            return $_SESSION[self::$errorMessageSessionIndex];
        }

        if(isset($_SESSION[self::$errorMessageSessionIndex])) {
            $message = $_SESSION[self::$errorMessageSessionIndex];
            unset($_SESSION[self::$errorMessageSessionIndex]);
            return $message;
        }
        return "";
	}
	
	private function getRequestUsername() : \Model\Username {
		if (empty($_POST[self::$name])) {
            throw new \Exception(self::$errorMessageNoUsername);
		}
		
		return new \Model\Username($_POST[self::$name]);
	}



	private function getRequestPassword() : \Model\Password {
		if (empty($_POST[self::$password])) {
            throw new \Exception(self::$errorMessageNoPassword);
		}
		
		return new \Model\Password(self::$password);
	}
	
}