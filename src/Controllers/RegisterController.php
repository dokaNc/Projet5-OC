<?php

    namespace App\Controller;

    use App\Model\UserManager;

    class RegisterController {
        
        public function __construct() {
        }

        public function defaultAction($twig) {
            $register = new UserManager();

            if (isset($_POST['username'])){
                $data = array(
                    "username" => $_POST['username'],
                    "firstname" => $_POST['firstname'],
                    "lastname" => $_POST['lastname'],
                    "email" => $_POST['email'],
                    "password" => $_POST['password'],
                );

                $register->createUser($data);

            }
            
            echo $twig->render('user/register.twig');
        }
    }