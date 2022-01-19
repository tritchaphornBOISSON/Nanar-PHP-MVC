<?php

namespace App\Model;

class CategoryManager extends AbstractManager
{
    public const TABLE = 'film';

    /**
     * Get all Categories from database.
     */
    public function getCategories(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT DISTINCT categories FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll(\PDO::FETCH_COLUMN);
    }
}
