<?php

namespace App\Movie;

use App\Entity\Movie;
use App\Repository\MovieRepository;

class MovieProvider
{
    public function __construct(
        private readonly OmdbApiConsumer $consumer,
        private readonly OmdbMovieTransformer $transformer,
        private readonly MovieRepository $repository
    ) {}

    public function getMovie(string $mode, string $value): Movie
    {
        // call the API
        $data = $this->consumer->fetchMovie($mode, $value);
        // Check if movie in DB
        if ($entity = $this->repository->findOneBy(['title' => $data['Title']])) {
            // if yes, return entity
            return $entity;
        }

        // if not, transform result from API
        $movie = $this->transformer->transform($data);
        // save result to DB
        $this->repository->save($movie, true);

        // return result
        return $movie;
    }
}
