<?php
    namespace App\Model;

    class UserManager extends Manager

    {

        public function createUser($data)
        {
            $database = $this->connectDB();
            $requete = $database->prepare("INSERT INTO users (firstname, lastname, username, email, password, status) VALUES (?, ?, ?, ?, ?, 'new')");
            $requete->execute(array($data['firstname'], $data['lastname'], $data['username'], $data['email'], $data['password']));
            
            return $requete;
        }

        public function checkUser($email)
        {
            $dtb = $this->connectDB();
            $req = $dtb->prepare('SELECT email FROM users WHERE  email = ? LIMIT 1');
            $req->execute(array($email));
            if ($req->fetchColumn()) {
    
                return true;
            }
            return false;
        }

        public function getUser(string $email)
        {
            $dtb = $this->connectDB();
            $req = $dtb->prepare('SELECT * FROM users WHERE email= ?');
            $req->execute(array($email));
            $req = $req->fetch();
    
            return $req;
        }

        public function checkUsername(string $username)
        {
            $dtb = $this->connectDB();
            $req = $dtb->prepare('SELECT username FROM users WHERE  username = ? LIMIT 1');
            $req->execute(array($username));
            if ($req->fetchColumn()) {
    
                return true;
            }
            return false;
        }
    }