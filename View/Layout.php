<?php

namespace View;

class Layout {

  private static $registerURLID = 'register';
  private static $registerText = 'Register a new user';
  private static $goBackText = 'Back to login';
  private $shouldDisplayRegisterForm = false;
  private $linkText;
  private $navigationURL;

  
  public function render($isLoggedIn, \View\Login $v, \View\DateTime $dtv, \View\Register $regv) {
    $correctForm = "";
    $url = "";
    


    if ($this->shouldDisplayRegisterForm) {
        $correctForm = $regv->response();
        $url = 'register';
    } else {
      $this->linkText = self::$registerText;
      $this->navigationURL = self::$registerURLID;
      $correctForm = $v->response();
    }

    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          <a href="?' . $this->navigationURL . '">'. $this->linkText .'</a>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $correctForm . '

              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  public function shouldShowRegisterForm() : bool {
      return isset($_GET[self::$registerURLID]);
  }

  public function showRegisterForm() {
    $this->shouldDisplayRegisterForm = true;
    $this->linkText = self::$goBackText;
    $this->navigationURL = '';
  }

  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
