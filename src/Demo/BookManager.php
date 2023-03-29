<?php

namespace App\Demo;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class BookManager
{
    private int $booksPerPage;

    public function __construct(
        private readonly BookRepository $repository,
        int $booksPerPage
    ) {
        $this->booksPerPage = $booksPerPage;
    }

    public function findBook(string $title): Book
    {
        return $this->repository->findOneBy(['title' => $title]);
    }
}
