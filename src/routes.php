<?php

return [
    'login' => ['LoginController', 'connect',],
    'register' => ['LoginController', 'register',],

    'logout' => ['LoginController', 'logout',],

    'profile' => ['UserController', 'index'],

    'admin' => ['AdminController','home'],
    'admin/edit' => ['AdminController', 'edit', ['id']],
    'admin/add' => ['AdminController', 'add',],
    'admin/delete' => ['AdminController', 'delete',],
    'admin/show' => ['SingleMovieController', 'showOne', ['id']],

    '' => ['MovieHomeController', 'index',],
    'rss' => ['MovieHomeController', 'rssFeed',],

    'movie' => ['SingleMovieController', 'showOne', ['id']],
    'movie/add-to-favorite' => ['SingleMovieController', 'addFavoriteMovie', ['id']],
    'movie/remove-favorite' => ['SingleMovieController', 'removeFavoriteMovie', ['id']],

    'categories' => ['CategoryController', 'index',],
];
