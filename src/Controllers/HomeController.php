<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

    class HomeController extends Controller {
        
        public function indexAction()
        {
            return $this->render('home.twig');
        }
    }