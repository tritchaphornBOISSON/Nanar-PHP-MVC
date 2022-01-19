<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    /**
     * List items
     */
    public function index(): string
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategories();
        $movies = $categoryManager->selectAll();

        return $this->twig->render('Categories/index.html.twig', ['categories' => $categories, 'movies' => $movies]);
    }
}
