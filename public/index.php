<?php

use Controller\RouterController;
use Controller\IndexController;

require '../vendor/autoload.php';

$router = new RouterController();
$twig = $router->twig;
$router->route();