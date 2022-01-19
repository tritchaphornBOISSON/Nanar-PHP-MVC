<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\LoginManager;

class LoginController extends AbstractController
{
    private LoginManager $loginModel;

    public function __construct()
    {
        parent::__construct();

        $this->loginModel = new LoginManager();
    }

    public function register(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = array_map('trim', $_POST);

            // Validate data
            $errors = $this->validateUser($user);

            $usernameValidation = "/^[a-zA-Z0-9]*$/";

            if (empty($user['username'])) {
                $errors['username'] = '** Merci d\' entrer un pseudo';
            } elseif (!preg_match($usernameValidation, $user['username'])) {
                $errors['username'] = '** Le pseudo ne peut contenir que des lettres et des nombres';
            }

            if ($this->loginModel->findUserbyEmail($user['email'])) {
                $errors['email'] = '** Ce mail est déjà utilisé.';
            }

            if (empty($user['confirmPassword'])) {
                $errors['confirmPassword'] = '** Merci d\' entrer un mot de passe';
            } else {
                if ($user['password'] != $user['confirmPassword']) {
                    $errors['confirmPassword'] = '** Merci d\' entrer un mot de passe correcte';
                }
            }

            if (empty($errors)) {
                $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
                $this->loginModel->register($user);
                header('Location: /login');
                return('');
            }
        }
        return $this->twig->render('Login/register.html.twig', ['errors' => $errors]);
    }

    public function connect()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = array_map('trim', $_POST);

            // Validate data
            $errors = $this->validateUser($user);


            if (empty($errors)) {
                $loggedInUser = $this->loginModel->login($user['email'], $user['password']);

                if ($loggedInUser) {
                    $_SESSION['user_id'] = $loggedInUser['id'];

                    if ($loggedInUser['is_admin'] == 1) {
                        header('Location: /admin');
                        return '';
                    } elseif (($loggedInUser['is_admin'] == 2)) {
                        header('Location: /profile');
                    }
                    return '';
                } else {
                    $errors['connect'] = '** Le mot de passe ou l\' identifiant est incorrect!';
                }
            }
        }
        return $this->twig->render('Login/login.html.twig', ['errors' => $errors]);
    }

    public function logOut(): string
    {
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        session_destroy();
        header('Location: /');
        return '';
    }

    private function validateUser(array $users): array
    {
        $errors = [];

        $passwordValidation = "/^(?=.*\d)(?=.*[a-z])(?!.* ).{6,16}$/m";

        if (empty($users['password'])) {
            $errors['password'] = '** Merci d\' entrer un mot de passe';
        } elseif (strlen($users['password']) < 6) {
            $errors['password'] = '** Le mot de passe doit contenir au moins 6 caractères';
        } elseif (!preg_match($passwordValidation, $users['password'])) {
            $errors['password'] = '** Le mot de passe doit contenir au moins 2 caractères numérique';
        }

        if (empty($users['email'])) {
            $errors['email'] = '** Ajoute un mail';
        } elseif (!filter_var($users['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = '** Utiliser le bon format email';
        }
        return $errors;
    }
}
