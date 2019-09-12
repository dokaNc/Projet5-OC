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
                    $success = true;
                    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                    $register->createUser($data);
                }
            }
            
            return $this->twig->render('user/register.twig', [
                'success' => $success,
                'errors' => $errors
            ]);
        }

        public function loginAction()
        {
            $email = filter_input(INPUT_POST, 'emaillog', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'passwordlog', FILTER_SANITIZE_STRING);
    
            if (!empty($email) and !empty($password)) {
                $userManager = new UserManager();
                $info = $userManager->checkUser($email);
                if ($info !== false) {
                    $info = $userManager->getUser($email);
                    if (password_verify($password, $info['password']) === true) {
                        $status = $this->session->checkStatus($info['status']);
                        $this->session->createSession($info['id'], $info['username'], $info['email'], $status);
                        $this->alert("Vous êtes maintenant connecté sur le blog !");
    
                        return $this->render('home.twig', array('session' => filter_var_array($_SESSION)));
                    }
                }
                $this->alert('Vous avez saisis des informations incorrects !');
    
                return $this->render("home.twig");
            }
            $this->alert("Tout les champs ne sont pas remplis !");
    
            return $this->render("home.twig");
        }

        public function logoutAction()
        {
            if ($this->session->isLogged()) {
                $this->session->destroySession();
            }
            return $this->render('home.twig', array('session' => filter_var_array($_SESSION)));
        }
    }