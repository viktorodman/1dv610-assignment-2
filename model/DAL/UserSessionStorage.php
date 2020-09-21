<?php

namespace Model\DAL;

class UserSessionStorage {
    private static $messageSessionIndex = "messageSessionIndex";
	private static $rememberedUserSessionIndex = "rememberedUserSessionIndex";
	private static $userSessionIndex = "userSessionIndex";

    private $messageWasSetAndShouldNotBeRemovedDuringThisRequest = false;
    private $usernameWasSetAndShouldNotBeRemovedDuringThisRequest = false;



    

    public function getRememberedUsername() : string {
        return $this->getRememberedSessionVariable($this->usernameWasSetAndShouldNotBeRemovedDuringThisRequest, self::$rememberedUserSessionIndex);
    }

    public function getSessionMessage() : string {
        return $this->getRememberedSessionVariable($this->messageWasSetAndShouldNotBeRemovedDuringThisRequest, self::$messageSessionIndex);
    }


    public function userSessionIsActive() : bool {
        return isset($_SESSION[self::$userSessionIndex]);
    }

    public function setSessionMessage(string $message) {
        // Maybe change this
        $_SESSION[self::$messageSessionIndex] = $message;
    }

    public function setSessionUser(string $id) {
        // Maybe change this
        $_SESSION[self::$userSessionIndex] = $id;
    }

    public function setRemeberedUsername(string $username) {
        $_SESSION[self::$rememberedUserSessionIndex] = $username;
    }
    
    public function setMessageToBeViewed() {
        $this->messageWasSetAndShouldNotBeRemovedDuringThisRequest = true;
    }

    public function setUsernameToBeRemembered() {
        $this->usernameWasSetAndShouldNotBeRemovedDuringThisRequest = true;
    }

    public function removeUserSession() {
        unset($_SESSION[self::$userSessionIndex]);
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