<?php

//INCLUDE THE FILES NEEDED...
require_once('View/Login.php');
require_once('View/DateTime.php');
require_once('View/Layout.php');
require_once('View/Register.php');
require_once('controller/Login.php');
require_once('controller/Layout.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWSs
$layoutView = new \View\Layout();
$loginView = new \View\Login();
$dateTimeView = new \View\DateTime();
$registerView = new \View\Register();


$loginController = new \Controller\Login($loginView);
$layoutController = new \Controller\Layout($layoutView);


$loginController->doLogin();
$layoutController->doLayout();






$layoutView->render(false, $loginView, $dateTimeView, $registerView);

