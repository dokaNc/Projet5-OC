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
            $database = $this->connectDB();
            $requete = $database->prepare('SELECT email FROM users WHERE  email = ? LIMIT 1');
            $requete->execute(array($email));
            if ($requete->fetchColumn()) {
    
                return true;
            }
            return false;
        }

        public function getUser(string $email)
        {
            $database = $this->connectDB();
            $requete = $database->prepare('SELECT * FROM users WHERE email= ?');
            $requete->execute(array($email));
            $requete = $requete->fetch();
    
            return $requete;
        }

        public function update($data, $row, $email)
        {
            $database = $this->connectDB();
            $requete = $database->prepare("UPDATE users SET $row = ? WHERE email = ? ");
            $requete->execute(array($data, $email));
        }

        public function checkUsername(string $username)
        {
            $database = $this->connectDB();
            $requete = $database->prepare('SELECT username FROM users WHERE  username = ? LIMIT 1');
            $requete->execute(array($username));
            if ($requete->fetchColumn()) {
    
                return true;
            }
            return false;
        }
    }