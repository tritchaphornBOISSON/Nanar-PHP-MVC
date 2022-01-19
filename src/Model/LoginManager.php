<?php

declare(strict_types=1);

namespace App\Model;

use PDO;

class LoginManager extends AbstractManager
{
    public const TABLE = 'user';

    public function register(array $user): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`username`,`password`,`email`) 
        VALUES (:username, :password, :email)");
        $statement->bindValue(':username', $user['username']);
        $statement->bindValue(':password', $user['password']);
        $statement->bindValue(':email', $user['email']);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function login($email, $password): ?array
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . self::TABLE . ' WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        $row = $statement->fetch();

        if (password_verify($password, $row['password'])) {
            return $row;
        } else {
            return null;
        }
    }

    public function findUserByEmail(string $email): bool
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . self::TABLE . ' WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        $sameEmail = $statement->fetch(PDO::FETCH_COLUMN);

        if ($sameEmail) {
            return true;
        }
        return false;
    }
}
