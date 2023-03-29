<?php

namespace App\Controller;

use App\Movie\MovieProvider;
use App\Movie\OmdbApiConsumer;
use App\Movie\OmdbMovieTransformer;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie')]
class MovieController extends AbstractController
{
    #[Route('', name: 'app_movie_index')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_movie_details')]
    public function details(int $id, MovieRepository $repository): Response
    {
        return $this->render('movie/details.html.twig', [
            'movie' => $repository->find($id),
        ]);
    }

    #[Route('/omdb/{title}', name: 'app_movie_omdb')]
    public function omdb(string $title, MovieProvider $provider): Response
    {
        return $this->render('movie/details.html.twig', [
            'movie' => $provider->getMovie(OmdbApiConsumer::MODE_TITLE, $title),
        ]);
    }

    public function decades(): Response
    {
        return $this->render('movie/_decades.html.twig', [
            'decades' => [
                ['year' => '1980'],
                ['year' => '1990'],
                ['year' => '2000'],
            ],
        ])->setMaxAge(120);
    }
}
