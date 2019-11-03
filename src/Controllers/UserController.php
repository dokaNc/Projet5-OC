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

            if (filter_has_var(INPUT_POST, 'submit')) {

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
                    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                    $checkStatus = $register->checkUser($data['email']);
                    if(!$checkStatus) {
                        $register->createUser($data);
                        $success = true;
                    } else {
                        array_push($errors, 'Une erreur s\'est produite lors de l\'inscription.');
                    }
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

        public function editAction()
        {
            if ($this->session->isLogged()) {
                $data = (new UserManager())->getUser($this->session->getUserVar('email'));
                return $this->render('user/user.twig', array('data' => $data));
            } else {
                return $this->render("home.twig", array('session' => filter_var_array($_SESSION)));
            }
        }

        public function updateAction()
        {
            if ($this->session->isLogged()) {
                $data['username'] = (filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
                $data['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
                $data['password0'] = filter_input(INPUT_POST, 'oldpassword', FILTER_SANITIZE_STRING);
                $data['password'] = filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_STRING);
                $data['password2'] = filter_input(INPUT_POST, 'passwordconfirm', FILTER_SANITIZE_STRING);
                $data['oldemail'] = $this->session->getUserVar('email');
        
                $userManager = new UserManager();
                $info = $userManager->getUser($data['oldemail']);
                $error = $this->verifyUser($data);
        
                if (!empty($data['password0']) and empty($data['password']) or empty($data['password0']) and !empty($data['password'])) {
                    $error['password0'] = 'Veuillez remplir tous les champs !';
                }
                if (!empty($data['password0'] and password_verify($data['password0'], $info['password']) === false)) {
                    $error['password0'] = "Mauvais mot de passe !";
                }
                if (!empty($error)) {
        
                    return $this->render("user/user.twig", array("error" => $error, "data" => $info));
                }
                $data = $this->updateUser($data);
                $info = $userManager->getUser($data['oldemail']);
                $status = $this->session->checkStatus($info['status']);
                $this->session->createSession($info['id'], $info['username'], $info['email'], $status);
                $this->alert("Modifications enregistrées !");
            }
            return $this->render("home.twig", array('session' => filter_var_array($_SESSION)));
        }

        public function verifyUser($data)
        {
            $error = [];
            $userManager = new UserManager();
            if (!empty($data['email']) and $userManager->checkUser($data['email']) === true) {
                $error['email'] = "Cet e-mail est déjà utilisé !";
            }
            if (!empty($data['username']) and $userManager->checkUsername($data['username']) === true) {
                $error['username'] = "Ce Pseudo est déjà utilisé !";
            }
            if (!empty($data['password2']) and $data['password'] !== $data['password2']) {
                $error['password'] = "Vos mot de passe sont différents !";
            }
            return $error;
        }
    
        public function updateUser($data)
        {
            $userManager = new UserManager();
            if (!empty($data['email'])) {
                $userManager->update($data['email'], 'email', $data['oldemail']);
                $data['oldemail'] = $data['email'];
            }
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);//encrypt the password before saving in the database
                $userManager->update($data['password'], 'password', $data['oldemail']);
            }
            if (!empty($data['username'])) {
                $userManager->update($data['username'], 'username', $data['oldemail']);
            }
            return $data;
        }
    }