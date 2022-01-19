<?php

namespace App\Model;

class FavoriteMovieManager extends AbstractManager
{
    public const TABLE = 'favorite';

    public function addFavoriteMovie(array $movie): void
    {
        $statement = $this->pdo->prepare('
            INSERT INTO favorite (`film_id`, `user_id`) 
            VALUES (:film_id, :user_id)');

        $statement->bindValue('film_id', $movie['film_id'], \PDO::PARAM_INT);
        $statement->bindValue('user_id', $movie['user_id'], \PDO::PARAM_INT);
        $statement->execute();
    }

    public function removeFavoriteMovie(int $filmId): void
    {
        $statement = $this->pdo->prepare('DELETE FROM favorite WHERE film_id=:film_id');
        $statement->bindValue('film_id', $filmId, \PDO::PARAM_INT);
        $statement->execute();
    }
}
