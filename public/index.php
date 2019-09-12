<?php

use App\Controller\FrontController;

require_once '../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$frontController = new FrontController();
$frontController->run();