<?php

namespace View;

class Register {
    private static $registerURLID = 'register';
    private static $messageID = 'RegisterView::Message';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $name = 'RegisterView::UserName';
    


    public function generateRegisterFormHTML() {
        return '
        <h2>Register new user</h2>
        <form action="?' . self::$registerURLID .'" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>Register a new user - Write username and password</legend>
                <p id="'. self::$messageID .'"></p>
                <label for="'. self::$name .'" >Username :</label>
                <input type="text" size="20" name="'. self::$name .'" id="'. self::$name .'" value="" />
                <br/>
                <label for="'. self::$password .'" >Password  :</label>
                <input type="password" size="20" name="'. self::$password .'" id="'. self::$password .'" value="" />
                <br/>
                <label for="'. self::$passwordRepeat .'" >Repeat password  :</label>
                <input type="password" size="20" name="'. self::$passwordRepeat .'" id="'. self::$passwordRepeat .'" value="" />
                <br/>
                <input id="submit" type="submit" name="DoRegistration"  value="Register" />
                <br/>
            </fieldset>
        </form>';
    }
}