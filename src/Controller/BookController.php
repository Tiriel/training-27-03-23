<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    public function index(): Response
    {
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
    public function show(int $id = 3): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController::show - id :' . $id,
        ]);
    }
}
