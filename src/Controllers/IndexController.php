<?php

    namespace App\Controller;

    class IndexController {
        
        public function __construct() {
        }

        public function defaultAction($twig) {
            echo $twig->render('home.twig');
        }
    }
