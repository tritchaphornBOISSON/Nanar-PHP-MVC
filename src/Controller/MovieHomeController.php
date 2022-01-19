<?php

namespace App\Controller;

use App\Model\MovieHomeManager;

class MovieHomeController extends AbstractController
{
    public function index()
    {
        $movieHomeManager = new MovieHomeManager();
        $movies = $movieHomeManager->getThree();
        $topThreeMovies = $movieHomeManager->getTopThree();
        $comedyMovie = $movieHomeManager->getRandomComedyMovie();
        $fantasyMovie = $movieHomeManager->getRandomFantasyMovie();
        $horrorMovie = $movieHomeManager->getRandomHorrorMovie();
        $actionMovie = $movieHomeManager->getRandomActionMovie();

        return $this->twig->render('Movie/index.html.twig', [
            'movies' => $movies,
            'topThreeMovies' => $topThreeMovies,
            'comedyMovie' => $comedyMovie,
            'fantasyMovie' => $fantasyMovie,
            'horrorMovie' => $horrorMovie,
            'actionMovie' => $actionMovie,
            ]);
    }

    public function rssFeed()
    {
        $movieHomeManager = new MovieHomeManager();
        $movies = $movieHomeManager->selectAll('id', 'DESC');
        header("Content-Type: text/xml;");

        return $this->twig->render('Movie/rss.xml.twig', [
            'movies' => $movies,
            'web_url' => "http://" . $_SERVER["SERVER_NAME"] . ':8000',
        ]);
    }
}
