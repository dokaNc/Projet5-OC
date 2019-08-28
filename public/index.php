<?php

use App\Controller\RouterController;

require_once '../vendor/autoload.php';

$router = new RouterController();
$twig = $router->twig;
$router->route();