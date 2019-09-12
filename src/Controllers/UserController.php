<?php

namespace App\Controller;

use App\Model\UserManager;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

    class UserController extends Controller {
        
        public function indexAction()
        {
            return $this->render('user/register.twig');
        }

        public function registerAction() {
            $register = new UserManager();

            $success = false;
            $errors = array();

            if (count(filter_input(INPUT_POST, 'submit')) === 1) {

                $data = array(
                    "username" => filter_input(INPUT_POST, 'username'),
                    "email" => filter_input(INPUT_POST, 'email'),
                    "password" => filter_input(INPUT_POST, 'password'),
                    "password2" => filter_input(INPUT_POST, 'passwordconfirm'),
                    "firstname" => filter_input(INPUT_POST, 'firstname'),
                    "lastname" => filter_input(INPUT_POST, 'lastname')
                );


                if ($data['password']  != $data['password2']) {
                    array_push($errors, 'Les mots de passe ne sont pas identiques.');
                }

                if (strlen($data['username']) < 5) {
                    array_push($errors, 'Le pseudonyme doit faire un minimum de 5 caractères.');
                }

                if (count($errors) == 0 && count(array_filter($data)) === 6) {
                    // tous les champs sont remplis.
                    $success = true;
                    $register->createUser($data);
                }
            }
            
            return $this->twig->render('user/register.twig', [
                'success' => $success,
                'errors' => $errors
            ]);
        }

    }