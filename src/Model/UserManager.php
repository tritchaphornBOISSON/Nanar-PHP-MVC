<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function getFavoriteMovies(int $userId): array
    {
        $statement = $this->pdo->prepare('
        SELECT
        film.title,
        film.poster,
        film.id,
        user.firstname,
        user.lastname,
        user.username,
        user.email
        FROM film
        JOIN favorite
        ON film.id=favorite.film_id
        JOIN user 
        ON user.id=favorite.user_id
        WHERE user.id=:userId
        ');
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        return $statement->fetchAll();
    }
}
