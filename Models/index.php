<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// =============== require des controllers =================
require_once 'Controllers/homeController.php';
require_once 'Controllers/loginController.php';
require_once 'Controllers/registerController.php';
require_once 'Controllers/managePosititController.php';
require_once 'Controllers/sendPosititController.php';
require_once 'Controllers/accountController.php';
require_once 'Controllers/changePasswordController.php';
require_once 'Controllers/disconnectController.php';
require_once 'Controllers/legalController.php';
require_once 'Controllers/leaderboardController.php';
require_once 'Controllers/reportController.php';
require_once 'Controllers/dashboardController.php';
require_once 'Controllers/manageMessageController.php';

spl_autoload_register(function ($classname) { 
    require_once str_replace('\\', '/','./' . $classname . '.php'); 
});

if(session_status() == 0)
{
    $sessionTime = 946080000; // un an environ
    ini_set('session.gc_maxlifetime', $sessionTime);
    session_set_cookie_params($sessionTime);
}

  session_start();
  $_SESSION['lang'] = 'fr';

//=================== Utilisation routeur ==================
if(!isset($_GET['route'])){
    $url = 'home';
}
else{
    $url = $_GET['route'];
}

$routeur = new routeur();
$routeur->Display($url);

?>

