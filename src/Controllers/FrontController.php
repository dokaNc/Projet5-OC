<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class FrontController extends Controller
{

    const DEFAULT_PATH = 'App\Controller\\';

    const DEFAULT_CONTROLLER = 'HomeController';
    
    const DEFAULT_ACTION = 'indexAction';


    public function __construct()
    {
        $this->setTemplateTwig();
        $this->routeUrl();
        $this->setController();
        $this->setAction();
    }


    public function setTemplateTwig()
    {
        $loader = new FilesystemLoader('../src/Views');
        $twig = new Environment($loader, array(
            'cache' => false,
            'debug' => true
        ));
        $twig->addGlobal('session', filter_var_array($_SESSION));
        $this->twig = $twig;
    }

    public function routeUrl()
    {
        $page = filter_input(INPUT_GET, 'page');
        if (!isset($page)) {
            $page = 'home';
        }
        $page = explode('!', $page);
        $this->controller = $page[0];
        $this->action = count($page) == 1 ? 'index' : $page[1];
    }

    public function setController()
    {
        $this->controller = ucfirst(strtolower($this->controller)) . 'Controller';
        $this->controller = self::DEFAULT_PATH . $this->controller;
        if (!class_exists($this->controller)) {
            $this->controller = self::DEFAULT_PATH . self::DEFAULT_CONTROLLER;
        }
    }

    public function setAction()
    {
        $this->action = strtolower($this->action) . 'Action';
        if (!method_exists($this->controller, $this->action)) {
            $this->action = self::DEFAULT_ACTION;
        }
    }

    public function run()
    {
        $this->controller = new $this->controller($this->twig);

        $response = call_user_func([$this->controller, $this->action]);

        echo filter_var($response);
    }
}
