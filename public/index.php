<?php

use App\Controller\RouterController;
use App\Controller\IndexController;

require_once '../vendor/autoload.php';

$router = new RouterController();
$twig = $router->twig;
$router->route();