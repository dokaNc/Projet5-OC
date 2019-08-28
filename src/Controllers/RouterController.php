<?php

    namespace App\Controller;

    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;

    class RouterController
    {
        const DEFAULT_PATH = 'App\Controller\\';
        const DEFAULT_CONTROLLER  = 'IndexController';
        const DEFAULT_ACTION = 'defaultAction'

        public $twig;

        protected $controller = self::DEFAULT_CONTROLLER;

        protected $action = self::DEFAULT_ACTION;

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
            $urlParams = ucfirst(filter_input(INPUT_GET, 'page'));
            $urlParams = explode('!', $urlParams);

            $this->action = count($urlParams) == 1 ? 'index' : $urlParams[1];

            if (!$urlParams[0]) {
                $this->controller = new IndexController($this->twig);
            } else if (class_exists(self::DEFAULT_PATH.$urlParams[0].'Controller')) {
                $namespace = self::DEFAULT_PATH.$urlParams[0]."Controller";
                $this->controller = new $namespace($this->twig);
            } else {
                $this->controller = new HandlerController($this->twig);
            }

            $this->setAction();

            $response = call_user_func([$this->controller, $this->action]);
            echo filter_var($response);

            }

            public function setAction()
            {
                $this->action = strtolower($this->action) . 'Action';
                if (!method_exists($this->controller, $this->action)) {
                    $this->action = self::DEFAULT_ACTION;
                }
            }
        }
    
