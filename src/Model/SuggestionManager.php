<?php

namespace App\Model;

class SuggestionManager extends AbstractManager
{
    public const TABLE = 'suggestion';

    public function insertSuggestion(array $suggestion): void
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`,`category`,`comment`,) 
        VALUES (:title, :category, :comment)");
        $statement->bindValue('title', $suggestion['title'], \PDO::PARAM_STR);
        $statement->bindValue('category', $suggestion['category'], \PDO::PARAM_STR);
        $statement->bindValue('comment', $suggestion['comment'], \PDO::PARAM_STR);
        $statement->execute();
    }
}
