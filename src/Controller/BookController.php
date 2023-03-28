<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $repository): Response
    {
        $books = $repository->findAll();

        $selected = array_filter($books,
            fn($book) => $book->getReleasedAt() >= new \DateTimeImmutable('01-01-1980')
        );

        foreach ($selected as $index => $book) {
            // do something on $selected
        }

        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/show/{id}',
        name: 'app_book_show',
        requirements: ['id' => '\d+'],
        defaults: ['id' => 1],
        methods: ['GET', 'POST'],
        //priority: 1
        //condition: "request.isXmlHttpRequest()"
    )]
    //#[Route('/show/{id<\d+>?2}', name: 'app_book_show')]
    public function show(BookRepository $repository, int $id = 3): Response
    {
        $book = $repository->findBy(['isbn' => '923-12345-21']);

        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController::show - id :' . $id,
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookRepository $repository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        return $this->render('book/new.html.twig', [
            'form' => $form,
        ]);
    }
}
