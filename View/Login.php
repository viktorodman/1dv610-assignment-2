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

	private $errorMessage = "";
	private $remeberedUsername = "";

	
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {

		if (isset($_POST[self::$name])) {
			$this->remeberedUsername = $_POST[self::$name];
		}
		$response = $this->generateLoginFormHTML($this->errorMessage);

		//$response .= $this->generateLogoutButtonHTML($message);
		return $response;
	}

	public function userWantsToLogin () : bool {
		return isset($_POST[self::$login]);
	}

	public function getCredentials() : \Model\Credentials {
		if (empty($_POST[self::$name]) && empty($_POST[self::$password])) {
			throw new \Exception(self::$errorMessageNoUsername);
		}
		return new \Model\Credentials($this->getUsername(), $this->getPassword());
	}


	public function showErrorMessage(string $errorMessage) {
		$this->errorMessage = $errorMessage;
	}

	private function getUsername() : \Model\Username {
		if (empty($_POST[self::$name])) {
            throw new \Exception(self::$errorMessageNoUsername);
		}
		
		return new \Model\Username($_POST[self::$name]);
	}

	private function getPassword() : \Model\Password {
		if (empty($_POST[self::$password])) {
            throw new \Exception(self::$errorMessageNoPassword);
        }

		return new \Model\Password($_POST[self::$password]);
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
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->remeberedUsername .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
	}
	
}