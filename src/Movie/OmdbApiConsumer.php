<?php

namespace App\Movie;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiConsumer
{
    public const MODE_ID = 'i';
    public const MODE_TITLE = 't';

    public function __construct(
        private readonly HttpClientInterface $omdbClient
    ) {}

    public function fetchMovie(string $mode, string $value): array
    {
        if (!\in_array($mode, [self::MODE_ID, self::MODE_TITLE])) {
            throw new \InvalidArgumentException("Invalid mode provided.");
        }

        $data = $this->omdbClient->request(
            'GET',
            '',
            ['query' => [$mode => $value]]
        )->toArray();

        if (array_key_exists('Response', $data) && $data['Response'] === 'False') {
            throw new NotFoundHttpException("Movie not found.");
        }

        return $data;
    }
}
