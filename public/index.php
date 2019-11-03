<?php

use App\Controller\FrontController;

require_once '../vendor/autoload.php';

// function generateToken() {
//     $token = bin2hex(random_bytes(32));
//     $currentTime = new DateTime();
//     $_SESSION['token'] = $token;
//     $_SESSION['tk_ct'] = $currentTime;
// };

if (session_status() == PHP_SESSION_NONE) {
    session_start();
    // if(isset($_SESSION['token']) && isset($_SESSION['tk_ct'])){
    //     $currentTime = new DateTime();
    //     $interval = $currentTime->diff($_SESSION['tk_ct']);
    //     if(($currentTime->getTimestamp() - $_SESSION['tk_ct']->getTimestamp()) > (60 * 1) ) {
    //         generateToken();
    //     }
    // } else {
    //     generateToken();
    // }
}

$frontController = new FrontController();
$frontController->run();