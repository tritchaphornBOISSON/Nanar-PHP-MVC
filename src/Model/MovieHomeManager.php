<?php

namespace App\Model;

class MovieHomeManager extends AbstractManager
{
    public const TABLE = 'film';

    public function getThree(): array
    {
        $statement = $this->pdo->query('SELECT * FROM film ORDER BY RAND() LIMIT 3');
        return $statement->fetchAll();
    }

    public function getTopThree(): array
    {
        $statement = $this->pdo->query('SELECT * FROM film WHERE grade = "5" ORDER BY RAND() LIMIT 3');
        return $statement->fetchAll();
    }

    public function getRandomComedyMovie(): array
    {
        $statement = $this->pdo->query('SELECT * FROM film WHERE categories = "Comédie" ORDER BY RAND()');
        return $statement->fetch();
    }

    public function getRandomFantasyMovie(): array
    {
        $statement = $this->pdo->query('SELECT * FROM film WHERE categories = "Fantastique" ORDER BY RAND()');
        return $statement->fetch();
    }

    public function getRandomHorrorMovie(): array
    {
        $statement = $this->pdo->query('SELECT * FROM film WHERE categories = "Horreur" ORDER BY RAND()');
        return $statement->fetch();
    }

    public function getRandomActionMovie(): array
    {
        $statement = $this->pdo->query('SELECT * FROM film WHERE categories = "Action" ORDER BY RAND()');
        return $statement->fetch();
    }
}
