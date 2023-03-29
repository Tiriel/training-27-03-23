<?php

namespace App\Movie;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Component\Form\DataTransformerInterface;

class OmdbMovieTransformer implements DataTransformerInterface
{
    public function transform(mixed $value)
    {
        if (!\is_array($value) || !\array_key_exists('Title', $value)) {
            throw new \InvalidArgumentException("Value should be an array.");
        }
        $date = 'N/A' === $value['Released'] ? $value['Year'] : $value['Released'];

        $movie = (new Movie())
            ->setTitle($value['Title'])
            ->setPoster($value['Poster'])
            ->setCountry($value['Country'])
            ->setPlot($value['Plot'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ;

        foreach (\explode(', ', $value['Genre']) as $item) {
            $movie->addGenre((new Genre())->setName($item));
        }

        return $movie;
    }

    public function reverseTransform(mixed $value)
    {
        throw new \RuntimeException("Not implemented");
    }
}
