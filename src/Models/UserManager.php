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
    }