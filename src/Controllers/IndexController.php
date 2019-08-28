<?php

    namespace App\Controller;

    class IndexController {
        
        protected $twig;

        public function __construct($twig) {
            $this->twig = $twig;
        }

        public function defaultAction() {

            $form_success = false;
            $form_errors = array();

            if (count(filter_input(INPUT_POST, 'submit')) === 1) {

                $data = array(
                    "name" => filter_input(INPUT_POST, 'name'),
                    "email" => filter_input(INPUT_POST, 'email'),
                    "message" => filter_input(INPUT_POST, 'message')
                );

                $response_mail = mail('cirpan.dogukan5959@gmail.com', $data['name']." Vous a envoyé un mail", $data['message'], 'From: '.$data['name'].' '.$data['email']);

                if ($response_mail) {
                    $form_success = true;
                } else {
                    array_push($form_errors, "Echec lors de l'envoie du message.");
                }
            }

            return $this->twig->render('home.twig', [
                'form_success' => $form_success,
                'errors' => $form_errors
            ]);
        }
    }
