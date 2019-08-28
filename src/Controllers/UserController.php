<?php

    namespace App\Controller;

    use App\Model\UserManager;

    class RegisterController {
        
        public function __construct() {
        }

        public function defaultAction($twig) {
            $register = new UserManager();

            if (isset($_POST['username'])){

                    $data['username'] = filter_input(INPUT_POST, 'username');
                    $data['email'] = filter_input(INPUT_POST, 'email');
                    $data['password'] = filter_input(INPUT_POST, 'password');
                    $data['password2'] = filter_input(INPUT_POST, 'passwordconfirm');
                    $data['firstname'] = filter_input(INPUT_POST, 'firstname');
                    $data['lastname'] = filter_input(INPUT_POST, 'lastname');
              

                $register->createUser($data);

            }
            
            echo $twig->render('user/register.twig');
        }
    }