<?php
    namespace App\Model;

    class UserManager extends Manager

    {

        public function createUser($data)
        {
            print_r($data);
            $database = $this->connectDB();
            $req = $database->prepare("INSERT INTO users (firstname, lastname, username, email, password, status) VALUES (?, ?, ?, ?, ?, 'new')");
            $req->execute(array($data['firstname'], $data['lastname'], $data['username'], $data['email'], $data['password']));
            
            return $req;
        }
    }