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

    public function addPost($data)
    {
        $dtb = $this->connectDB();
        $req = $dtb->prepare('INSERT INTO posts (title, author, headline, content, add_date ) VALUES (?,?,?,?, NOW())');
        $req->execute(array($data['title'], $data['author'], $data['headline'], $data['content']));

        return true;
    }

    public function updatePost($data)
    {
        $dtb = $this->connectDB();
        $req = $dtb->prepare('UPDATE posts SET title = ?, author = ?, headline = ? , content = ? , add_date = NOW() WHERE id =  ? ');
        $req->execute(array($data['title'], $data['author'], $data['headline'], $data['content'], $data['idy']));

        return true;
    }

    public function deletePost(int $idy)
    {
        $dtb = $this->connectDB();
        $req = $dtb->prepare('DELETE FROM posts WHERE id = ?');
        $req->execute(array($idy));

        return true;
    }
}
