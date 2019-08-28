<?php

    namespace App\Controller;

    class HandlerController {

        protected $twig;
        
        public function __construct($twig) {
            $this->twig = $twig;
        }

        public function defaultAction() {
            return $this->twig->render('404.twig');
        }
    }
