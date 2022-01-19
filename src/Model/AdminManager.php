<?php

namespace App\Model;

use PDO;

class AdminManager extends AbstractManager
{
    public const TABLE = 'film';

    public function insert(array $movie): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`,`poster`,
        `trailer`,`categories`,`grade`, `description`) 
        VALUES (:title, :poster,:trailer, :categories, :grade, :description)");
        $statement->execute([
            'title' => trim($movie['title']),
            'poster' => trim($movie['poster']),
            'trailer' => trim($movie['trailer']),
            'categories' => trim($movie['categories']),
            'grade' => trim($movie['grade']),
            'description' => trim($movie['description'])
        ]);

        return (int)$this->pdo->lastInsertId();
    }


    public function update(array $movie): bool
    {
        $stmt = $this->pdo->prepare("UPDATE " . self::TABLE .
            " SET `title` = :title,
         `poster` = :poster,
         `trailer` = :trailer,
          `categories`= :categories,
           `grade` = :grade,
            `description` = :description
             WHERE `id` = :id");

        return $stmt->execute([
            'title' => $movie['title'],
            'poster' => $movie['poster'],
            'trailer' => $movie['trailer'],
            'categories' => $movie['categories'],
            'grade' => $movie['grade'],
            'description' => $movie['description'],
            'id' => $movie['id'],
        ]);
    }

    public function getById(int $id): ?array
    {
        $query = 'SELECT * FROM' . self::TABLE . 'WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $movie = $statement->fetch(PDO::FETCH_BOTH);

        if ($movie) {
            return $movie;
        }
        return null;
    }
}
