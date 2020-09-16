<?php

//INCLUDE THE FILES NEEDED...
require_once('View/Login.php');
require_once('View/DateTime.php');
require_once('View/Layout.php');
require_once('View/Register.php');
require_once('controller/Login.php');
require_once('controller/Layout.php');
require_once('controller/Register.php');

require_once('model/DAL/UserDatabase.php');
//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');


$u = new \Model\DAL\UserDatabase();



//CREATE OBJECTS OF THE VIEWSs
$layoutView = new \View\Layout();
$loginView = new \View\Login();
$dateTimeView = new \View\DateTime();
$registerView = new \View\Register();

$registerController = new \Controller\Register($registerView);
$loginController = new \Controller\Login($loginView);
$layoutController = new \Controller\Layout($layoutView);

$registerController->doRegister();
$loginController->doLogin();
$layoutController->doLayout();






$layoutView->render(false, $loginView, $dateTimeView, $registerView);

