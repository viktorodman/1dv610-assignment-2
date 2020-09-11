<?php

//INCLUDE THE FILES NEEDED...
require_once('View/Login.php');
require_once('View/DateTime.php');
require_once('View/Layout.php');
require_once('Controller/Login.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWSs
$v = new \View\Login();

$lc = new \Controller\Login($v);

$lc->doLogin();


$dtv = new \View\DateTime();
$lv = new \View\Layout();



$lv->render(false, $v, $dtv);

