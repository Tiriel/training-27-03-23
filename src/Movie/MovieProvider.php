<?php

namespace App\Movie;

use App\Entity\Movie;
use App\Entity\User;
use App\Repository\MovieRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MovieProvider
{
    protected ?SymfonyStyle $io = null;

    public function __construct(
        private readonly OmdbApiConsumer $consumer,
        private readonly OmdbMovieTransformer $transformer,
        private readonly MovieRepository $repository,
        private readonly ValidatorInterface $validator,
        private readonly Security $security
    ) {}

    public function getMovie(string $mode, string $value): Movie
    {
        // call the API
        $this->io?->text('Checking movie title with OMDb...');
        $data = $this->consumer->fetchMovie($mode, $value);
        $this->io?->info('Movie found!');
        // Check if movie in DB
        if ($entity = $this->repository->findOneBy(['title' => $data['Title']])) {
            $this->io?->note('Movie already in database!');
            // if yes, return entity
            return $entity;
        }

        // if not, transform result from API
        $movie = $this->transformer->transform($data);
        $errors = $this->validator->validate($movie);

        if (\count($errors) > 0) {
            throw new \RuntimeException("Error during validation.");
        }

        if (($user = $this->security->getUser()) instanceof User) {
            $movie->setCreatedBy($this->security->getUser());
        }

        // save result to DB
        $this->io?->text('Saving movie to database...');
        $this->repository->save($movie, true);

        // return result
        return $movie;
    }

    public function setIo(SymfonyStyle $io): void
    {
        $this->io = $io;
    }
}
