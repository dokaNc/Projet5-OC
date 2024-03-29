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

        public function emailAction()
        {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            if (isset($email))
                // EDIT THE LINE BELOW AS REQUIRED
                $_to = "cirpan.dogukan5959@gmail.com";//EMAIL ADDRESS TO RECEIVE THE MAILS
            $email_subject = "Formulaire de contact du blog";
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); // required
            $email_from = filter_input(INPUT_POST, 'email_from', FILTER_SANITIZE_STRING); // required
            $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING); // not required
            $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_STRING); // required
    
            // validation expected data exists
            if (!empty($name) and !empty($email_from) and !empty($comments)) {
                $email_message = "Détails du message\n\n";
                $email_message .= "Nom : " . $this->clean_string($name) . "\n";
                $email_message .= "Email : " . $this->clean_string($email_from) . "\n";
                $email_message .= "Téléphone : " . $this->clean_string($telephone) . "\n";
                $email_message .= "Message : " . $this->clean_string($comments) . "\n";
    
                // create email headers
                $headers = 'From: ' . $email_from . "\r\n" .
                    'Reply-To: ' . $email_from . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                mail($_to, $email_subject, $email_message, $headers);
    
                $this->alert("Votre message à bien été envoyé ! Nous vous repondrons dès que possible.");
            }
            return $this->render("home.twig");
        }
    
        private function clean_string($string)
        {
            $bad = array("content-type", "bcc:", "to:", "cc:", "href");
    
            return str_replace($bad, "", $string);
        }
    }