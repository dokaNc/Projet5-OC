<?php

    namespace Controller;

    class HandlerController {
        
        public function __construct() {
        }

        public function defaultAction($twig) {
            echo $twig->render('404.twig');
        }
    }
