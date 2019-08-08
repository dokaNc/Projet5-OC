<?php

    namespace App\Controller;

    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;

    class RouterController
    {
        const DEFAULT_PATH = 'App\Controller\\';
        const DEFAULT_CONTROLLER  = 'IndexController';

        public $twig;

        public function __construct() {
            $this->twigLoader();
        }

        public function twigLoader() {
            $loader = new FilesystemLoader('../src/Views/');
            $this->twig = new Environment($loader, [
                'cache' => false,
            ]);
        }

        public function route() {
            $page = ucfirst(filter_input(INPUT_GET, 'page'));
           
            if (!$page) {
                $controller = new IndexController();
                $controller->defaultAction($this->twig);
            } else if (class_exists('App\Controller\\'.$page.'Controller')) {
                $namespace = "App\Controller\\".$page."Controller";
                $controller = new $namespace;
                $controller->defaultAction($this->twig);
            } else {
                $controller = new HandlerController();
                $controller->defaultAction($this->twig);
            }
        }
    }
