<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Model\SuggestionManager;

class UserController extends AbstractController
{
    public function index(): string
    {
        $userManager = new UserManager();

        $userId = $_SESSION['user_id'];
        $movies = $userManager->getFavoriteMovies($userId);
        $loggedinUser = $userManager->selectOneById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $suggestion = array_map('trim', $_POST);
            $suggestion['title'] = $_POST['title'];
            $suggestion['category'] = $_POST['category'];
            $suggestion['comment'] = $_POST['comment'];

            $suggestionManager = new SuggestionManager();
            $suggestionManager->insertSuggestion($suggestion);
            return('OK');
        }

        return $this->twig->render('User/profile.html.twig', [
            'movies' => $movies,
            'loggedinUser' => $loggedinUser,
        ]);
    }
}
