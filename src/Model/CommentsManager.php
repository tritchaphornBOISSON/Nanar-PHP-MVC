<?php

namespace App\Model;

use PDO;

class CommentsManager extends AbstractManager
{
    public const TABLE = 'comment';

    public function insert(array $comment): void
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            "(`comment`, `user_id`, `film_id`) VALUES (:comment, :user_id, :film_id)");
        $statement->execute([
            'comment' => $comment['comment'],
            'user_id' => $comment['user_id'],
            'film_id' => $comment['film_id']
        ]);
    }

    public function selectByMovieId(int $movieId): array
    {
        $statement = $this->pdo->prepare("
        SELECT 
        comment.comment,
        comment.user_id,
        comment.film_id,
        comment.created_at, 
        user.username
        FROM comment 
        JOIN user
        ON comment.user_id=user.id
        WHERE film_id=:film_id
        ORDER BY created_at DESC
        ");
        $statement->bindValue('film_id', $movieId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
