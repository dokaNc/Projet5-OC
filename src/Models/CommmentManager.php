<?php

namespace App\Model;

class CommentManager extends Manager
{

    public function addComment(string $author, string $content, int $posts_id, int $idy)
    {
        $database = $this->connectDB();
        $requete = $database->prepare("INSERT INTO comments (author, content, add_date, validation, posts_id, users_id) VALUES (?, ?, NOW(), '0', ?, ?)");
        $requete->execute(array($author, $content, $posts_id, $idy));
    }

    public function getValidatedComments(int $idy)
    {
        $database = $this->connectDB();
        $requete = $database->prepare("SELECT * FROM comments WHERE posts_id = ? AND validation = 1");
        $requete->execute(array($idy));

        return $requete->fetchAll();
    }

    public function getWaitingComments(int $idy, int $userId)
    {
        $database = $this->connectDB();
        $requete = $database->prepare("SELECT * FROM comments WHERE posts_id = ? AND users_id = ? AND validation = 0 ORDER BY add_date");
        if ($requete->execute(array($idy, $userId))) {

            return $requete->fetchAll();
        }
        return false;
    }

    public function getAllComments()
    {
        $database = $this->connectDB();
        $requete = $database->prepare("SELECT * FROM comments ORDER BY validation");
        $requete->execute();

        return $requete->fetchAll();
    }
}
