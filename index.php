<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('View/Login.php');
require_once('View/DateTime.php');
require_once('View/Layout.php');
require_once('View/Register.php');
require_once('controller/Login.php');
require_once('controller/Layout.php');
require_once('controller/Register.php');

require_once('model/DAL/UserDatabase.php');
require_once('model/DAL/UserSessionStorage.php');
//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');


$db = new \Model\DAL\UserDatabase();
$uss = new \Model\DAL\UserSessionStorage();

$db->connect();

//CREATE OBJECTS OF THE VIEWSs
$layoutView = new \View\Layout();
$loginView = new \View\Login($uss);
$dateTimeView = new \View\DateTime();
$registerView = new \View\Register($uss);

$registerController = new \Controller\Register($registerView, $db);
$loginController = new \Controller\Login($loginView, $db);
$layoutController = new \Controller\Layout($layoutView);

$registerController->doRegister();
$loginController->doLogin();
$loginController->doLogout();
$layoutController->doLayout();

$isLoggedIn = isset($_SESSION['LoginView::userSessionIndex']);






$layoutView->render($isLoggedIn, $loginView, $dateTimeView, $registerView);



