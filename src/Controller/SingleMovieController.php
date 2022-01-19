<?php

namespace App\Controller;

use App\Model\CommentsManager;
use App\Model\FavoriteMovieManager;
use App\Model\SingleMovieManager;

class SingleMovieController extends AbstractController
{
    public function showOne(int $id): string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = array_map('trim', $_POST);

            if (empty($comment['user-comment'])) {
                $errors['emptyComment'] = 'Vous devez ajouter un commentaire';
            } else {
                $comment = [
                    'comment' => $comment['user-comment'],
                    'user_id' => $_SESSION['user_id'],
                    'film_id' => $id,
                ];
                $commentsManager = new CommentsManager();
                $commentsManager->insert($comment);
                header('Location: /movie?id=' . $id);
            }
        }

        $singleMovieManager = new SingleMovieManager();
        $singleMovie = $singleMovieManager->selectOneById($id);
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->selectByMovieId($id);

        return $this->twig->render('SingleMovie/index.html.twig', [
            'movie' => $singleMovie,
            'comments' => $comments,
            'errors' => $errors,
        ]);
    }

    public function addFavoriteMovie()
    {
        $favoriteDetail = [];
        if (isset($_GET['id'])) {
            $favoriteDetail['film_id'] = trim($_GET['id']);
            $favoriteDetail['user_id'] = $_SESSION['user_id'];
            $favoriteMovieManager = new FavoriteMovieManager();
            $favoriteMovieManager->addFavoriteMovie($favoriteDetail);
            header('Location:/profile');
            return '';
        }
    }

    public function removeFavoriteMovie()
    {
        if (isset($_GET['id'])) {
            $id = trim($_GET['id']);
            $favoriteMovieManager = new FavoriteMovieManager();
            $favoriteMovieManager->removeFavoriteMovie((int)$id);
            header('Location:/profile');
            return '';
        }
    }
}
