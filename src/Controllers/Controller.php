<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


abstract Class Controller
{

    protected $twig;

    protected $session;


    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->session = new SessionController();
    }


    public function render($view, array $params = [])
    {
        return $this->twig->render($view, $params);
    }

    public function alert($msg)
    {
        $alert = "<script>alert('$msg');</script>";
        echo filter_var($alert);
    }

}
