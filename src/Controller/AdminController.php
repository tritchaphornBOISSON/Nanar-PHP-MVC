<?php

namespace App\Controller;

use App\Model\AdminManager;

class AdminController extends AbstractController
{
    private AdminManager $adminModel;

    public function __construct()
    {
        parent::__construct();

        $this->adminModel = new AdminManager();
    }

    public function home(): string
    {
        $movies = $this->adminModel->selectAll('title');
        return $this->twig->render('Admin/home.html.twig', ['movies' => $movies]);
    }

    public function show(int $id): string
    {
        $movies = $this->adminModel->selectOneById($id);
        if (!$movies) {
            header('HTTP/1.1 404 Not Found');
            return("");
        }
        return $this->twig->render('SingleMovie/index.html.twig', ['movies' => $movies]);
    }

    public function edit(int $id): string
    {
        $movie = $this->adminModel->selectOneById($id);
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movie = array_map('trim', $_POST);

            if (isset($_FILES['poster']) && !empty($_FILES['poster']['tmp_name'])) {
                $poster = $_FILES['poster']['tmp_name'];
                $movie['poster'] = base64_encode(file_get_contents(addslashes($poster)));
            }
            // Validate data

            $errors = $this->validateMovie($movie);

            if (empty($errors)) {
                $movie['id'] =  $id;
                $this->adminModel->update($movie);
                header('Location: /admin');
                return('');
            }
        }
        return $this->twig->render('Admin/edit.html.twig', ['movie' => $movie, 'errors' => $errors ]);
    }

    public function add(): string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movie = array_map('trim', $_POST);

            if (isset($_FILES['poster']) && !empty($_FILES['poster']['tmp_name'])) {
                $poster = $_FILES['poster']['tmp_name'];
                $movie['poster'] = base64_encode(file_get_contents(addslashes($poster)));
            }

            $errors = $this->validateMovie($movie);

            if (empty($errors)) {
                $this->adminModel->insert($movie);
                header('Location:/admin');
                return('');
            }
        }
        return $this->twig->render('Admin/add.html.twig', ['errors' => $errors]);
    }

    /**
     * Delete a specific item
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieId = trim($_POST['id']);
            $this->adminModel->delete((int)$movieId);
            header('Location:/admin');
        }
    }

    private function validateMovie(array &$movie): array
    {
        $errors = [];
        if (empty($movie['title'])) {
            $errors['title'] = '** Title est obligatoire';
        }
        if (empty($movie['poster'])) {
            $errors['poster'] = '** Choisir un poster';
        }

        if (empty($movie['trailer'])) {
            $errors['trailer'] = '** Ajoute un trailer';
        }
        if (empty($movie['categories'])) {
            $errors['categories'] = '** Choisir une catégorie';
        }
        if (empty($movie['grade'])) {
            $errors['grade'] = '** Choisir une grade';
        }
        if (empty($movie['description'])) {
            $errors['description'] = '** Description est obligatoire';
        }
        return $errors;
    }
}
