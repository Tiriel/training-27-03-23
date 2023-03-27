<?php

namespace App\Controller;

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
    public function details(int $id): Response
    {
        $movie = [
            'id' => $id,
            'title' => 'Star Wars - Episode IV : A New Hope',
            'releasedAt' => new \DateTimeImmutable('25 May 1977'),
            'genre' => [
                ['name' => 'Action'],
                ['name'=> 'Adventure'],
                ['name'=> 'Fantasy'],
            ],
        ];

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
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
