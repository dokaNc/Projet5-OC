<?php

namespace App\Model;

class PostManager extends Manager
{

    public function countPosts()
    {
        $database = $this->connectDB();
        $requete = $database->prepare('SELECT COUNT(*) AS total FROM posts');
        $requete->execute();
        $total = $requete->fetch();

        return $total;
    }

    public function getPost(int $idy)
    {
        $database = $this->connectDB();
        $requete = $database->prepare('SELECT * FROM posts WHERE id = ?');
        $requete->execute(array($idy));

        return $requete->fetchObject();
    }

    public function getPostsPerPage($page, $article)
    {
        $database = $this->connectDB();
        $requete = $database->prepare("SELECT * FROM posts ORDER BY add_date DESC LIMIT " . (($page - 1) * $article) . ",$article");
        $requete->execute();

        return $requete->fetchAll();
    }

    public function getAllPosts()
    {
        $database = $this->connectDB();
        $requete = $database->prepare('SELECT * FROM posts ORDER BY add_date DESC');
        $requete->execute();

        return $requete->fetchAll();
    }

}
